<?php
namespace models;

use framework\Database;
use framework\DatabaseHelper;
use PDO;

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

    public function findCategories(): array
    {
        return $this->table->findDistinct('category');
    }

    /* Search and filter events dynamically for the public events page. */
    public function filterEvents(array $filters): array
    {
        $pdo = Database::getConnection();

        $sql = "SELECT * FROM events WHERE 1=1";
        $params = [];

        /* Keyword search across multiple text fields */
        if (!empty($filters['q'])) {
            $sql .= " AND (
                title LIKE :search
                OR event_type LIKE :search
                OR category LIKE :search
                OR location LIKE :search
                OR description LIKE :search
            )";
            $params['search'] = '%' . $filters['q'] . '%';
        }

        /* Event type checkbox filter */
        if (!empty($filters['event_type']) && is_array($filters['event_type'])) {
            $placeholders = [];
            foreach ($filters['event_type'] as $index => $type) {
                $key = 'event_type_' . $index;
                $placeholders[] = ':' . $key;
                $params[$key] = $type;
            }
            $sql .= " AND event_type IN (" . implode(', ', $placeholders) . ")";
        }

        /* Category checkbox filter */
        if (!empty($filters['category']) && is_array($filters['category'])) {
            $placeholders = [];
            foreach ($filters['category'] as $index => $category) {
                $key = 'category_' . $index;
                $placeholders[] = ':' . $key;
                $params[$key] = $category;
            }
            $sql .= " AND category IN (" . implode(', ', $placeholders) . ")";
        }

        /* Location checkbox filter */
        if (!empty($filters['location']) && is_array($filters['location'])) {
            $placeholders = [];
            foreach ($filters['location'] as $index => $location) {
                $key = 'location_' . $index;
                $placeholders[] = ':' . $key;
                $params[$key] = $location;
            }
            $sql .= " AND location IN (" . implode(', ', $placeholders) . ")";
        }

        /* Date radio filter */
        if (!empty($filters['date'])) {
            switch ($filters['date']) {
                case 'today':
                    $sql .= " AND DATE(event_date) = CURDATE()";
                    break;

                case 'week':
                    $sql .= " AND YEARWEEK(event_date, 1) = YEARWEEK(CURDATE(), 1)";
                    break;

                case 'month':
                    $sql .= " AND MONTH(event_date) = MONTH(CURDATE())
                              AND YEAR(event_date) = YEAR(CURDATE())";
                    break;
            }
        }

        /* Sort control */
        $sort = $filters['sort'] ?? 'date';

        switch ($sort) {
            case 'newest':
                $sql .= " ORDER BY created_at DESC, event_date DESC";
                break;

            case 'location':
                $sql .= " ORDER BY location ASC, event_date ASC";
                break;

            case 'date':
            default:
                $sql .= " ORDER BY event_date ASC";
                break;
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_CLASS, EventModel::class);
    }

    /* Search events by keyword for the admin events table. */
    public function adminSearch(string $term): array
    {
        $pdo = Database::getConnection();

        $sql = "SELECT *
                FROM events
                WHERE title LIKE :term
                OR event_type LIKE :term
                OR category LIKE :term
                OR location LIKE :term
                OR description LIKE :term
                ORDER BY event_date ASC";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'term' => '%' . $term . '%'
        ]);

        return $stmt->fetchAll(PDO::FETCH_CLASS, EventModel::class);
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