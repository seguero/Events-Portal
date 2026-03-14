<!--
    Create Event Page
    Displays a form that allows administrators to add a new event.
    The form submits data to the AdminController which stores
    the event in the database.
-->

<section class="admin-panel">

    <!-- Page header with title and navigation back to admin dashboard -->
    <div class="admin-header">
        <h1>Create Event</h1>
        <a href="/admin" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i> Back
        </a>
    </div>

    <!-- Event creation form -->
    <form class="admin-form" method="post" action="/admin/store">

        <!-- Event title input -->
        <div class="form-group">
            <label for="title">Event Title</label>
            <input type="text" id="title" name="title" required>
        </div>

        <!-- Event type input -->
        <div class="form-group">
            <label for="event_type">Event Type</label>
            <input type="text" id="event_type" name="event_type">
        </div>

        <!-- Event category input -->
        <div class="form-group">
            <label for="category">Category</label>
            <input type="text" id="category" name="category">
        </div>

        <!-- Event date input -->
        <div class="form-group">
            <label for="event_date">Event Date</label>
            <input type="date" id="event_date" name="event_date" required>
        </div>

        <!-- Event location input -->
        <div class="form-group">
            <label for="location">Location</label>
            <input type="text" id="location" name="location" required>
        </div>

        <!-- Event description input -->
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="5"></textarea>
        </div>

        <!-- Form action buttons -->
        <div class="form-actions">

            <!-- Submit button to save event -->
            <button type="submit" class="btn-save">
                <i class="fa-solid fa-check"></i> Save Event
            </button>

            <!-- Cancel button returning to admin panel -->
            <a href="/admin" class="btn-cancel">
                Cancel
            </a>

        </div>
    </form>
</section>