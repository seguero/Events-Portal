# Important Setup Information

## Database

During initial database creation, the seed SQL script automatically creates the required tables and inserts a default administrator account.

/db/init/002_seed.sql

This allows immediate system access after deployment and ensures consistent testing conditions. The administrator password is stored securely using PHP's `password_hash()` function before being inserted into the database.

## Admin Credentials

Email: admin@csym019.test
Password: Admin123!

## Database / PDO Credentials

The application connects to the MySQL container using the following credentials:

$host = 'db';
$db = 'csym019_db';
$user = 'csym019_user';
$pass = 'csym019_pass';

## Local URLs

After starting Docker, the application can be accessed at:

Web application: http://localhost:8080
phpMyAdmin: http://localhost:8081

## Docker Commands

Start or rebuild the application:
docker compose up -d --build

Stop the application:
docker compose down

Reset the database and remove existing database data:
docker compose down -v

After resetting the database, start the project again:
docker compose up -d --build

Allow the database container around one minute to initialise before opening the website. Opening the site too quickly may cause a temporary database connection error.

## Composer Dependencies

The PHP container automatically installs Composer dependencies on startup if the `vendor` folder is missing.

Composer dependencies include:

PHPMailer
PHPUnit

PHPMailer is used for SMTP email functionality. PHPUnit is used for whitebox/integration testing of selected PHP model methods.

## PHPUnit Testing

PHPUnit tests are located in:
src/tests

To run the test suite, use:
docker compose exec web vendor/bin/phpunit

A successful test run should show output similar to:
OK (20 tests, 48 assertions)

The tests cover selected model/database logic, including event filtering, event persistence, booking checks, user related functions, and blog post operations.

## Main Project Structure

src/controllers PHP controller classes
src/models Database table classes and model classes
src/pages PHP view templates
src/framework Routing, database, and application helper classes
src/javascript JavaScript and AJAX files
src/styles CSS files
src/tests PHPUnit tests
db/init Database schema and seed SQL files

## Email / PHPMailer Notes

Email functionality uses PHPMailer and is configured through the application email configuration file (config/mail.php). The configuration file is included in the project files, so booking confirmations, subscriber alerts, and contact form emails can be sent with the current credentials.

## Reminder Script Notes

The booking model includes reminder-status fields and methods for finding bookings that need reminders. The reminder script should be executed by a server cron job at a minute interval and target bookings with less than 24 hours untill event start date.

If the cron job doesn't run automatically as I encountered issues during development, use the following command to send reminder emails manually:
docker compose exec web php scripts/send-reminders.php

## Notes for Markers

The project uses Docker containers for PHP/Apache, MySQL, and phpMyAdmin. The database is automatically seeded on first startup.

If the application does not connect immediately after startup, wait briefly for MySQL to finish initialising and refresh the page.
