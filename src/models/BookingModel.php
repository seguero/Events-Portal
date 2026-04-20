<?php
namespace models;

/*
 * BookingModel
 *
 * Represents a single record from the bookings table.
 * Instances are populated automatically by PDO when
 * query results are fetched using FETCH_CLASS.
 */
class BookingModel
{
    /* Primary key */
    public ?int $bookingid = null;

    /* User ID */
    public ?int $userid = null;

    /* Event ID */
    public ?int $eventid = null;

    /* Booking date and time */
    public ?string $booked_at = null;

    /* Email confirmation status */
    public int $confirmation_sent = 0;

    /* Email confirmation sent timestamp */
    public ?string $confirmation_sent_at = null;

    /* Reminder email status */
    public int $reminder_sent = 0;

    /* Reminder sent timestamp */
    public ?string $reminder_sent_at = null;
}