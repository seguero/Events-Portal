<!--
    Edit Event Page
    Displays a form pre-filled with an existing event's data.
    Administrators can modify the event and submit the form
    to update the record in the database.
-->

<section class="admin-panel">

    <!-- Page header with title and navigation back to admin dashboard -->
    <div class="admin-header">
        <h1>Edit Event</h1>
        <a href="/admin" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i> Back
        </a>
    </div>

    <!-- Fallback error message for normal non-JavaScript form submissions. -->
    <?php if (!empty($error)): ?>
        <p class="form-message error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <!-- Form used to update an existing event -->
    <form id="editEventForm" class="admin-form" method="post" action="/admin/update" enctype="multipart/form-data">

        <!-- Inline message area used by JavaScript to display success/error feedback
             without reloading the page. -->
        <p id="editEventMessage" class="form-message" aria-live="polite"></p>

        <!-- Hidden field containing the event ID so the correct record is updated -->
        <input type="hidden" name="eventid" value="<?= $event->eventid ?>">

        <!-- Event title input (pre-filled with current value) -->
        <div class="form-group">
            <label for="title">Event Title</label>
            <input
                type="text"
                id="title"
                name="title"
                required
                value="<?= htmlspecialchars($event->title) ?>">
        </div>

        <!-- Event type input -->
        <div class="form-group">
            <label for="event_type">Event Type</label>
            <input
                type="text"
                id="event_type"
                name="event_type"
                value="<?= htmlspecialchars($event->event_type) ?>">
        </div>

        <!-- Event category input -->
        <div class="form-group">
            <label for="category">Category</label>
            <input
                type="text"
                id="category"
                name="category"
                value="<?= htmlspecialchars($event->category) ?>">
        </div>

        <!-- Event date input (formatted to match HTML date input format) -->
        <div class="form-group">
            <label for="event_date">Event Date</label>
            <input
                type="datetime-local"
                id="event_date"
                name="event_date"
                required
                value="<?= isset($event->event_date) ? date('Y-m-d\TH:i', strtotime($event->event_date)) : '' ?>">
        </div>

        <!-- Event location input -->
        <div class="form-group">
            <label for="location">Location</label>
            <input
                type="text"
                id="location"
                name="location"
                required
                value="<?= htmlspecialchars($event->location) ?>">
        </div>

        <!-- Event image upload input -->
        <div class="form-group">
            <label for="image">Event Image</label>

            <?php if (!empty($event->image_path)): ?>
                <div class="current-event-image">
                    <p>Current image:</p>
                    <img
                        src="<?= htmlspecialchars($event->image_path) ?>"
                        alt="<?= htmlspecialchars($event->title) ?>"
                        style="max-width: 220px; border-radius: 8px;"
                    >
                </div>
            <?php endif; ?>

            <input type="file" id="image" name="image" accept="image/jpeg, image/png, image/webp">
            <small>Accepted formats: JPG, PNG, WEBP. Leave empty to keep the current image.</small>
        </div>

        <!-- Event description input -->
        <div class="form-group">
            <label for="description">Description</label>
            <textarea
                id="description"
                name="description"
                rows="5"><?= htmlspecialchars($event->description) ?></textarea>
        </div>

        <!-- Form action buttons -->
        <div class="form-actions">

            <!-- Submit button to update the event -->
            <button type="submit" class="btn-save">
                <i class="fa-solid fa-check"></i> Update Event
            </button>

            <!-- Cancel button returning to admin dashboard -->
            <a href="/admin" class="btn-cancel">
                Cancel
            </a>

        </div>
    </form>
</section>