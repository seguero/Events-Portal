<section class="admin-panel">

    <div class="admin-header">
        <h1>Create Blog Post</h1>

        <a href="/admin/blog" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i> Back
        </a>
    </div>

    <?php if (!empty($error)): ?>
        <p class="form-message error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form class="admin-form" method="post" action="/admin/storeBlog">

        <div class="form-group">
            <label for="title">Post Title</label>
            <input type="text" id="title" name="title" required>
        </div>

        <div class="form-group">
            <label for="category">Category</label>
            <input type="text" id="category" name="category" required>
        </div>

        <div class="form-group">
            <label for="content">Content</label>
            <textarea id="content" name="content" rows="8" required></textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-save">
                <i class="fa-solid fa-check"></i> Save Post
            </button>

            <a href="/admin/blog" class="btn-cancel">
                Cancel
            </a>
        </div>

    </form>

</section>