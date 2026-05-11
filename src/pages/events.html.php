    <!-- Page title -->
<header class="page-header">
    <h1>Events</h1>
</header>

<div class="events-layout">

    <!-- Sidebar containing filter controls -->
    <aside class="events-sidebar">
        <form id="events-filter-form">

            <!-- Event type filter populated dynamically from database values -->
            <details class="filter-group" open>
                <summary class="filter-summary">Event Type</summary>

                <div class="filter-options">
                    <?php foreach ($eventTypes as $type): ?>
                        <label class="filter-option">
                            <input type="checkbox" name="event_type[]" value="<?= htmlspecialchars($type) ?>">
                            <?= htmlspecialchars($type) ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            </details>

            <details class="filter-group" open>
                <summary class="filter-summary">Category</summary>

                <div class="filter-options">
                    <?php foreach ($categories as $category): ?>
                        <label class="filter-option">
                            <input type="checkbox" name="category[]" value="<?= htmlspecialchars($category) ?>">
                            <?= htmlspecialchars($category) ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            </details>

            <!-- Location filter populated dynamically from database values -->
            <details class="filter-group" open>
                <summary class="filter-summary">Location</summary>

                <div class="filter-options">
                    <?php foreach ($locations as $location): ?>
                        <label class="filter-option">
                            <input type="checkbox" name="location[]" value="<?= htmlspecialchars($location) ?>">
                            <?= htmlspecialchars($location) ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            </details>

            <!-- Dynamic date range filter -->
            <details class="filter-group" open>
                <summary class="filter-summary">Date range</summary>

                <div class="filter-options date-range-options">
                    <label class="filter-option">
                        From
                        <input type="date" name="start_date" id="start-date-filter">
                    </label>

                    <label class="filter-option">
                        To
                        <input type="date" name="end_date" id="end-date-filter">
                    </label>

                    <button type="button" id="clear-date-filter" class="filter-clear-btn">
                        Clear dates
                    </button>
                </div>
            </details>

            <!-- Sort control for ordering event results -->
            <details class="filter-group" open>
                <summary class="filter-summary">Sort by</summary>

                <div class="filter-options">
                    <select name="sort" class="filter-select">
                        <option value="date">Date</option>
                        <option value="newest">Newest</option>
                        <option value="location">Location</option>
                    </select>
                </div>
            </details>

        </form>
    </aside>

    <!-- Main content area containing search and event cards -->
    <section class="events-content">

        <!-- Search input to be connected to JavaScript/AJAX filtering -->
        <div class="events-search">
            <input type="text" id="event-search-input" placeholder="Search events">
        </div>

        <!-- Event card list rendered dynamically from database records -->
        <div class="events-list">
            <?php foreach ($events as $event): ?>
                <?php
                    $eventTime = strtotime($event->event_date);
                    $now = time();
                    $hoursUntilEvent = ($eventTime - $now) / 3600;

                    if ($eventTime < $now) {
                        $statusClass = 'event-status-closed';
                        $statusLabel = 'Closed';
                    } elseif ($hoursUntilEvent <= 24) {
                        $statusClass = 'event-status-soon';
                        $statusLabel = 'Starting soon';
                    } else {
                        $statusClass = 'event-status-upcoming';
                        $statusLabel = 'Upcoming';
                    }
                ?>

                <article class="card card-event <?= $statusClass ?>">
                    <img
                        class="card-media"
                        src="<?= !empty($event->image_path) ? htmlspecialchars($event->image_path) : '../assets/placeholder.jpg' ?>"
                        alt="<?= htmlspecialchars($event->title) ?>"
                    />

                    <div class="card-body">
                        <div class="card-badges">
                            <span class="badge"><?= htmlspecialchars($event->event_type) ?></span>
                            <span class="badge badge-status"><?= htmlspecialchars($statusLabel) ?></span>
                        </div>

                        <h3 class="card-title"><?= htmlspecialchars($event->title) ?></h3>

                        <p class="card-meta">
                            <?= date('d M Y, H:i', strtotime($event->event_date)) ?>
                        </p>

                        <p class="card-text">
                            <?= htmlspecialchars($event->location) ?>
                        </p>

                        <p class="card-description">
                            <?= htmlspecialchars($event->description) ?>
                        </p>

                        <a class="card-cta" href="/events/show/<?= htmlspecialchars($event->eventid) ?>">
                            Read more
                        </a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

    </section>
</div>