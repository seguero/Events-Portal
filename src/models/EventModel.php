<?php
namespace models;

/*
 * EventModel
 *
 * Represents a single record from the events table.
 * Instances are populated automatically by PDO when
 * query results are fetched using FETCH_CLASS.
 */
class EventModel
{
    /* Primary key */
    public ?int $eventid = null;

    /* Event category/type */
    public string $event_type = '';

    /* Event title */
    public string $title = '';

    /* Detailed event description */
    public string $description = '';

    /* Date and time of the event */
    public ?string $event_date = null;

    /* Event location */
    public string $location = '';

    /* Path to event image */
    public ?string $image_path = null;

    /* Timestamp when the event record was created */
    public ?string $created_at = null;
}