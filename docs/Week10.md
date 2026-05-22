--WEEK 10--

11th Coding Session

This final coding session focused on testing, refinement, bug fixing, and preparing the application for final submission. At this stage, the main functionality and advanced features had already been implemented, so the work concentrated on verifying that the system behaved correctly.

-implemented PHPUnit whitebox/integration tests for selected model classes
-created tests for EventTable to verify event filtering, keyword search, category filtering, location filtering, date range filtering, sorting, event creation, event updating, and event deletion
-created tests for BookingTable to verify duplicate booking detection and event-specific booking checks
-created tests for UserTable to verify user registration, email lookup, password hashing, updating, and deletion
-created tests for BlogTable to verify blog post creation, updating, latest post retrieval, and deletion
-configured phpunit.xml and a test bootstrap file so PHPUnit can load Composer dependencies and the custom application autoloader
-ran the PHPUnit test suite inside the Docker web container using docker compose exec web vendor/bin/phpunit
-confirmed that all PHPUnit tests passed successfully
-carried out end-to-end testing across the main public and admin workflows
-tested admin login, event creation, event editing, event deletion, blog management, user registration, user login, event booking, booking cancellation, contact form submission, and newsletter subscription
-tested the public AJAX event filtering feature using keyword search, event type filters, category filters, location filters, date range filters, sorting, and the clear date button
-tested AJAX success and error handling for public filtering, booking submission, login/register forms, and admin event create/edit forms
-fixed an admin page search bar bug where the search script was not correctly updating the admin events table
-updated the admin search JavaScript and table body targeting so search results display correctly without requiring a full page reload
-reviewed fetch request paths and confirmed that the admin search endpoint returns JSON data in the expected format
-tested responsiveness across desktop, tablet, and mobile screen sizes using browser developer tools
-made small CSS updates to improve spacing, form layout, table behaviour, card alignment, and mobile stacking
-improved responsive behaviour for admin tables so content remains usable on smaller screens
-polished event cards, blog cards, forms, footer elements, and account pages for consistent spacing and visual presentation
-checked that uploaded event images display correctly on the public events page and single event page
-checked that fallback placeholder images are still used when no uploaded image exists
-tested validation behaviour for empty forms, invalid date ranges, duplicate bookings, duplicate email registration, and invalid login credentials
-verified that flash messages and AJAX inline messages provide clear feedback to users and administrators
-tested the manual reminder script command through Docker to confirm the reminder workflow can be executed from the terminal
-reviewed important setup notes to ensure Docker commands, admin credentials, database credentials, PHPUnit instructions, and email notes are clearly documented
-added source/reference notes for external tools and libraries including Font Awesome, PHPMailer, Google SMTP, Apache mod_rewrite, htmlspecialchars, and cron
-prepared final testing evidence and screenshots for the technical report
-reviewed the technical report sections to ensure the implementation, architecture, security, maintainability, AJAX/JSON usage, database design, and testing approach are clearly explained
-prepared the final video demonstration plan so the main requirements and advanced features can be shown within the time limit
-finalised the project for submission by checking the Docker setup, database seed process, setup instructions, and GitHub repository contents

MINOR BLOCKS

Encountered several final issues while testing and preparing the project for submission:

Issue 1: PHPUnit could not initially find the configuration file
Error: Running vendor/bin/phpunit displayed the PHPUnit usage screen or reported that phpunit.xml could not be found.
Root cause: The Docker container mounted the src folder as /var/www/html, so phpunit.xml had been placed in the wrong project level from the container’s perspective.
Resolution: Moved phpunit.xml into the container-visible application root and updated the test directory path to match the Docker file structure.
Impact: PHPUnit now detects the configuration file and runs the test suite correctly from inside the web container.

Issue 2: Admin search bar did not update the event table correctly
Error: Typing into the admin search box did not consistently update the admin events table.
Root cause: The JavaScript search logic and the admin table body needed to target the correct admin-specific elements and handle the JSON response consistently.
Resolution: Updated the admin search script and table body targeting so the AJAX response renders the filtered event rows correctly.
Impact: Admin users can now search events dynamically from the dashboard without reloading the page.

FINAL STATUS

The application is now feature complete and ready for final submission. Core requirements have been implemented, including admin event management, public event listing, AJAX search and filtering, JSON responses, PHP/MySQL database integration, and maintainable MVC-style structure. Additional features such as user accounts, event bookings, blog management, contact form emails, subscriber notifications, reminder support, image uploads, and PHPUnit testing provide extra value beyond the minimum brief.
