<!--
    Single Event Page
    Displays detailed information about a specific event and provide booking functionality
-->
<!-- Event details section -->
<section class="single-event">
    <h1 class="event-title"><?= htmlspecialchars($event->title) ?></h1>
    <p><strong>Type:</strong> <?= htmlspecialchars($event->event_type) ?></p>
    <p><strong>Category:</strong> <?= htmlspecialchars($event->category) ?></p>
    <p><strong>Date:</strong> <?= date('d M Y, H:i', strtotime($event->event_date)) ?></p>
    <p><strong>Location:</strong> <?= htmlspecialchars($event->location) ?></p>
    <p><?= nl2br(htmlspecialchars($event->description)) ?></p>

    <!-- Booking form, shown if user is logged in and event is upcoming
         Prevent duplicate bookings -->
    <?php if (!isset($_SESSION['user'])): ?>
        <p>Please <a href="/account">log in</a> to book this event.</p>

    <?php elseif (strtotime($event->event_date) < time()): ?>
        <p>This event has already ended.</p>

    <?php elseif ($alreadyBooked): ?>
        <p>You have already booked this event.</p>

    <?php else: ?>
        <form id="bookingForm" action="/booking/store" method="post">
            <!-- Inline message area used by JavaScript to show success/error feedback. -->
            <p id="bookingMessage" class="form-message" aria-live="polite"></p>

            <input type="hidden" name="eventid" value="<?= htmlspecialchars($event->eventid) ?>">
            <button type="submit">Book Event</button>
        </form>
    <?php endif; ?>

    <a href="/events">Back to events</a>
</section>