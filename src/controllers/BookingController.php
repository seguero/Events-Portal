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
            if (session_status() !== PHP_SESSION_ACTIVE) {
                session_start();
            }
            $_SESSION['flash_message'] = 'You need to log in to view your bookings.';
            $_SESSION['flash_type'] = 'info';
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

    private function isAjaxRequest(): bool
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    private function jsonResponse(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    /* Create a new booking for an event */
    public function store(): array
    {
        if (empty($_SESSION['user'])) {
            return $this->bookingError('Please log in to book this event.', '/account', 401);
        }

        $eventid = (int) ($_POST['eventid'] ?? 0);
        $userid = (int) $_SESSION['user']['userid'];

        if (!$eventid) {
            return $this->bookingError('Invalid event selected.', '/events', 422);
        }

        $event = $this->events->findById($eventid);

        if (!$event) {
            return $this->bookingError('Event not found.', '/events', 404);
        }

        if (strtotime($event->event_date) < time()) {
            return $this->bookingError('This event has already ended.', '/events/show/' . $eventid, 422);
        }

        /* Use your existing duplicate-booking check here */
        if ($this->bookings->exists($userid, $eventid)) {
            return $this->bookingError('You have already booked this event.', '/events/show/' . $eventid, 409);
        }

        /* Save booking using your existing booking model method */
        $this->bookings->save([
            'userid' => $userid,
            'eventid' => $eventid
        ]);

        if ($this->isAjaxRequest()) {
            $this->jsonResponse([
                'success' => true,
                'message' => 'Event booked successfully.',
                'alreadyBookedText' => 'You have already booked this event.'
            ]);
        }

        return ['redirect' => '/booking'];
    }

    private function bookingError(string $message, string $redirect, int $statusCode = 422): array
    {
        if ($this->isAjaxRequest()) {
            $this->jsonResponse([
                'success' => false,
                'message' => $message
            ], $statusCode);
        }

        return ['redirect' => $redirect];
    }

    /* Cancel an existing booking */
    public function cancel(): array
    {
        /* Must be logged in */
        if (!isset($_SESSION['user'])) {
            if (session_status() !== PHP_SESSION_ACTIVE) {
                session_start();
            }
            $_SESSION['flash_message'] = 'You need to log in to cancel your bookings.';
            $_SESSION['flash_type'] = 'info';
            return ['redirect' => '/account'];
        }

        $bookingId = $_POST['bookingid'] ?? null;

        /* Validate booking ID */
        if (!$bookingId) {
            if (session_status() !== PHP_SESSION_ACTIVE) {
                session_start();
            }
            $_SESSION['flash_message'] = 'Invalid booking selected';
            $_SESSION['flash_type'] = 'info';

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