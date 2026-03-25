<?php
namespace controllers;

use models\EventTable;
use models\BookingTable;

/*
 * BookingController
 *
 * Handles booking-related pages and actions.
 * The controller communicates with the BookingTable model to create, update and delete bookings.
 */
class BookingController
{
    /* Model used to interact with the bookings database table */
    private BookingTable $bookings;

    /* Model used to interact with the events database table */
    private EventTable $events;

    /* Initialise the BookingTable and EventTable models */
    public function __construct()
    {
        $this->bookings = new BookingTable();
        $this->events = new EventTable();
    }

    /* Display the user's bookings page */
    public function index(): array
    {
        /* Must be logged in to view bookings */
        if (!isset($_SESSION['user'])) {
            return ['redirect' => '/account'];
        }

        $userId = $_SESSION['user']['userid'];

        /* Retrieve the user's bookings, split into upcoming and past */
        $upcomingBookings = $this->bookings->findUpcomingByUser($userId);
        $pastBookings = $this->bookings->findPastByUser($userId);

        /* Return the bookings page with the user's bookings */
        return [
            'title' => 'My Bookings',
            'template' => 'bookings.html.php',
            'styles' => ['bookings.css'],
            'variables' => [
                'upcomingBookings' => $upcomingBookings,
                'pastBookings' => $pastBookings
            ]
        ];
    }

    /* Create a new booking for an event */
    public function store(): array
    {
        /* Must be logged in */
        if (!isset($_SESSION['user'])) {
            return ['redirect' => '/account'];
        }

        $userId = $_SESSION['user']['userid'];
        $eventId = $_POST['eventid'] ?? null;

        /* Validate event ID */
        if (!$eventId) {
            return ['redirect' => '/events'];
        }

        /* Check event exists */
        $event = $this->events->findById((int)$eventId);

        if (!$event) {
            return [
                'title' => 'Error',
                'template' => 'event.html.php',
                'variables' => [
                    'error' => 'Event not found'
                ]
            ];
        }

        /* Prevent booking past events */
        if (strtotime($event->event_date) < time()) {
            return [
                'redirect' => '/event/show/' . $eventId
            ];
        }

        /* Prevent duplicate bookings */
        if ($this->bookings->exists($userId, (int)$eventId)) {
            return [
                'redirect' => '/event/show/' . $eventId
            ];
        }

        /* Create booking */
        $this->bookings->save([
            'userid' => $userId,
            'eventid' => $eventId,
        ]);

        /* Redirect after booking */
        return [
            'redirect' => '/event/show/' . $eventId
        ];
    }

    /* Cancel an existing booking */
    public function cancel(): array
    {
        /* Must be logged in */
        if (!isset($_SESSION['user'])) {
            return ['redirect' => '/account'];
        }

        $bookingId = $_POST['bookingid'] ?? null;

        /* Validate booking ID */
        if (!$bookingId) {
            return ['redirect' => '/booking'];
        }

        /* Retrieve booking */
        $booking = $this->bookings->findById((int)$bookingId);

        /* Ensure booking exists and belongs to the logged-in user */
        if (!$booking || $booking->userid != $_SESSION['user']['userid']) {
            return ['redirect' => '/booking'];
        }

        /* Delete the booking */
        $this->bookings->delete((int)$bookingId);

        /* Redirect after cancellation */
        return ['redirect' => '/booking'];
    }
}