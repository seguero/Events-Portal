<?php
namespace controllers;

use models\EventTable;

class EventController
{
    private EventTable $events;

    public function __construct()
    {
        $this->events = new EventTable();
    }

    public function index(): array
    {
        $eventList = $this->events->findAll();
        $eventTypes = $this->events->findEventTypes();
        $locations = $this->events->findLocations();

        return [
            'title' => 'Events',
            'template' => 'events.html.php',
            'styles' => ['events.css', 'cards.css'],
            'variables' => [
                'events' => $eventList,
                'eventTypes' => $eventTypes,
                'locations' => $locations
            ]
        ];
    }
}