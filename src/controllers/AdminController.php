<?php
namespace controllers;

use models\EventTable;

/*
 * AdminController
 *
 * Handles admin-related pages and actions for event management.
 * The controller checks admin permissions and communicates with
 * the EventTable model to create, update and delete events.
 */
class AdminController
{
    /* Model used to interact with the events database table */
    private EventTable $events;

    /* Initialise the EventTable model when the controller is created */
    public function __construct()
    {
        $this->events = new EventTable();
    }

    /* Display the admin dashboard with a list of all events */
    public function index(): array
    {
        /* Retrieve all events from the database */
        $eventList = $this->events->findAll();

        /* Ensure the current user has admin privileges */
        if ($result = $this->requireAdmin()) {
            return $result;
        }

        /* Return the admin view with event data */
        return [
            'title' => 'Admin',
            'template' => 'admin.html.php',
            'styles' => ['admin.css'],
            'variables' => [
                'events' => $eventList
            ]
        ];
    }

    /* Verify that the user is logged in and has the admin role */
    private function requireAdmin(): ?array
    {
        /* Redirect to account page if user is not logged in */
        if (empty($_SESSION['loggedIn']) || empty($_SESSION['user'])) {
            return ['redirect' => '/account'];
        }

        /* Redirect to home if the user is not an admin */
        if ($_SESSION['user']['role'] !== 'admin') {
            return ['redirect' => '/home'];
        }

        /* Allow access if checks pass */
        return null;
    }

    /* Render the create event form for administrators */
    public function create(): ?array
    {
        /* Ensure only admins can access the form */
        if ($result = $this->requireAdmin()) {
            return $result;
        }

        /* Return view for creating a new event */
        return [
            'title' => 'Create Event',
            'template' => 'createEvent.html.php',
            'styles' => ['admin-form.css'],
            'variables' => []
        ];
    }

    /* Process the create event form submission */
    public function store(): ?array
    {
        /* Ensure only admins can create events */
        if ($result = $this->requireAdmin()) {
            return $result;
        }

        /* Retrieve form values from POST request */
        $event_title = $_POST['title'] ?? '';
        $event_type = $_POST['event_type'] ?? '';
        $category = $_POST['category'] ?? '';
        $location = $_POST['location'] ?? '';
        $description = $_POST['description'] ?? '';

        /* Convert input date into database datetime format */
        $date = new \DateTime($_POST['event_date']);
        $event_date = $date->format('Y-m-d H:i:s');

        /* Save the new event using the model */
        $this->events->save([
            'title' => $event_title,
            'event_type' => $event_type,
            'category' => $category,
            'event_date' => $event_date,
            'location' => $location,
            'description' => $description
        ]);

        /* Redirect back to the admin panel */
        return ['redirect' => '/admin'];
    }

    /* Display the edit event form */
    public function edit(): ?array
    {
        /* Ensure only admins can edit events */
        if ($result = $this->requireAdmin()) {
            return $result;
        }

        /* Get event ID from the URL */
        $id = $_GET['id'] ?? null;

        /* Redirect if no ID was provided */
        if (!$id) {
            return ['redirect' => '/admin'];
        }

        /* Retrieve the selected event from the database */
        $event = $this->events->findById((int)$id);

        /* Redirect if event does not exist */
        if (!$event) {
            return ['redirect' => '/admin'];
        }

        /* Return edit form view with event data */
        return [
            'title' => 'Edit Event',
            'template' => 'editEvent.html.php',
            'styles' => ['admin-form.css'],
            'variables' => [
                'event' => $event
            ]
        ];
    }

    /* Handle submission of edited event data */
    public function update(): ?array
    {
        /* Save updated event details using the model */
        $this->events->save([
            'eventid' => $_POST['eventid'],
            'title' => $_POST['title'],
            'event_type' => $_POST['event_type'],
            'category' => $_POST['category'],
            'event_date' => $_POST['event_date'],
            'location' => $_POST['location'],
            'description' => $_POST['description']
        ]);

        /* Redirect to the admin dashboard */
        return ['redirect' => '/admin'];
    }

    /* Delete an event selected by the administrator */
    public function delete(): ?array 
    {
        /* Ensure only admins can delete events */
        if ($result = $this->requireAdmin()) {
            return $result;
        }

        /* Get event ID from URL */
        $id = $_GET['id'] ?? null;

        /* Redirect if ID is missing */
        if (!$id) {
            return ['redirect' => '/admin'];
        }

        /* Confirm event exists before deletion */
        $event = $this->events->findById((int)$id);

        /* Redirect if event does not exist */
        if (!$event) {
            return ['redirect' => '/admin'];
        }

        /* Remove event from the database */
        $this->events->delete($id);

        /* Redirect back to the admin page */
        return ['redirect' => '/admin'];
    }
}