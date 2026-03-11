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

            <!-- Static date filter options -->
            <details class="filter-group" open>
                <summary class="filter-summary">Date</summary>

                <div class="filter-options">
                    <label class="filter-option">
                        <input type="radio" name="date" value="today">
                        Today
                    </label>

                    <label class="filter-option">
                        <input type="radio" name="date" value="week">
                        This week
                    </label>

                    <label class="filter-option">
                        <input type="radio" name="date" value="month">
                        This month
                    </label>
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
                <article class="card card-event">
                    <img
                        class="card-media"
                        src="../assets/placeholder.jpg"
                        alt="Event"
                    />

                    <div class="card-body">
                        <!-- Event type badge -->
                        <span class="badge"><?= htmlspecialchars($event->event_type) ?></span>

                        <!-- Event title -->
                        <h3 class="card-title"><?= htmlspecialchars($event->title) ?></h3>

                        <!-- Formatted event date and time -->
                        <p class="card-meta"><?= date('d M Y, H:i', strtotime($event->event_date)) ?></p>

                        <!-- Event location -->
                        <p class="card-text"><?= htmlspecialchars($event->location) ?></p>

                        <!-- Placeholder link for future single event page -->
                        <a class="card-cta" href="event.html">Read more</a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

    </section>
</div>