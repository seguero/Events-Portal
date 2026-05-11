<article class="blog-single">

    <a class="blog-back" href="/blog">
        <i class="fa-solid fa-arrow-left"></i> Back to blog
    </a>

    <header class="blog-single-header">
        <span class="blog-label">
            <?= htmlspecialchars($post->category) ?>
        </span>

        <h1>
            <?= htmlspecialchars($post->title) ?>
        </h1>

        <p class="blog-meta">
            Published <?= date('d M Y', strtotime($post->created_at)) ?>
        </p>
    </header>

    <div class="blog-single-content">
        <?= nl2br(htmlspecialchars($post->content)) ?>
    </div>

</article>