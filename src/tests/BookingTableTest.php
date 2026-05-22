<?php

use PHPUnit\Framework\TestCase;
use framework\Database;
use models\BookingTable;

/*
 * BookingTableTest
 *
 * Whitebox/integration tests for booking-related database logic.
 * These tests use controlled test records to check that duplicate
 * booking detection works correctly.
 */
final class BookingTableTest extends TestCase
{
    private PDO $pdo;
    private BookingTable $bookings;
    private int $testUserId;
    private int $testEventId;
    private int $otherEventId;

    /*
     * Prepare a clean test state before each test.
     *
     * Each test gets a fresh user and two fresh events so the tests are
     * repeatable and do not depend on existing application data.
     */
    protected function setUp(): void
    {
        $this->pdo = Database::getConnection();
        $this->bookings = new BookingTable();

        $this->resetTestData();
        $this->seedUserAndEvents();
    }

    /*
     * Remove test records after each test.
     * This prevents PHPUnit data from appearing in the real application.
     */
    protected function tearDown(): void
    {
        $this->resetTestData();
    }

    /*
     * Delete only records created by these tests.
     */
    private function resetTestData(): void
    {
        $this->pdo->exec(
            "DELETE FROM bookings
             WHERE userid IN (
                 SELECT userid FROM users WHERE email = 'phpunit@example.com'
             )"
        );

        $this->pdo->exec(
            "DELETE FROM bookings
             WHERE eventid IN (
                 SELECT eventid FROM events
                 WHERE title LIKE 'PHPUnit Booking Test%'
             )"
        );

        $this->pdo->exec(
            "DELETE FROM events
             WHERE title LIKE 'PHPUnit Booking Test%'"
        );

        $this->pdo->exec(
            "DELETE FROM users
             WHERE email = 'phpunit@example.com'"
        );
    }

    /*
     * Insert a known user and two known events for the booking tests.
     */
    private function seedUserAndEvents(): void
    {
        $userStmt = $this->pdo->prepare(
            'INSERT INTO users (firstname, lastname, email, password, role, created_at)
             VALUES (:firstname, :lastname, :email, :password, :role, NOW())'
        );

        $userStmt->execute([
            'firstname' => 'PHPUnit',
            'lastname' => 'User',
            'email' => 'phpunit@example.com',
            'password' => password_hash('password123', PASSWORD_DEFAULT),
            'role' => 'user'
        ]);

        $this->testUserId = (int) $this->pdo->lastInsertId();

        $this->testEventId = $this->createTestEvent(
            'PHPUnit Booking Test Main Event',
            '2026-06-01 10:00:00'
        );

        $this->otherEventId = $this->createTestEvent(
            'PHPUnit Booking Test Other Event',
            '2026-06-02 10:00:00'
        );
    }

    /*
     * Create one event and return its generated ID.
     */
    private function createTestEvent(string $title, string $eventDate): int
    {
        $eventStmt = $this->pdo->prepare(
            'INSERT INTO events
                (event_type, category, title, description, event_date, location, image_path, created_at)
             VALUES
                (:event_type, :category, :title, :description, :event_date, :location, :image_path, NOW())'
        );

        $eventStmt->execute([
            'event_type' => 'Workshop',
            'category' => 'Testing',
            'title' => $title,
            'description' => 'Event used for PHPUnit booking tests.',
            'event_date' => $eventDate,
            'location' => 'Northampton',
            'image_path' => null,
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    /*
     * Insert one booking for the test user.
     */
    private function createBooking(int $eventId): void
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO bookings
                (userid, eventid, booked_at, confirmation_sent, reminder_sent)
             VALUES
                (:userid, :eventid, NOW(), 0, 0)'
        );

        $stmt->execute([
            'userid' => $this->testUserId,
            'eventid' => $eventId
        ]);
    }

    /*
     * A user should not appear to have booked an event before a booking exists.
     */
    public function testExistsReturnsFalseWhenBookingDoesNotExist(): void
    {
        $result = $this->bookings->exists($this->testUserId, $this->testEventId);

        $this->assertFalse($result);
    }

    /*
     * A user should be detected as booked after a matching booking is inserted.
     */
    public function testExistsReturnsTrueWhenBookingExists(): void
    {
        $this->createBooking($this->testEventId);

        $result = $this->bookings->exists($this->testUserId, $this->testEventId);

        $this->assertTrue($result);
    }

    /*
     * A booking for one event must not count as a booking for another event.
     */
    public function testExistsReturnsFalseForDifferentEvent(): void
    {
        $this->createBooking($this->testEventId);

        $result = $this->bookings->exists($this->testUserId, $this->otherEventId);

        $this->assertFalse($result);
    }
}