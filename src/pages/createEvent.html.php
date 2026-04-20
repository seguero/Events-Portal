<section class="admin-panel">

    <div class="admin-header">
        <h1>Create Event</h1>
        <a href="/admin" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i> Back
        </a>
    </div>

    <?php if (!empty($error)): ?>
        <p class="form-message error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form id="createEventForm" class="admin-form" method="post" action="/admin/store">

        <!-- Message area used for inline success/error feedback without reloading the page. -->
        <p id="createEventMessage" class="form-message" aria-live="polite"></p>

        <div class="form-group">
            <label for="title">Event Title</label>
            <input type="text" id="title" name="title" required>
        </div>

        <div class="form-group">
            <label for="event_type">Event Type</label>
            <input type="text" id="event_type" name="event_type" required>
        </div>

        <div class="form-group">
            <label for="category">Category</label>
            <input type="text" id="category" name="category" required>
        </div>

        <div class="form-group">
            <label for="event_date">Event Date</label>
            <input type="datetime-local" id="event_date" name="event_date" required>
        </div>

        <div class="form-group">
            <label for="location">Location</label>
            <input type="text" id="location" name="location" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="5" required></textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-save">
                <i class="fa-solid fa-check"></i> Save Event
            </button>

            <a href="/admin" class="btn-cancel">
                Cancel
            </a>
        </div>

    </form>

</section>