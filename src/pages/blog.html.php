<header class="page-header blog-header">
    <h1>Blog Updates</h1>
    <p>
        Read the latest project updates, system improvements, and development notes.
    </p>
</header>

<section class="blog-layout">

    <div class="blog-grid">
        <?php foreach ($posts as $post): ?>
            <article class="blog-card">
                <div class="blog-card-body">
                    <span class="blog-label">
                        <?= htmlspecialchars($post->category) ?>
                    </span>

                    <h2>
                        <?= htmlspecialchars($post->title) ?>
                    </h2>

                    <p class="blog-meta">
                        <?= date('d M Y', strtotime($post->created_at)) ?>
                    </p>

                    <p>
                        <?= htmlspecialchars(mb_strimwidth($post->content, 0, 180, '...')) ?>
                    </p>

                    <a class="blog-cta" href="/blog/show?id=<?= htmlspecialchars($post->postid) ?>">
                        Read more
                    </a>
                </div>
            </article>
        <?php endforeach; ?>

        <?php if (empty($posts)): ?>
            <p class="blog-empty">
                No blog posts have been published yet.
            </p>
        <?php endif; ?>
    </div>

</section>