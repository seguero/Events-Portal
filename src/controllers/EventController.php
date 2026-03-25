<?php
namespace controllers;

use models\EventTable;
use models\BookingTable;

/*
 * EventController
 *
 * Handles the public events page.
 * Retrieves event data and filter options from the EventTable model
 * and passes them to the events view for display.
 */
class EventController
{
    /* Model used to interact with the events table */
    private EventTable $events;

    /* Model used to interact with the bookings table */
    private BookingTable $bookings;

    /* Initialise the required models */
    public function __construct()
    {
        $this->events = new EventTable();
        $this->bookings = new BookingTable();
    }

    /* Display the events listing page */
    public function index(): array
    {
        /* Retrieve all events from the database */
        $eventList = $this->events->findAll();

        /* Retrieve distinct event types for filtering */
        $eventTypes = $this->events->findEventTypes();

        /* Retrieve distinct event locations for filtering */
        $locations = $this->events->findLocations();

        /* Retrieve distinct categories for filtering */
        $categories = $this->events->findCategories();

        /* Return view configuration with data for the events page */
        return [
            'title' => 'Events',
            'template' => 'events.html.php',
            'styles' => ['events.css', 'cards.css'],
            'variables' => [
                'events' => $eventList,
                'eventTypes' => $eventTypes,
                'locations' => $locations,
                'categories' => $categories
            ]
        ];
    }

    /* Show details for a single event */
    public function show(int $id): array
    {
        /* Retrieve the selected event by ID */
        $event = $this->events->findById($id);

        /* Return 404 page if event does not exist */
        if (!$event) {
            return [
                'title' => 'Event not found',
                'template' => '404.html.php',
                'styles' => ['events.css'],
                'variables' => []
            ];
        }

        /* Default booking state for guests */
        $alreadyBooked = false;

        /* Check whether the logged-in user has already booked this event */
        if (isset($_SESSION['user'])) {
            $alreadyBooked = $this->bookings->exists(
                $_SESSION['user']['userid'],
                $id
            );
        }

        /* Return event detail page with booking state */
        return [
            'title' => $event->title,
            'template' => 'event.html.php',
            'styles' => ['event.css'],
            'variables' => [
                'event' => $event,
                'alreadyBooked' => $alreadyBooked
            ]
        ];
    }
}