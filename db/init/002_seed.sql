-- 002_seed.sql

-- Inserts 1 admin user + a few events for testing.
-- Hash generated with password_hash('Admin123!', PASSWORD_DEFAULT);
-- ADMIN USER (role=admin)
INSERT INTO users (firstname, lastname, email, password, role)
VALUES (
  'SUPER',
  'USER',
  'admin@csym019.test',
  '$2y$10$.TK8ewqJ9czX58GgZKT1SumEiBEZgi0O3TS9FqhHWghoz52CNvoO6',
  'admin'
);

-- DUMMY EVENTS
INSERT INTO events (category, event_type, title, description, event_date, location, image_path)
VALUES
('Web Development','Workshop','Web Development Workshop', 'Hands-on workshop covering modern PHP structure and routing.', '2026-05-10 18:00:00', 'Northampton', '/assets/Web Development.png'),
('Server side development','Webinar','Docker for Beginners', 'Learn container basics and how to run reproducible dev environments.', '2026-07-15 17:30:00', 'Wellingborough', '/assets/Docker.png'),
('Internet Security','Conference','Web App Security Basics', 'Intro to common vulnerabilities like XSS and how to mitigate them.', '2026-06-20 19:00:00', 'Kettering', '/assets/Web Security.png');

-- PROGRESS BLOG POSTS
INSERT INTO blog_posts (title, category, content, image_path, created_at)
VALUES
(
    'v0.1 - Project Setup and First Prototype',
    'Development Update',
    'The first coding session focused on setting up the foundation of the project.

- Created basic HTML and CSS to experiment with grid options and decide on the page layout.
- Created folders to organise the project structure early.
- Created empty files to plan the required implementation.
- Made the first commit to test GitHub functionality and confirm that version control was working correctly.

Plan for the next coding session:
- Finish the grid elements.
- Design the navigation bar.
- Choose a logo as the home button.
- Use icons instead of plain text links.
- Position the account icon on the far-right.
- Design the footer with social media links, quick links, copyright text, and a newsletter subscribe form.
- Start work on homepage cards and content sections.',
    NULL,
    '2026-02-01 09:00:00'
),
(
    'v0.2 - Layout, Navigation, Footer and Homepage Cards',
    'Development Update',
    'This version focused on improving the static frontend layout and visual structure of the website.

- Finalised the main grid layout, including header, main, and footer structure.
- Made progress on the navigation bar design.
- Added a placeholder logo.
- Integrated Font Awesome icons for navigation.
- Implemented a hover text dropdown effect.
- Applied initial navigation styling.
- Added social media icons using Font Awesome.
- Implemented a flex layout for the footer.
- Added a newsletter subscribe form.
- Added hardcoded homepage cards to visualise the layout and overall aesthetic.
- Planned future dynamic rendering using PHP and JavaScript.
- Planned slideshow effects for popular and recent events.
- Planned a blog section to display admin updates.
- Refactored CSS into separate files including global, layout, and cards stylesheets.
- Improved overall spacing using consistent padding and gaps.',
    NULL,
    '2026-02-03 09:00:00'
),
(
    'v0.3 - Docker Environment and MVC Routing',
    'Development Update',
    'This version transitioned the project from static HTML pages to a structured MVC-based PHP application running inside Docker.

- Set up the local development environment using Docker Compose with Apache, PHP 8.2, and MySQL.
- Added compose.yaml and a custom Dockerfile.
- Enabled mod_rewrite and .htaccess support.
- Implemented Apache rewrite rules to support clean URLs.
- Added a Front Controller pattern.
- Verified routing works correctly for /, /home, and /home/index.
- Established a structured MVC architecture within the src directory.
- Created a framework directory for core infrastructure logic.
- Implemented Application and Router classes.
- Added custom autoload.php with namespace-based class loading.
- Separated framework, controllers, models, and views for cleaner architecture.
- Refactored home.html.php into a pure view.
- Implemented layout templating with content injection.
- Added dynamic page title handling.
- Added structured variable passing.
- Added controller-driven stylesheet loading.
- Kept global CSS in the layout and injected page-specific styles conditionally.
- Updated asset paths to absolute URLs to support front controller routing.
- Implemented basic XSS prevention using htmlspecialchars().
- Verified the full request lifecycle from Apache rewrite to final rendered response.',
    NULL,
    '2026-02-08 09:00:00'
),
(
    'v0.4 - Authentication and Database Initialisation',
    'Development Update',
    'This version successfully transitioned the application from database connectivity to a full authentication flow with session handling.

- Added important.md in the Docs folder to provide access information and credentials.
- Designed and implemented the initial database schema for users, events, and bookings.
- Created SQL seed scripts inside db/init to automatically initialise tables and insert dummy data.
- Generated a secure hashed password for the initial admin account using password_hash().
- Verified Docker initialisation correctly creates the database when running docker compose down -v.
- Implemented full user registration using PDO prepared statements.
- Added server-side validation for required fields, email format, and minimum password length.
- Implemented secure password hashing and storage.
- Implemented login functionality using password_verify().
- Added session-based authentication.
- Configured global session handling so authentication state persists across pages.
- Implemented logout using session_unset() and session_destroy().
- Created a unified account.html.php page containing login and registration forms.
- Added dynamic display of the currently logged-in user in the navigation bar.
- Implemented conditional rendering in the layout to show login state and logout button.
- Conducted full register, login, and logout workflow testing.
- Verified session persistence and redirection behaviour.
- Confirmed automatic creation of the seeded admin account.
- Tested admin login using seeded credentials.
- Validated data persistence using phpMyAdmin on port 8081.',
    NULL,
    '2026-02-15 09:00:00'
),
(
    'v0.5 - Models, Database Helper and Dynamic Event Listings',
    'Development Update',
    'This version focused on improving the database architecture and preparing the backend for future functionality.

- Implemented a reusable DatabaseHelper class to centralise common database operations.
- Added reusable methods for find, insert, update, delete, and save.
- Reduced repeated SQL logic across the application.
- Introduced a models layer to separate database logic from controllers.
- Implemented UserModel and EventModel as entity classes.
- Introduced UserTable and EventTable to handle database interaction.
- Configured DatabaseHelper to map database results to model classes using PDO::FETCH_CLASS.
- Refactored AccountController to use model methods instead of direct PDO queries.
- Implemented model methods such as findByEmail() and register().
- Verified that the authentication workflow continued to work after refactoring.
- Generated event cards dynamically in events.html.php using database records.
- Replaced hardcoded placeholder event content with database-driven records.
- Implemented a dedicated events page with page header, sidebar filters, search bar, and event card grid.
- Added dynamic filter groups for event type and location.
- Added static date and sort filter controls for the initial browsing interface.
- Introduced collapsible filter sections using details and summary.
- Styled event cards as horizontal cards with images on the left.
- Formatted event dates for clearer presentation.
- Updated event badges and added event type display from the database.
- Added an event search bar in preparation for JavaScript and AJAX filtering.
- Refined card styling, spacing, and page layout consistency.',
    NULL,
    '2026-02-22 09:00:00'
),
(
    'v0.6 - Profile Management and Admin Event Tools',
    'Development Update',
    'This version focused on account management and the first version of the admin event management system.

- Implemented user profile management for logged-in users.
- Allowed users to update first name, last name, email, and password.
- Added password verification before allowing password changes.
- Updated session data after profile changes so navigation and account details stay in sync.
- Added a dedicated profile page layout.
- Created a cleaner account page structure with separate login and register forms.
- Implemented dynamic tab switching between login and register forms using JavaScript.
- Configured page-specific JavaScript loading through the layout.
- Started the admin panel for event management.
- Added role-based access control so only admin users can access admin routes.
- Added requireAdmin() protection in AdminController.
- Built the admin events page with a table layout.
- Displayed event details in the admin table.
- Added links for admin actions including create, edit, and delete.
- Created a dedicated create event page.
- Added a structured event form for title, type, category, date, location, and description.
- Implemented event creation logic in AdminController.
- Started the edit event page setup.
- Improved styling consistency for profile, account, and admin-related pages.
- Continued refining the MVC structure by keeping controllers responsible for requests and models responsible for database access.',
    NULL,
    '2026-03-01 09:00:00'
),
(
    'v0.7 - Event Details and Booking System',
    'Development Update',
    'This version focused on implementing event booking functionality and improving how users interact with individual events.

- Added a dedicated single event view page.
- Displayed detailed information for a selected event using dynamic routing with event IDs.
- Extended the Application routing system to support URL parameters.
- Allowed controller methods to receive dynamic values.
- Implemented the show() method in EventController.
- Retrieved and displayed individual events from the database.
- Integrated booking functionality into the event page.
- Allowed logged-in users to book events.
- Created a bookings table linking users and events using foreign keys.
- Implemented BookingTable and BookingController.
- Added event validation safeguards.
- Prevented users from booking past events.
- Added duplicate booking checks.
- Added conditional logic on the event page for different booking states.
- Handled already booked, event ended, and available booking states.
- Created a bookings page where users can view their bookings.
- Designed a two-column layout for the bookings page.
- Added booking cancellation functionality.
- Improved the booking user experience with a dedicated bookings.css file.',
    NULL,
    '2026-03-08 09:00:00'
),
(
    'v0.8 - AJAX Filtering, Dynamic Feedback and Error Handling',
    'Development Update',
    'This version focused on implementing AJAX functionality across the application and improving the user experience with dynamic updates and feedback.

- Implemented AJAX-based search and filtering on the public events page.
- Allowed users to dynamically update event listings without reloading the page.
- Created a unified filtering system combining search input, categories, locations, event types, date filters, and sorting.
- Handled filtering through EventController and EventTable.
- Developed dynamic DOM updates for event cards using JavaScript.
- Implemented AJAX search functionality in the admin panel.
- Added AJAX form handling for login and registration.
- Displayed inline success and error messages without page reloads.
- Implemented AJAX profile updates with real-time feedback and validation.
- Extended AJAX functionality to admin event management.
- Enabled asynchronous creation and editing of events.
- Integrated AJAX booking functionality on the single event page.
- Allowed users to book events without reloading.
- Added instant booking confirmation and error messages.
- Added reusable message components across forms.
- Implemented debounce in JavaScript to optimise search performance.
- Reduced unnecessary requests during typing.
- Improved user experience by disabling buttons and showing loading states.
- Introduced flash messaging using session variables.
- Improved feedback when users are redirected due to unauthorised access or invalid actions.
- Enhanced access control messages for restricted pages.
- Implemented a custom 404 error handling system.
- Added a dedicated error controller and error template.
- Refactored routing logic to handle invalid controllers and actions.
- Improved overall error handling.
- Refined UI styling for event pages and forms.',
    NULL,
    '2026-03-15 09:00:00'
),
(
    'v0.9 - PHPMailer, Booking Confirmations and Reminder Emails',
    'Development Update',
    'This version focused on automated email functionality for event bookings and scheduled backend processing.

- Implemented email functionality using PHPMailer.
- Added SMTP-based email sending within the application.
- Configured SMTP email delivery using Gmail.
- Used secure authentication through Gmail app passwords.
- Separated email credentials into a dedicated configuration file.
- Adjusted the project setup to support Composer dependencies inside Docker.
- Installed Composer inside the container.
- Ensured automatic dependency installation on container startup.
- Integrated email sending into the booking workflow.
- Enabled automatic booking confirmation emails after successful event booking.
- Developed a reusable EmailService class.
- Centralised email logic for better organisation and maintainability.
- Designed styled HTML email templates.
- Created consistent layouts for confirmation and reminder emails.
- Included headers, event detail cards, and formatted content in emails.
- Implemented 24-hour reminder email functionality.
- Notified users of upcoming events based on booking data.
- Extended the bookings database schema.
- Added confirmation_sent, confirmation_sent_at, reminder_sent, and reminder_sent_at fields.
- Used email status fields to prevent duplicate notifications.
- Created database methods to update confirmation and reminder statuses.
- Implemented a standalone PHP script to process and send reminder emails.
- Integrated a cron-based scheduling system inside the Docker container.
- Automated execution of the reminder script at regular intervals.
- Configured cron jobs to run every minute during development for testing.
- Added logging for cron execution.
- Refined booking controller logic for email sending, database updates, and JSON responses.
- Resolved a critical issue where the booking ID was not captured after insertion.
- Improved frontend booking robustness by validating server responses.
- Enhanced event creation by allowing admins to select both date and time using datetime-local inputs.
- Updated backend date handling for consistent formatting and storage.
- Improved overall reliability by addressing edge cases in booking, email delivery, and asynchronous communication.',
    NULL,
    '2026-03-22 09:00:00'
),
(
    'v1.0 - Final Polish, Dynamic Content and Advanced Features',
    'Development Update',
    'This version focused on completing the remaining advanced functionality, improving content management, and polishing the user interface after the main application features were implemented.

- Implemented dynamic date range filtering using separate start date and end date inputs.
- Replaced the old static date filter options with a flexible date range picker.
- Updated backend filtering logic so EventController and EventTable can return events between any two selected dates.
- Added a clear date button to reset the date range filter.
- Improved AJAX filtering so search, event type, category, location, date range, and sorting work together.
- Added visual event status indicators for upcoming, starting soon, and closed events.
- Colour-coded event cards based on their status.
- Fixed event card layout issues where text appeared squashed.
- Updated event card CSS so badges, titles, dates, locations, descriptions, and read more buttons display correctly.
- Added short event descriptions to public event cards.
- Added image upload functionality to the admin create event form.
- Added image upload functionality to the admin edit event form.
- Validated uploaded event images by file type and file size.
- Stored uploaded event images in the assets upload directory.
- Saved event image paths in the events table.
- Displayed uploaded event images on the public events page.
- Displayed uploaded event images on the single event detail page.
- Added a public blog page backed by the database.
- Created BlogModel and BlogTable to manage blog post data.
- Added seeded blog posts documenting assignment progress.
- Added admin functionality to create, edit, and delete blog posts.
- Integrated blog management into the main admin dashboard.
- Updated the homepage to show the latest blog post dynamically.
- Added a public contact page.
- Connected the contact form to the existing PHPMailer EmailService.
- Reused the shared HTML email layout for contact form messages.
- Added validation for contact form fields and email format.
- Added newsletter subscription functionality through the footer form.
- Created a subscribers table to store subscribed users.
- Created SubscriberModel, SubscriberTable, and SubscriberController.
- Added duplicate subscription handling.
- Added subscriber reactivation support.
- Extended EmailService to send new event notification emails to subscribers.
- Automatically notified active subscribers when an admin creates a new event.
- Fixed an issue where the event was created but AJAX showed a server error because the new event ID was not captured before sending subscriber emails.
- Added flash messages for admin actions and newsletter subscription feedback.
- Improved the footer newsletter design by placing the form inside a dark card-style container.
- Polished responsiveness across the home, events, blog, about, contact, account, bookings, and admin pages.
- Updated admin dashboard layout so event and blog tables appear one after the other.
- Improved mobile behaviour for cards, forms, tables, navigation, and footer content.
- Refined controller comments for better maintainability.
- Improved overall front-end spacing, readability, and consistency across the application.

Minor blocks resolved during this version:
- Replaced old static date filtering logic with dynamic start and end date conditions.
- Fixed event cards where the status label appeared but background colours were not visible.
- Fixed squashed event card text by adjusting grid widths, card layout, and responsive rules.
- Corrected the image upload path to match the project assets folder.
- Fixed AJAX event creation error caused by using an undefined event ID after saving.
- Updated EmailService so contact emails reuse the existing shared email layout correctly.
- Moved blog management into the main admin dashboard instead of a separate admin menu.
- Fixed readability issues on new pages where inherited colours made text difficult to see.
- Adjusted admin dashboard layout so tables are stacked vertically instead of side by side.
- Improved responsiveness after all main functionality was completed.',
    NULL,
    '2026-03-29 09:00:00'
);