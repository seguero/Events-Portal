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
            'scripts' => ['admin.js'],
            'variables' => [
                'events' => $eventList
            ]
        ];
    }

    /* Verify that the user is logged in and has the admin role */
    private function requireAdmin(): ?array
    {
        if (empty($_SESSION['loggedIn']) || empty($_SESSION['user'])) {
            $_SESSION['flash_message'] = 'Please log in to access that page.';
            $_SESSION['flash_type'] = 'error';
            return ['redirect' => '/account'];
        }

        if ($_SESSION['user']['role'] !== 'admin') {
            $_SESSION['flash_message'] = 'You do not have permission to access the admin area.';
            $_SESSION['flash_type'] = 'error';
            return ['redirect' => '/home'];
        }

        return null;
    }

    /* Render the create event form for administrators */
    public function create(): ?array
    {
        /* Ensure only admins can access the form */
        if ($result = $this->requireAdmin()) {
            return $result;
        }

        /* Load a JavaScript file to submit the form asynchronously. */
        return [
            'title' => 'Create Event',
            'template' => 'createEvent.html.php',
            'styles' => ['admin-form.css'],
            'scripts' => ['createEvent.js'],
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

        /* Retrieve and trim form values from POST request */
        $event_title = trim($_POST['title'] ?? '');
        $event_type = trim($_POST['event_type'] ?? '');
        $category = trim($_POST['category'] ?? '');
        $location = trim($_POST['location'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $raw_date = $_POST['event_date'] ?? '';

        /* Basic validation */
        if ($event_title === '' || $raw_date === '' || $location === '') {
            return $this->storeError('Title, date and location are required.');
        }

        /* Validate and convert input date into database datetime format */
        try {
            $date = new \DateTime($raw_date);
            $event_date = $date->format('Y-m-d H:i:s');
        } catch (\Exception $e) {
            return $this->storeError('Please enter a valid event date.');
        }

        /* Save the new event using the model */
        $newId = $this->events->save([
            'title' => $event_title,
            'event_type' => $event_type,
            'category' => $category,
            'event_date' => $event_date,
            'location' => $location,
            'description' => $description
        ]);

        /* Return JSON success response for fetch requests. */
        if ($this->isAjaxRequest()) {
            $this->jsonResponse([
                'success' => true,
                'message' => 'Event created successfully.',
                'redirect' => '/admin',
                'event' => [
                    'eventid' => $newId,
                    'title' => $event_title,
                    'event_type' => $event_type,
                    'category' => $category,
                    'event_date' => $event_date,
                    'location' => $location,
                    'description' => $description
                ]
            ]);
        }

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
            if (session_status() !== PHP_SESSION_ACTIVE) {
                session_start();
            }
            $_SESSION['flash_message'] = 'Event not found.';
            $_SESSION['flash_type'] = 'info';

            return ['redirect' => '/admin'];
        }

        /* Retrieve the selected event from the database */
        $event = $this->events->findById((int)$id);

        /* Redirect if event does not exist */
        if (!$event) {
            if (session_status() !== PHP_SESSION_ACTIVE) {
                session_start();
            }
            $_SESSION['flash_message'] = 'Event not found.';
            $_SESSION['flash_type'] = 'info';

            return ['redirect' => '/admin'];
        }

        /* Load a JavaScript file to submit the edit form asynchronously. */
        return [
            'title' => 'Edit Event',
            'template' => 'editEvent.html.php',
            'styles' => ['admin-form.css'],
            'scripts' => ['editEvent.js'],
            'variables' => [
                'event' => $event
            ]
        ];
    }

    /* Handle submission of edited event data */
    public function update(): ?array
    {
        /* Ensure only admins can update events as well. */
        if ($result = $this->requireAdmin()) {
            return $result;
        }

        $eventid = $_POST['eventid'] ?? '';
        $title = trim($_POST['title'] ?? '');
        $event_type = trim($_POST['event_type'] ?? '');
        $category = trim($_POST['category'] ?? '');
        $location = trim($_POST['location'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $raw_date = $_POST['event_date'] ?? '';

        if ($eventid === '' || $title === '' || $raw_date === '' || $location === '') {
            return $this->updateError('Title, date and location are required.', (int) $eventid);
        }

        try {
            $date = new \DateTime($raw_date);
            $event_date = $date->format('Y-m-d H:i:s');
        } catch (\Exception $e) {
            return $this->updateError('Please enter a valid event date.', (int) $eventid);
        }

        /* Save updated event details using the model */
        $this->events->save([
            'eventid' => $eventid,
            'title' => $title,
            'event_type' => $event_type,
            'category' => $category,
            'event_date' => $event_date,
            'location' => $location,
            'description' => $description
        ]);

        /* Return JSON success response for fetch requests. */
        if ($this->isAjaxRequest()) {
            $this->jsonResponse([
                'success' => true,
                'message' => 'Event updated successfully.',
                'redirect' => '/admin'
            ]);
        }

        /* Redirect to the admin dashboard */
        return ['redirect' => '/admin'];
    }

    /* Return edit form error as JSON for AJAX requests,
    or fall back to a normal page render for non-JS users. */
    private function updateError(string $message, int $eventid): array
    {
        if ($this->isAjaxRequest()) {
            $this->jsonResponse([
                'success' => false,
                'message' => $message
            ], 422);
        }

        $event = $this->events->findById($eventid);

        return [
            'title' => 'Edit Event',
            'template' => 'editEvent.html.php',
            'styles' => ['admin-form.css'],
            'scripts' => ['editEvent.js'],
            'variables' => [
                'event' => $event,
                'error' => $message
            ]
        ];
    }

    /* Detect whether the request came from JavaScript fetch/AJAX. */
    private function isAjaxRequest(): bool
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    /* Send JSON output and stop further rendering. */
    private function jsonResponse(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
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
            if (session_status() !== PHP_SESSION_ACTIVE) {
                session_start();
            }
            $_SESSION['flash_message'] = 'Event not found.';
            $_SESSION['flash_type'] = 'info';
            
            return ['redirect' => '/admin'];
        }

        /* Confirm event exists before deletion */
        $event = $this->events->findById((int)$id);

        /* Redirect if event does not exist */
        if (!$event) {
            if (session_status() !== PHP_SESSION_ACTIVE) {
                session_start();
            }
            $_SESSION['flash_message'] = 'Event not found.';
            $_SESSION['flash_type'] = 'info';

            return ['redirect' => '/admin'];
        }

        /* Remove event from the database */
        $this->events->delete($id);

        /* Redirect back to the admin page */
        return ['redirect' => '/admin'];
    }

    /* Return create form error as JSON for AJAX requests,
       or fall back to a normal page render for non-JS users. */
    private function storeError(string $message): array
    {
        if ($this->isAjaxRequest()) {
            $this->jsonResponse([
                'success' => false,
                'message' => $message
            ], 422);
        }

        return [
            'title' => 'Create Event',
            'template' => 'createEvent.html.php',
            'styles' => ['admin-form.css'],
            'scripts' => ['createEvent.js'],
            'variables' => [
                'error' => $message
            ]
        ];
    }

    /* Search for events matching a term and return results as JSON. */
    public function search(): void
    {
        if ($result = $this->requireAdmin()) {
            http_response_code(403);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Unauthorized'
            ]);
            exit;
        }

        $term = trim($_GET['q'] ?? '');

        $events = $term === ''
            ? $this->events->findAll()
            : $this->events->adminSearch($term);

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'events' => $events
        ]);
        exit;
    }
}