<!--
    About Page
    Explains the purpose, technologies, core features, and advanced features
    implemented in the event management web application.
-->

<header class="about-header">
    <h1>About This Project</h1>
    <p>
        This web application was developed as part of the CSYM019 Internet Programming assignment.
        It provides a public event discovery platform and an admin-managed event system for a
        community organisation.
    </p>
</header>

<section class="about-layout">

    <!-- Project overview -->
    <section class="about-card about-card--highlight">
        <div class="about-card-icon">
            <i class="fa-solid fa-calendar-days"></i>
        </div>

        <div>
            <h2>Project Overview</h2>
            <p>
                The system allows visitors to browse, search, filter, and book events, while
                administrators can manage event content through a secure back-office interface.
                The application combines client-side interactivity with server-side processing
                and database-driven content.
            </p>
        </div>
    </section>

    <!-- Main features -->
    <section class="about-section">
        <div class="about-section-head">
            <h2>Main Features</h2>
            <p>Core functionality implemented to meet the assignment requirements.</p>
        </div>

        <div class="about-grid">
            <article class="about-card">
                <i class="fa-solid fa-lock about-feature-icon"></i>
                <h3>Admin Management</h3>
                <p>
                    Administrators can create, edit, and delete events through structured PHP forms.
                    Event details are stored securely in a MySQL database.
                </p>
            </article>

            <article class="about-card">
                <i class="fa-solid fa-list about-feature-icon"></i>
                <h3>Dynamic Event Listing</h3>
                <p>
                    Public users can view upcoming and past events with clear event cards showing
                    dates, locations, categories, descriptions, and images.
                </p>
            </article>

            <article class="about-card">
                <i class="fa-solid fa-magnifying-glass about-feature-icon"></i>
                <h3>Search and Filtering</h3>
                <p>
                    AJAX-powered search and filters update the event list without reloading the page,
                    improving usability and responsiveness.
                </p>
            </article>

            <article class="about-card">
                <i class="fa-solid fa-ticket about-feature-icon"></i>
                <h3>Event Booking</h3>
                <p>
                    Logged-in users can book events, and the system prevents duplicate bookings for
                    the same event.
                </p>
            </article>
        </div>
    </section>

    <!-- Advanced features -->
    <section class="about-section">
        <div class="about-section-head">
            <h2>Advanced Features</h2>
            <p>Extra improvements added to make the system more realistic and user-friendly.</p>
        </div>

        <div class="about-timeline">
            <article class="about-timeline-item">
                <div>
                    <h3>Dynamic Date Range Picker</h3>
                    <p>
                        Users can select any start and end date to find events happening within a
                        custom date range.
                    </p>
                </div>
            </article>

            <article class="about-timeline-item">
                <div>
                    <h3>Booking Confirmations</h3>
                    <p>
                        Users receive booking confirmation feedback after successfully booking an event.
                    </p>
                </div>
            </article>

            <article class="about-timeline-item">
                <div>
                    <h3>24-Hour Event Reminders</h3>
                    <p>
                        Cron-based reminder logic supports automatic reminders for events happening
                        within the next 24 hours.
                    </p>
                </div>
            </article>

            <article class="about-timeline-item">
                <div>
                    <h3>Subscriber Alerts</h3>
                    <p>
                        Users can subscribe and receive email alerts when new
                        events are added to the system, keeping them informed about upcoming opportunities.
                    </p>
                </div>
        </div>
    </section>

    <!-- Technologies used -->
    <section class="about-section">
        <div class="about-section-head">
            <h2>Technologies Used</h2>
            <p>The application uses a full-stack PHP, MySQL, and JavaScript workflow.</p>
        </div>

        <div class="tech-list">
            <span>HTML5</span>
            <span>CSS3</span>
            <span>JavaScript</span>
            <span>AJAX</span>
            <span>JSON</span>
            <span>PHP</span>
            <span>MySQL</span>
            <span>PDO</span>
            <span>Docker</span>
            <span>Apache</span>
            <span>PHPMailer</span>
            <span>Cron</span>
            <span>Composer</span>
            <span>Font Awesome</span>
        </div>
    </section>

    <!-- Quality and maintainability -->
    <section class="about-section about-two-column">
        <article class="about-card">
            <h2>Security and Maintainability</h2>
            <p>
                The project uses a structured MVC-style organisation with controllers, models,
                reusable database helpers, and separated templates. Prepared statements are used
                for database queries, and user output is escaped to reduce security risks.
            </p>
        </article>

        <article class="about-card">
            <h2>Development Approach</h2>
            <p>
                The application was built to demonstrate how front-end interaction, server-side PHP,
                JSON responses, AJAX requests, and MySQL storage can work together in a maintainable
                web application.
            </p>
        </article>
    </section>

</section>