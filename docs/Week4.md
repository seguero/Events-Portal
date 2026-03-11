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
