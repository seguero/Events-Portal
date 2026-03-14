<!--
    Admin Events Management Page
    Displays a table of all events retrieved from the database.
    Administrators can search events, create new ones, or perform
    edit and delete actions from this interface.
-->

<section class="admin-panel">

    <!-- Page header with title and button to create a new event -->
    <div class="admin-header">
        <h1>Manage Events</h1>
        <a href="/admin/create" class="btn-add">
            <i class="fa-solid fa-plus"></i> Add Event
        </a>
    </div>

    <!-- Search input for filtering events (planned for JavaScript/AJAX functionality) -->
    <div class="events-search">
        <input type="text" id="event-search-input" placeholder="Search events">
    </div>

    <!-- Table displaying all events stored in the database -->
    <table class="admin-table">

        <!-- Table column headings -->
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Event Type</th>
                <th>Category</th>
                <th>Date</th>
                <th>Location</th>
                <th class="actions">Actions</th>
            </tr>
        </thead>

        <tbody>

        <!-- Loop through each event returned from the controller -->
        <?php foreach ($events as $event): ?>

            <tr>

                <!-- Event ID -->
                <td><?= $event->eventid ?></td>

                <!-- Event details (escaped for security) -->
                <td><?= htmlspecialchars($event->title) ?></td>
                <td><?= htmlspecialchars($event->event_type) ?></td>
                <td><?= htmlspecialchars($event->category) ?></td>
                <td><?= $event->event_date ?></td>
                <td><?= htmlspecialchars($event->location) ?></td>

                <!-- Action buttons for editing or deleting the event -->
                <td class="actions">

                    <!-- Edit event link -->
                    <a href="/admin/edit?id=<?= $event->eventid ?>" class="edit">
                        <i class="fa-solid fa-pen"></i>
                    </a>

                    <!-- Delete event link with confirmation dialog -->
                    <a href="/admin/delete?id=<?= $event->eventid ?>" class="delete"
                        onclick="return confirm('Delete this event?')">
                        <i class="fa-solid fa-trash"></i>
                    </a>

                </td>
            </tr>

        <?php endforeach; ?>

        </tbody>
    </table>
</section>