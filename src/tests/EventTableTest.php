<?php

use PHPUnit\Framework\TestCase;
use framework\Database;
use models\EventTable;

/*
 * EventTableTest
 *
 * Whitebox/integration tests for event database logic.
 * These tests cover the public AJAX filtering feature and the admin
 * create/edit/delete event management workflow.
 */
final class EventTableTest extends TestCase
{
    private PDO $pdo;
    private EventTable $events;

    protected function setUp(): void
    {
        $this->pdo = Database::getConnection();
        $this->events = new EventTable();

        $this->resetTestData();
        $this->seedFilterEvents();
    }

    protected function tearDown(): void
    {
        $this->resetTestData();
    }

    /*
     * Clean up only test events and related bookings.
     * This keeps the development database safe after tests are run.
     */
    private function resetTestData(): void
    {
        $this->pdo->exec(
            "DELETE FROM bookings
             WHERE eventid IN (
                 SELECT eventid FROM events
                 WHERE title LIKE 'PHPUnit Event Test%'
                    OR title LIKE 'PHPUnit Filter Test%'
             )"
        );

        $this->pdo->exec(
            "DELETE FROM events
             WHERE title LIKE 'PHPUnit Event Test%'
                OR title LIKE 'PHPUnit Filter Test%'"
        );
    }

    /*
     * Insert events used by the filtering tests.
     * Each event has different category, location, and date values.
     */
    private function seedFilterEvents(): void
    {
        $this->insertEvent([
            'event_type' => 'Workshop',
            'category' => 'Technology',
            'title' => 'PHPUnit Filter Test PHP Workshop',
            'description' => 'A workshop about PHP and testing.',
            'event_date' => '2026-03-10 10:00:00',
            'location' => 'Northampton',
            'image_path' => null
        ]);

        $this->insertEvent([
            'event_type' => 'Talk',
            'category' => 'Business',
            'title' => 'PHPUnit Filter Test Business Talk',
            'description' => 'A talk about small business growth.',
            'event_date' => '2026-04-15 14:00:00',
            'location' => 'London',
            'image_path' => null
        ]);

        $this->insertEvent([
            'event_type' => 'Seminar',
            'category' => 'Technology',
            'title' => 'PHPUnit Filter Test JavaScript Seminar',
            'description' => 'A seminar about JavaScript.',
            'event_date' => '2026-05-20 09:30:00',
            'location' => 'Birmingham',
            'image_path' => null
        ]);
    }

    /*
     * Insert an event directly into the database for controlled test setup.
     */
    private function insertEvent(array $eventData): int
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO events
                (event_type, category, title, description, event_date, location, image_path, created_at)
             VALUES
                (:event_type, :category, :title, :description, :event_date, :location, :image_path, NOW())'
        );

        $stmt->execute($eventData);

        return (int) $this->pdo->lastInsertId();
    }

    /*
     * Create an event through EventTable::save().
     * This is used to test the same persistence method used by admin forms.
     */
    private function createSavedEvent(string $title = 'PHPUnit Event Test Created Event'): int
    {
        return (int) $this->events->save([
            'event_type' => 'Workshop',
            'category' => 'Testing',
            'title' => $title,
            'description' => 'Created through EventTable::save().',
            'event_date' => '2026-08-01 10:00:00',
            'location' => 'Northampton',
            'image_path' => null
        ]);
    }

    /*
     * Keyword search should include matching events and exclude unrelated ones.
     */
    public function testFilterEventsCanSearchByKeyword(): void
    {
        $result = $this->events->filterEvents([
            'q' => 'PHP Workshop',
            'sort' => 'date'
        ]);

        $titles = array_map(fn ($event) => $event->title, $result);

        $this->assertContains('PHPUnit Filter Test PHP Workshop', $titles);
        $this->assertNotContains('PHPUnit Filter Test Business Talk', $titles);
    }

    /*
     * Category filtering should return only events in the selected category.
     */
    public function testFilterEventsCanFilterByCategory(): void
    {
        $result = $this->events->filterEvents([
            'category' => ['Technology'],
            'sort' => 'date'
        ]);

        $titles = array_map(fn ($event) => $event->title, $result);

        $this->assertContains('PHPUnit Filter Test PHP Workshop', $titles);
        $this->assertContains('PHPUnit Filter Test JavaScript Seminar', $titles);
        $this->assertNotContains('PHPUnit Filter Test Business Talk', $titles);
    }

    /*
     * Location filtering should return events from the selected location only.
     */
    public function testFilterEventsCanFilterByLocation(): void
    {
        $result = $this->events->filterEvents([
            'location' => ['London'],
            'sort' => 'date'
        ]);

        $titles = array_map(fn ($event) => $event->title, $result);

        $this->assertContains('PHPUnit Filter Test Business Talk', $titles);
        $this->assertNotContains('PHPUnit Filter Test PHP Workshop', $titles);
        $this->assertNotContains('PHPUnit Filter Test JavaScript Seminar', $titles);
    }

    /*
     * Date range filtering should include events inside the selected range only.
     */
    public function testFilterEventsCanFilterByDateRange(): void
    {
        $result = $this->events->filterEvents([
            'start_date' => '2026-04-01',
            'end_date' => '2026-04-30',
            'sort' => 'date'
        ]);

        $titles = array_map(fn ($event) => $event->title, $result);

        $this->assertContains('PHPUnit Filter Test Business Talk', $titles);
        $this->assertNotContains('PHPUnit Filter Test PHP Workshop', $titles);
        $this->assertNotContains('PHPUnit Filter Test JavaScript Seminar', $titles);
    }

    /*
     * Location sorting should order matching results alphabetically by location.
     */
    public function testFilterEventsCanSortByLocation(): void
    {
        $result = $this->events->filterEvents([
            'q' => 'PHPUnit Filter Test',
            'sort' => 'location'
        ]);

        $locations = array_map(fn ($event) => $event->location, $result);

        $this->assertSame(['Birmingham', 'London', 'Northampton'], $locations);
    }

    /*
     * save() should create an event that can be retrieved by ID.
     */
    public function testSaveCanCreateEvent(): void
    {
        $eventid = $this->createSavedEvent();

        $event = $this->events->findById($eventid);

        $this->assertNotFalse($event);
        $this->assertSame('PHPUnit Event Test Created Event', $event->title);
        $this->assertSame('Testing', $event->category);
        $this->assertSame('Northampton', $event->location);
    }

    /*
     * save() should update an existing event when eventid is provided.
     */
    public function testSaveCanUpdateEvent(): void
    {
        $eventid = $this->createSavedEvent();

        $this->events->save([
            'eventid' => $eventid,
            'event_type' => 'Seminar',
            'category' => 'Updated Testing',
            'title' => 'PHPUnit Event Test Updated Event',
            'description' => 'Updated through EventTable::save().',
            'event_date' => '2026-08-02 12:00:00',
            'location' => 'London',
            'image_path' => null
        ]);

        $updatedEvent = $this->events->findById($eventid);

        $this->assertNotFalse($updatedEvent);
        $this->assertSame('PHPUnit Event Test Updated Event', $updatedEvent->title);
        $this->assertSame('Seminar', $updatedEvent->event_type);
        $this->assertSame('London', $updatedEvent->location);
    }

    /*
     * delete() should remove an event from the database.
     */
    public function testDeleteRemovesEvent(): void
    {
        $eventid = $this->createSavedEvent();

        $this->events->delete($eventid);

        $deletedEvent = $this->events->findById($eventid);

        $this->assertFalse($deletedEvent);
    }
}