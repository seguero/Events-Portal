<section class="admin-panel">

    <div class="admin-header">
        <h1>Edit Blog Post</h1>

        <a href="/admin/blog" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i> Back
        </a>
    </div>

    <?php if (!empty($error)): ?>
        <p class="form-message error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form class="admin-form" method="post" action="/admin/updateBlog">

        <input
            type="hidden"
            name="postid"
            value="<?= htmlspecialchars($post->postid) ?>"
        >

        <div class="form-group">
            <label for="title">Post Title</label>
            <input
                type="text"
                id="title"
                name="title"
                required
                value="<?= htmlspecialchars($post->title) ?>"
            >
        </div>

        <div class="form-group">
            <label for="category">Category</label>
            <input
                type="text"
                id="category"
                name="category"
                required
                value="<?= htmlspecialchars($post->category) ?>"
            >
        </div>

        <div class="form-group">
            <label for="content">Content</label>
            <textarea id="content" name="content" rows="8" required><?= htmlspecialchars($post->content) ?></textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-save">
                <i class="fa-solid fa-check"></i> Update Post
            </button>

            <a href="/admin/blog" class="btn-cancel">
                Cancel
            </a>
        </div>

    </form>

</section>