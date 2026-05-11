<!--
    Contact Page
    Allows users to send enquiries to the site administrator.
-->

<header class="page-header">
    <h1>Contact Us</h1>
    <p>
        For any queries, you can contact us using the form below.
        We will do our best to respond as soon as possible.
    </p>
</header>

<section class="contact-layout">

    <article class="contact-card">
        <h2>Send a Message</h2>

        <?php if (!empty($error)): ?>
            <p class="contact-message error">
                <?= htmlspecialchars($error) ?>
            </p>
        <?php endif; ?>

        <?php if (!empty($_SESSION['flash_message'])): ?>
            <p class="contact-message <?= htmlspecialchars($_SESSION['flash_type'] ?? 'info') ?>">
                <?= htmlspecialchars($_SESSION['flash_message']) ?>
            </p>

            <?php
                unset($_SESSION['flash_message']);
                unset($_SESSION['flash_type']);
            ?>
        <?php endif; ?>

        <form class="contact-form" method="post" action="/contact/send">

            <div class="form-group">
                <label for="name">Your Name</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    required
                    value="<?= htmlspecialchars($old['name'] ?? '') ?>"
                >
            </div>

            <div class="form-group">
                <label for="email">Your Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    required
                    value="<?= htmlspecialchars($old['email'] ?? '') ?>"
                >
            </div>

            <div class="form-group">
                <label for="subject">Subject</label>
                <input
                    type="text"
                    id="subject"
                    name="subject"
                    required
                    value="<?= htmlspecialchars($old['subject'] ?? '') ?>"
                >
            </div>

            <div class="form-group">
                <label for="message">Message</label>
                <textarea
                    id="message"
                    name="message"
                    rows="6"
                    required
                ><?= htmlspecialchars($old['message'] ?? '') ?></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-send">
                    <i class="fa-solid fa-paper-plane"></i> Send Message
                </button>
            </div>

        </form>
    </article>

    <aside class="contact-card contact-info">
        <h2>Need Help?</h2>
        <p>
            Use this form for questions about events, bookings, account access,
            or general website support.
        </p>

        <div class="contact-info-item">
            <i class="fa-solid fa-envelope"></i>
            <span>Messages are sent directly to the site administrator.</span>
        </div>

        <div class="contact-info-item">
            <i class="fa-solid fa-calendar-check"></i>
            <span>For event bookings, please include the event name if possible.</span>
        </div>
    </aside>

</section>