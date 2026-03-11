<?php
namespace models;

use framework\Database;
use framework\DatabaseHelper;

/*
 * EventTable
 *
 * Data-access layer for the events table.
 * Provides methods for retrieving and managing event records
 * while delegating SQL execution to the reusable DatabaseHelper.
 */
class EventTable
{
    /* Database helper configured for the events table */
    private DatabaseHelper $table;

    /* Initialise helper with connection, table name and model mapping */
    public function __construct()
    {
        $this->table = new DatabaseHelper(
            Database::getConnection(),
            'events',
            'eventid',
            EventModel::class
        );
    }

    /* Retrieve all events */
    public function findAll(): array
    {
        return $this->table->findAll();
    }

    /* Retrieve a single event by its primary key */
    public function findById(int $eventid): object|false
    {
        return $this->table->find('eventid', $eventid);
    }

    /* Retrieve distinct event types (used for filter sidebar) */
    public function findEventTypes(): array
    {
        return $this->table->findDistinct('event_type');
    }

    /* Retrieve distinct event locations (used for filter sidebar) */
    public function findLocations(): array
    {
        return $this->table->findDistinct('location');
    }

    /* Insert or update an event record */
    public function save(array $eventData): string|int
    {
        return $this->table->save($eventData);
    }

    /* Delete an event by its primary key */
    public function delete(int $eventid): void
    {
        $this->table->delete($eventid);
    }
}