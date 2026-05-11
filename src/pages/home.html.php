<!--
    Home Page
    Displays the main landing page content for the website.
    Includes featured events, recent events, and latest blog updates
    using reusable card-based sections.
-->

<!-- Popular events section -->
<section class="block" aria-labelledby="popular-heading">
    <div class="block-head">
        <h2 id="popular-heading">Popular events</h2>
        <a class="block-link" href="/events">View all</a>
    </div>

    <!-- Featured event cards -->
    <div class="cards">
        <?php if (empty($popularEvents)): ?>
            <p>No popular events available yet.</p>
        <?php endif; ?>

        <?php foreach ($popularEvents as $event): ?>
            <article class="card">
                <img
                    class="card-media"
                    src="<?= !empty($event->image_path) ? htmlspecialchars($event->image_path) : '/assets/placeholder.jpg' ?>"
                    alt="<?= htmlspecialchars($event->title) ?>"
                />

                <div class="card-body">
                    <span class="badge"><?= htmlspecialchars($event->event_type) ?></span>

                    <h3 class="card-title"><?= htmlspecialchars($event->title) ?></h3>

                   <p class="card-meta">
                        <?= date('d M Y, H:i', strtotime($event->event_date)) ?>
                        ·
                        <?= htmlspecialchars($event->location) ?>
                        ·
                        <?= (int) ($event->booking_count ?? 0) ?> bookings
                    </p>

                    <p class="card-text">
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

<!-- Latest events section -->
<section class="block" aria-labelledby="latest-heading">
    <div class="block-head">
        <h2 id="latest-heading">Latest events</h2>
        <a class="block-link" href="/events?sort=newest">See recent</a>
    </div>

    <!-- Compact cards for recently added events -->
    <div class="cards cards--compact">
        <?php if (empty($latestEvents)): ?>
            <p>No latest events available yet.</p>
        <?php endif; ?>

        <?php foreach ($latestEvents as $event): ?>
            <article class="card card--row">
                <div class="card-body">
                    <span class="badge"><?= htmlspecialchars($event->event_type) ?></span>

                    <h3 class="card-title"><?= htmlspecialchars($event->title) ?></h3>

                    <p class="card-meta">
                        Added recently · <?= date('d M Y, H:i', strtotime($event->event_date)) ?>
                    </p>

                    <p class="card-text">
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

<!-- Blog updates section -->
<section class="block" aria-labelledby="blog-heading">
    <div class="block-head">
        <h2 id="blog-heading">Blog updates</h2>
        <a class="block-link" href="/blog">All blog posts</a>
    </div>

    <!-- Blog update card -->
    <div class="cards">
        <?php if (!empty($latestBlogPosts)): ?>
            <?php foreach ($latestBlogPosts as $post): ?>
                <article class="card">
                    <div class="card-body">
                        <span class="badge">
                            <?= htmlspecialchars($post->category) ?>
                        </span>

                        <h3 class="card-title">
                            <?= htmlspecialchars($post->title) ?>
                        </h3>

                        <p class="card-meta">
                            <?= date('d M Y', strtotime($post->created_at)) ?>
                        </p>

                        <p class="card-text">
                            <?= htmlspecialchars(mb_strimwidth($post->content, 0, 180, '...')) ?>
                        </p>

                        <a class="card-cta" href="/blog/show?id=<?= htmlspecialchars($post->postid) ?>">
                            Read more
                        </a>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php else: ?>
            <article class="card">
                <div class="card-body">
                    <span class="badge">Update</span>
                    <h3 class="card-title">No blog updates yet</h3>
                    <p class="card-meta"><?= date('d M Y') ?></p>
                    <p class="card-text">
                        Blog updates will appear here once an admin creates a post.
                    </p>
                    <a class="card-cta" href="/blog">View blog</a>
                </div>
            </article>
        <?php endif; ?>
    </div>
</section>