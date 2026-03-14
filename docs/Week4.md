--WEEK 4--

5th Coding Session
This session focused on improving the database architecture and preparing the backend structure for upcoming functionality. The refactoring improves code maintainability by separating controllers, models, and views, effectively completing the implementation of a full MVC (Model–View–Controller) architecture for the application.

-implemented a reusable DatabaseHelper class to centralise common database operations (find, insert, update, delete, save) and reduce repeated SQL logic
-introduced a models layer to separate database logic from controllers
-implemented UserModel and EventModel as entity classes representing database records, and introduced UserTable and EventTable to handle all database interactions with the users and events tables
-configured DatabaseHelper to map database results directly to model classes using PDO::FETCH_CLASS
-refactored AccountController to use UserModel methods instead of direct PDO queries
-implemented model methods such as findByEmail() and register() to simplify controller logic
-verified the authentication workflow (register → login → logout) continues to function correctly after refactoring
-generated event cards dynamically in events.html.php using database records instead of hardcoded placeholder content
-implemented a dedicated events page structure including page header, sidebar filters, search bar, and event card grid
-added dynamic filter groups for event type and location by retrieving distinct values from the database
-added static date and sort filter controls to complete the initial event browsing interface
-introduced collapsible filter sections in the sidebar using <details> and <summary> for a cleaner and more organised user interface
-styled the events page cards as horizontal cards with the image positioned on the left to visually differentiate them from homepage cards
-formatted event dates for clearer presentation within the event cards
-updated event badges and added a new column in events table to display the event type dynamically from the database
-added an event search bar to prepare the page structure for upcoming JavaScript and AJAX-based filtering functionality
-refined card styling and page layout styling across the project to improve consistency, spacing, and overall visual structure
-made small layout and navigation styling adjustments during development to improve readability and visual balance across pages

MINOR BLOCKS

Encountered a warning during model implementation:

Error: Deprecated:
Deprecated: Creation of dynamic property models\UserModel::$role is deprecated in /var/www/html/framework/DatabaseHelper.php on line 46
Root cause: PDO attempted to populate database columns that were not explicitly declared as properties in UserModel.

Resolution:
Added missing properties (role, created_at) to the UserModel class.

Impact:
Minor debugging required; resolved quickly without affecting functionality.

    //Plan for next coding session
    -add admin panel (CRUD implementation to manage users and events)
    -add event specific view page with in-depth view and booking functionality
    -add account/profile management for standard users
    -start with the JavaScript / AJAX dynamic content update
    -create booking system for standard role users
    -finish the views of other pages (blog, about, contact)
    -once functionality is fully achieved, commence front-end design

6th Coding Session
This session focused on extending user account functionality and starting the admin event management interface. The work improved both usability and maintainability by adding profile update features, access control for admin-only pages, and clean page layouts for account and admin sections.

-implemented user profile management for logged-in users, including updating first name, last name, email, and password
-added password verification before allowing password changes to improve account security
-updated session data after profile changes so the navigation and account details stay in sync without requiring a new login
-added a dedicated profile page layout with a simple and functional form for editing user information
-created a cleaner account page structure with separate login and register forms
-implemented dynamic tab switching between login and register forms on the account page using JavaScript
-configured page-specific JavaScript loading through the layout so scripts can be attached only where needed
-started the admin panel for event management with role-based access control so only admin users can access admin routes
-added requireAdmin() protection in AdminController to redirect unauthorised users from admin pages
-built the admin events page with a table layout showing event details
-added links for admin actions including create, edit, and delete
-created a dedicated create event page with a structured form for entering title, type, category, date, location, and description
-implemented event creation logic in AdminController to save submitted event data into the database
-started the edit event page setup so it matches the same layout and structure as the create event page
-improved styling consistency by creating clean and functional layouts for profile, account, and admin-related pages
-continued refining the overall MVC structure by keeping controllers responsible for request handling and models responsible for database access

MINOR BLOCK

Encountered a database error while implementing the profile update functionality:

Error:
PDOException: SQLSTATE[HY093]: Invalid parameter number

Root cause:
Mismatch between the SQL query placeholders and the parameters passed to PDOStatement::execute() in the reusable DatabaseHelper::update() method.

Resolution:
Adjusted the update query to use the actual table primary key placeholder so the SQL statement matched the record data correctly.

Impact:
Minor debugging required; profile update functionality was restored without affecting the rest of the CRUD system.

    //Plan for next coding session
    -add event specific view page with in-depth view and booking functionality
    -use AJAX to display success and error messages without reloading the page for login, register, profile update, and admin actions
    -connect public event search and filters to AJAX and JSON responses
    -handle unauthorized page access with friendlier feedback messages
    -create booking system for standard role users
    -finish the views of other pages (blog, about, contact)
    -once functionality is fully achieved, commence front-end design
