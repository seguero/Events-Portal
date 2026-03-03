--WEEK 3--

4th Coding Session
This session successfully transitioned the application from database connectivity to fully functional authentication flow with session handling
-added important.md in Docs folder to provide information about accessing the web app and note credentials
-designed and implemented initial database schema (users, events, bookings)
-created SQL seed scripts inside db/init/ to automatically initialise tables and insert dummy data
-generated secure hashed password for initial admin account using password_hash()
-verified Docker initialisation process correctly creates database structure when using docker compose down -v
-implemented full user registration functionality using PDO prepared statements
-added server-side validation for required fields, email format and minimum password length
-implemented secure password hashing and storage in database
-implemented login functionality using password_verify() and session-based authentication
-configured global session handling to allow authentication state persistence across pages
-implemented logout functionality using session_unset() and session_destroy()
-created a unified account.html.php page containing both login and registration forms (designed to support future JavaScript sliding transition)
-added dynamic display of currently logged-in user in navigation bar
-implemented conditional rendering in layout to show login state and logout button
-conducted full register → login → logout workflow testing
-verified session persistence and correct redirection behaviour
-confirmed automatic creation of seed admin account via Docker database initialisation
-tested admin login using seeded credentials to validate password hashing and authentication logic
-validated data persistence using phpMyAdmin (port 8081)

MINOR BLOCKS

Encountered two minor development issues during implementation:

1.Database connection failure during PDO setup
Error: could not find driver
Root cause: Docker PHP image did not include the pdo_mysql extension
Resolution: Updated Dockerfile to install pdo_mysql, rebuilt container using docker compose up -d --build

2.Database insertion failure during registration testing
Root cause: mismatch between database column names and SQL query field names (e.g. userid vs userId)
Resolution: aligned SQL schema and controller queries to ensure consistent naming conventions

Impact: Minor delays during testing and schema alignment; resolved without architectural refactoring.

    // Plan for next coding session
    -implement a Database Helper to reuse functions such as insert, update, fetch to improve code readability/quality
    -start work on the events page
    -add admin panel (CRUD implementation to manage users and events)
    -create booking system for standar role users
    -finish the views of other pages (blog, about, contact)
    -once functionality is fully achieved, commence front-end design
