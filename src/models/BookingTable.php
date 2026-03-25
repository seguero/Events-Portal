<?php
namespace models;

use framework\Database;
use framework\DatabaseHelper;
use PDO;

/*
 * BookingTable
 *
 * Data-access layer for the bookings table.
 * Provides methods for retrieving and managing booking records
 * while delegating SQL execution to the reusable DatabaseHelper.
 */
class BookingTable
{
    /* Database helper configured for the events table */
    private DatabaseHelper $table;
    private PDO $pdo;

    /* Initialise helper with connection, table name and model mapping */
    public function __construct()
    {
        $this->pdo = Database::getConnection();
        $this->table = new DatabaseHelper(
            $this->pdo,
            'bookings',
            'bookingid',
            BookingModel::class
        );
    }

    /* Retrieve a single booking by its primary key */
    public function findById(int $bookingid): object|false
    {
        return $this->table->find('bookingid', $bookingid);
    }
    
    /* Insert or update a booking record */
    public function save(array $bookingData): string|int
    {
        return $this->table->save($bookingData);
    }

    /* Delete a bookingt by its primary key */
    public function delete(int $bookingid): void
    {
        $this->table->delete($bookingid);
    }

    /* Check if a user already booked an event */
    public function exists(int $userid, int $eventid): bool
    {
        $stmt = Database::getConnection()->prepare(
            'SELECT COUNT(*) FROM bookings WHERE userid = :userid AND eventid = :eventid'
        );

        $stmt->execute([
            'userid' => $userid,
            'eventid' => $eventid
        ]);

        return (int)$stmt->fetchColumn() > 0;
    }

    /* Get bookings for a specific user */
    public function findByUser(int $userid): array
    {
        return $this->table->findWhere(['userid' => $userid]);
    }

    /* Get upcoming bookings for a specific user */
    public function findUpcomingByUser(int $userid): array
    {
        $stmt = Database::getConnection()->prepare(
            'SELECT b.*, e.title, e.event_date, e.location, e.category
            FROM bookings b
            JOIN events e ON b.eventid = e.eventid
            WHERE b.userid = :userid
            AND e.event_date >= NOW()
            ORDER BY e.event_date ASC'
        );

        $stmt->execute([
            'userid' => $userid
        ]);

        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    /* Get past bookings for a specific user */
    public function findPastByUser(int $userid): array
    {
        $stmt = Database::getConnection()->prepare(
            'SELECT b.*, e.title, e.event_date, e.location, e.category
            FROM bookings b
            JOIN events e ON b.eventid = e.eventid
            WHERE b.userid = :userid
            AND e.event_date < NOW()
            ORDER BY e.event_date DESC'
        );

        $stmt->execute([
            'userid' => $userid
        ]);

        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }
}