--WEEK 8--

9th Coding Session
This session focused on implementing automated email functionality for event bookings and enhancing backend processing through scheduled email sending tasks. The work builds upon the existing MVC architecture by integrating a third-party librarie (PHPMailer), improving system automation, and refining data handling and user experience.

-implemented email functionality using PHPMailer to handle SMTP-based email sending within the application
-configured SMTP email delivery using Gmail, including secure authentication via app passwords and separation of credentials into a dedicated configuration file
-adjusted project setup to support Composer dependencies within a Docker environment by installing Composer inside the container and ensuring automatic dependency installation on container startup
-integrated email sending into the booking workflow, enabling automatic booking confirmation emails upon successful event booking
-developed a reusable EmailService class to centralise email logic, improving code organisation and maintainability
-designed and implemented styled HTML email templates with a consistent layout, including headers, event detail cards, and formatted content for both confirmation and reminder emails
-implemented 24-hour reminder email functionality, notifying users of upcoming events based on booking data
-extended the bookings database schema with confirmation_sent, confirmation_sent_at, reminder_sent, and reminder_sent_at fields to track email status and prevent duplicate notifications
-created database methods to update confirmation and reminder statuses after successful email delivery
-implemented a standalone PHP script to process and send reminder emails
-integrated a cron-based scheduling system within the Docker container to automate execution of the reminder script at regular intervals
-configured cron jobs to run every minute during development for testing purposes, enabling rapid validation of email functionality and system behaviour
-added logging for cron execution to monitor automated processes and debug issues
-refined booking controller logic to ensure proper handling of email sending, database updates, and JSON responses for AJAX requests
-resolved a critical issue where the booking ID was not captured after insertion, preventing confirmation tracking from updating correctly
-improved robustness of frontend booking logic by debugging and validating server responses
-enhanced event creation functionality by allowing admins to select both date and time using datetime-local inputs instead of date-only inputs
-updated backend date handling to ensure consistent formatting and storage of event date and time values
-improved overall system reliability by addressing edge cases in booking, email delivery, and asynchronous communication

MINOR BLOCKS

Encountered multiple issues during the implementation of automated email and scheduling functionality:

Issue 1: Timezone mismatch between PHP, MySQL, and CLI scripts
Error: Reminder script failed to detect events within the correct 24-hour window.
Root cause: Different components (PHP web requests, CLI scripts, and database) were using inconsistent timezones, causing incorrect time comparisons.
Resolution: Standardised timezone configuration across the application, including explicitly setting the timezone and ensuring consistent date handling using PHP-generated timestamps.
Impact: Ensured accurate detection of upcoming events and reliable reminder scheduling.

Issue 2: Cron job not executing as expected
Error: Cron log remained empty despite correct configuration.
Root cause: Multiple issues including missing newline in crontab file, incorrect file formatting (Windows CRLF line endings), and entrypoint script preventing cron from starting.
Resolution: Fixed crontab formatting, ensured LF line endings, added required SHELL and PATH variables, and corrected Docker entrypoint to start cron before Apache.
Impact: Enabled reliable execution of scheduled tasks within the Docker environment.

Issue 3: SMTP configuration not available in cron execution
Error: PHPMailer failed with “Invalid address (From)” during cron execution.
Root cause: Environment variables defined in Docker were not accessible to cron jobs.
Resolution: Moved SMTP credentials into a dedicated PHP configuration file accessed directly by EmailService.
Impact: Ensured consistent email configuration across both web requests and scheduled scripts.

Issue 4: Booking AJAX showing error despite successful booking
Error: Frontend displayed “Unable to complete booking” while booking was successfully saved.
Root cause: Invalid JSON response caused by PHP warnings and unintended output from configuration file (mail.php)
Resolution: Removed output from configuration file, debugged and ensured proper JSON responses
Impact: Restored correct frontend feedback and improved reliability of AJAX interactions.

Issue 5: Confirmation tracking not updating
Error: confirmation_sent and confirmation_sent_at fields remained unchanged after booking.
Root cause: Booking ID was not captured from the save function, resulting in an undefined variable during update.
Resolution: Stored the returned booking ID and used it to update confirmation status after successful email sending.
Impact: Enabled accurate tracking of email delivery status.

Issue 6: Event time defaulting to midnight
Error: Events were saved with time 00:00 regardless of user input.
Root cause: Form used a date-only input field, omitting time data.
Resolution: Replaced input type with datetime-local and updated backend formatting to handle full datetime values.
Impact: Improved accuracy and usability of event scheduling.

    //Plan for next coding session
    -implement date range picker filtering
    -finish the views of other pages (blog, about, contact)
    -once functionality is fully achieved, commence front-end design
    -improve responsiveness across all pages
    -conduct full system testing and edge case validation
    -prepare report sections for submission
