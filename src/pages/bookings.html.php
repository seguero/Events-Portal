<!--
    Bookings Page
    Displays the logged-in user's upcoming and past event bookings.
    Users can view event details and cancel upcoming bookings.
-->

<section class="bookings-page">
    <div class="bookings-columns">

        <!-- Upcoming bookings column -->
        <section class="bookings-column">
            <h2>Upcoming Bookings</h2>

            <!-- Show message if there are no upcoming bookings -->
            <?php if (empty($upcomingBookings)): ?>
                <p class="empty-state">You have no upcoming bookings.</p>
            <?php else: ?>

                <!-- Loop through upcoming bookings -->
                <?php foreach ($upcomingBookings as $booking): ?>
                    <article class="booking-card upcoming">

                        <!-- Booking event title -->
                        <h3><?= htmlspecialchars($booking->title) ?></h3>

                        <!-- Event date and time -->
                        <p>
                            <strong>Date:</strong>
                            <?= date('d M Y, H:i', strtotime($booking->event_date)) ?>
                        </p>

                        <!-- Event location if available -->
                        <?php if (!empty($booking->location)): ?>
                            <p>
                                <strong>Location:</strong>
                                <?= htmlspecialchars($booking->location) ?>
                            </p>
                        <?php endif; ?>

                        <!-- Event category if available -->
                        <?php if (!empty($booking->category)): ?>
                            <p>
                                <strong>Category:</strong>
                                <?= htmlspecialchars($booking->category) ?>
                            </p>
                        <?php endif; ?>

                        <!-- Action buttons for viewing or cancelling the booking -->
                        <div class="booking-actions">

                            <!-- Link to the single event page -->
                            <a class="view-button" href="/event/show/<?= htmlspecialchars($booking->eventid) ?>">
                                View Event
                            </a>

                            <!-- Cancel booking form with confirmation prompt -->
                            <form action="/booking/cancel" method="post" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                                <input type="hidden" name="bookingid" value="<?= htmlspecialchars($booking->bookingid) ?>">
                                <button type="submit" class="cancel-button">Cancel Booking</button>
                            </form>
                        </div>
                    </article>
                <?php endforeach; ?>

            <?php endif; ?>
        </section>

        <!-- Past bookings column -->
        <section class="bookings-column">
            <h2>Past Bookings</h2>

            <!-- Show message if there are no past bookings -->
            <?php if (empty($pastBookings)): ?>
                <p class="empty-state">You have no past bookings.</p>
            <?php else: ?>

                <!-- Loop through past bookings -->
                <?php foreach ($pastBookings as $booking): ?>
                    <article class="booking-card past">

                        <!-- Booking event title -->
                        <h3><?= htmlspecialchars($booking->title) ?></h3>

                        <!-- Event date and time -->
                        <p>
                            <strong>Date:</strong>
                            <?= date('d M Y, H:i', strtotime($booking->event_date)) ?>
                        </p>

                        <!-- Event location if available -->
                        <?php if (!empty($booking->location)): ?>
                            <p>
                                <strong>Location:</strong>
                                <?= htmlspecialchars($booking->location) ?>
                            </p>
                        <?php endif; ?>

                        <!-- Event category if available -->
                        <?php if (!empty($booking->category)): ?>
                            <p>
                                <strong>Category:</strong>
                                <?= htmlspecialchars($booking->category) ?>
                            </p>
                        <?php endif; ?>

                        <!-- Link to view the original event -->
                        <div class="booking-actions">
                            <a class="view-button" href="/events/show/<?= htmlspecialchars($booking->eventid) ?>">
                                View Event
                            </a>
                        </div>
                    </article>
                <?php endforeach; ?>

            <?php endif; ?>
        </section>
    </div>
</section>