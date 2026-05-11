<!--
    Admin Management Page
    Displays event and blog management panels.
    Administrators can manage events and blog posts from one dashboard.
-->

<?php if (!empty($_SESSION['flash_message'])): ?>
    <p class="admin-flash <?= htmlspecialchars($_SESSION['flash_type'] ?? 'info') ?>">
        <?= htmlspecialchars($_SESSION['flash_message']) ?>
    </p>

    <?php
        unset($_SESSION['flash_message']);
        unset($_SESSION['flash_type']);
    ?>
<?php endif; ?>

<section class="admin-dashboard">

    <!-- Events management panel -->
    <div class="admin-panel">

        <!-- Page header with title and button to create a new event -->
        <div class="admin-header">
            <h1>Manage Events</h1>

            <a href="/admin/create" class="btn-add">
                <i class="fa-solid fa-plus"></i> Add Event
            </a>
        </div>

        <!-- Search input for filtering events -->
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

            <tbody id="admin-events-table-body">

                <!-- Loop through each event returned from the controller -->
                <?php foreach ($events as $event): ?>
                    <tr>
                        <!-- Event ID -->
                        <td><?= htmlspecialchars($event->eventid) ?></td>

                        <!-- Event details escaped for security -->
                        <td><?= htmlspecialchars($event->title) ?></td>
                        <td><?= htmlspecialchars($event->event_type) ?></td>
                        <td><?= htmlspecialchars($event->category) ?></td>
                        <td><?= htmlspecialchars($event->event_date) ?></td>
                        <td><?= htmlspecialchars($event->location) ?></td>

                        <!-- Action buttons for editing or deleting the event -->
                        <td class="actions">
                            <!-- Edit event link -->
                            <a href="/admin/edit?id=<?= htmlspecialchars($event->eventid) ?>" class="edit">
                                <i class="fa-solid fa-pen"></i>
                            </a>

                            <!-- Delete event link with confirmation dialog -->
                            <a
                                href="/admin/delete?id=<?= htmlspecialchars($event->eventid) ?>"
                                class="delete"
                                onclick="return confirm('Delete this event?')"
                            >
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>

                <?php if (empty($events)): ?>
                    <tr>
                        <td colspan="7">No events have been created yet.</td>
                    </tr>
                <?php endif; ?>

            </tbody>
        </table>
    </div>

    <!-- Blog management panel -->
    <div class="admin-panel">

        <!-- Page header with title and button to create a new blog post -->
        <div class="admin-header">
            <h1>Manage Blog Posts</h1>

            <a href="/admin/createBlog" class="btn-add">
                <i class="fa-solid fa-plus"></i> Add Post
            </a>
        </div>

        <!-- Table displaying all blog posts stored in the database -->
        <table class="admin-table">

            <!-- Table column headings -->
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Created</th>
                    <th class="actions">Actions</th>
                </tr>
            </thead>

            <tbody>

                <!-- Loop through each blog post returned from the controller -->
                <?php foreach ($posts as $post): ?>
                    <tr>
                        <!-- Blog post ID -->
                        <td><?= htmlspecialchars($post->postid) ?></td>

                        <!-- Blog post details escaped for security -->
                        <td><?= htmlspecialchars($post->title) ?></td>
                        <td><?= htmlspecialchars($post->category) ?></td>
                        <td><?= htmlspecialchars($post->created_at) ?></td>

                        <!-- Action buttons for editing or deleting the blog post -->
                        <td class="actions">
                            <!-- Edit blog post link -->
                            <a href="/admin/editBlog?id=<?= htmlspecialchars($post->postid) ?>" class="edit">
                                <i class="fa-solid fa-pen"></i>
                            </a>

                            <!-- Delete blog post link with confirmation dialog -->
                            <a
                                href="/admin/deleteBlog?id=<?= htmlspecialchars($post->postid) ?>"
                                class="delete"
                                onclick="return confirm('Delete this blog post?')"
                            >
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>

                <?php if (empty($posts)): ?>
                    <tr>
                        <td colspan="5">No blog posts have been created yet.</td>
                    </tr>
                <?php endif; ?>

            </tbody>
        </table>
    </div>

</section>