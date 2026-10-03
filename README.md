Community Events
Management Web Application
Sergiu Popa
Student ID: 20421506
University of Northampton, Northampton, United Kingdom
sergiu.popa20@my.northampton.ac.uk
GitHub Repository: 
https://github.com/D12AOS/csym019-internet-programming-assignment-seguero
Video Demonstration:
https://mymedia.northampton.ac.uk/media/Internet+Programming+Demo/0_txxut25i

1.	Introduction

This project is a full-stack web application developed for the CSYM019 Internet Programming assignment. The system  was designed for a community organization that requires a web portal to manage and showcase upcoming events and workshops.  The website allows  the staff to create and update event related content and  post news to keep the users  up to date, while customers may view that content or create an account to register their attendance . On top of that, customers will benefit from extra features such as e-mail notifications  on booked events, e-mail reminders for upcoming events and the possibility to subscribe to a newsletter and get  informed when new events are announced.

2.	Project Requirements and Objectives

The assignment aims for the development of content management web application using HTML, CSS, JavaScript, JSON, AJAX, PHP, and MySQL together in one integrated system.
The first core requirement is to create a secure webpage where staff/admins can log in and manage events by adding, editing, and deleting records through HTML forms, then they need to be stored and retrieved from a MySQL database using PHP.
The second core requirements is the public side of the application that needs to display upcoming events in a user-friendly layout and showing key information about the events.
On top of that, the brief also requires interactive search and filtering, allowing users to filter events dynamically without reloading the page. This was achieved through JavaScript and AJAX requests, with PHP returning database results in a JSON format.


The table below shows the full list of implementations:

Requirement	Implementation	Status	Type
Admin event management	Admin dashboard with create, edit and delete event forms, search bar	Core	Functional
Public event listing	Events page displays database-driven event cards	Core	Functional
Search and Filter	AJAX search, checkbox filters and sorting	Core	Functional
Dynamic content update	AJAX feedback on all forms, filters and search	Core	Functional
Account System	Users can create an account and log in	Extra	Functional
Bookings	Logged-in users can book events and view upcoming or past bookings or cancel them	Extra	Functional
Blog System	Admins can create, edit and delete blog posts, while users can read blog updates	Extra	Functional
Date range picker	Forms fields to filter event by start date and end date and a reset input button	Extra	Functional
E-mail Notification	SMTP server sending emails to users with booking details, uses PHPMailer library	Extra	Functional
E-mail Reminders	Sending emails when < 24 hours to event, cron runs a script regularly to check bookings	Extra	Functional
Newsletter Subscribe	Form field allows users to subscribe to newsletter and receive emails for new events	Extra	Functional
Contact Form	Form that allows a user to contact the management	Extra	Functional
About Page	About page that summarizes features on website	Extra	Functional
Home Page	Shows popular events (by number of bookings), recently added and latest blogs	Extra	Functional
Badges	Event Type and availability color coded badges	Extra	Functional
Image Upload	Events support image upload, stored in src/assets/uploads	Extra	Functional
PHPUnit	Whitebox testing for main database functions	Extra	Functional
Maintanability	MVC-style structure with models, views, controllers and reusable database helper	Core	Non Functional
Security	PHP sessions, password hashing, prepared statements, escaping output, input validation	Core	Non Functional
Testing	PHPUnit for database functions and manual browser testing	Core	Non Functional
Version Control	Regular GitHub updates with meaningful commit history	Core	Non Functional
User Friendly Interface	Clean and stylish UI, no CSS frameworks used	Core	Non Functional
Navigation	Persistent navigation bar with icons powered by FontsAwesome library	Core	Non Functional
Responsive design	CSS grids used and media queries to make page accessible on different screen sizes	Core	Non Functional
Error handling	Implemented on forms submissions and AJAX requests	Core	Non Functional
3          System Design and Architecture
The architecture was designed to support maintainability by separating responsibilitie as follows: models define the data structure, table classes handle database access, controllers manage application logic, and templates display the interface, overall making the system easier to debug because each part of the codebase has a clear purpose.
3.1       MVC-Style Architecture
The project uses a MVC structure to improve organisation and reduce duplicated code, to demonstrate how the data flows inside this structure I will use the event entity as an example throughout this section.
 
Figure 1 MVC Architecture Flow
The model layer represents the data used by the application, EventModel represents a single event and includes the following fields: eventid, event_type, category, title, description, event_date, location, image_path, created_at, booking_count.
The table classes act as the data access layer, containing the SQL logic that communicates with the database. For example, the fields enumerated in the previous paragraph are used in the EventTable to build advanced queries that find and display filtered events or search for specific ones, this way preventng SQL from being scattered throughout the templates and making it easier to update database logic in one place.
The controller layer is responsible for handling user requests and coordinating the flow between the model, table class, and view. Expanding on the event example, when a user visits the events page, the EventController requests data from EventTable and then passes this data to the events view so it can be displayed to the user. The controller only acts as the connection point that decides what data is needed and which template should render the response.
The view layer contains PHP template files that output the final HTML structure and are responsible for presenting data rather than controlling the main application logic. Using the previous example, the events page loops through event records and displays their fields in the form of event cards.
3.2       Database Overview
The database is created with the help of two SQL scripts stored in the db/init folder. Firstly, the schema script defines the database tables used by the application, which use the appropriate data types, primary keys, AUTO_INCREMENT ids, NOT NULL constraints, default values, and foreign key relationships. This schema script also acts as a database export, meaning that database is initialized automatically when the docker container is started (explained in section 10).
 
Figure 2 Database tables overview in phpAdmin
Secondly, a separate seed script is used to populate the database with initial test data, inserting dummy events so that the website can be tested immediately after setup, it also creates a default administrator account (seeded admin password is stored as a hashed value rather th an plain text) and the seed script also inserts blog posts, which are currently used to show a history of GitHub commits and development progress throughout the assignment.
 
Figure 3 Admin user DB seed
Table	Purpose	Fields
users	Stores user/admin accounts	userid, firstname, lastname, email, password, role, created_at
events	Stores event details	eventid, title, event_type, category, event_date, location, image_path, created_at
bookings	Stores event bookings	Bookingid, userid, eventid, booked_at, confirmation_sent, confirmation_sent_at, reminder_sent, reminder_sent_at
blog_posts	Stores blog updates	Postid, title, category, content, created_at, updated_at
subscribers	Stores subscribers	Subscriber_id, email, is_active, subscribed_at
The database design separates event data, user/admin data, and booking data into different tables to reduce duplication and keep responsibilities clear. The bookings table acts as a link between users and events by storing both userid and eventid as foreign keys, creating a many-to-many relationship where one user can book many events, and one event can have many users booked onto it. Keeping bookings in a separate table also allows the system to store booking-specific fields such as booking time, confirmation status, and reminder status without mixing this data into the users or events tables. This separation supports maintainability because admin/user account data remains independent from event content, while attendance tracking is handled by the booking table.
 
Figure 4 Entity Relationship Diagram
3.3       Database Data Flow
The use of a reusable Databasehelper.php class reduces repetition. Instead of writing the same SQL logic in many different files, common operations can be handled through reusable methods, while individual table classes provide more specific methods where needed, such as checking whether a reminder has already been sent.
The data flow begins when a user or admin interacts with a page. For example, when an admin creates an event, the form sends the data to the EventController which validates and prepares it before being passed to EventTable class to perform the database operation and then becoming available on the page.
For event filtering, the data flow works slightly differently because it uses AJAX. The user selects filters or enters a search term, JavaScript sends the request to the server, then PHP queries the database based on the selected filters, and the matching results are returned as JSON format, which is furtherly used to update the content dynamically on the view.
3.4       Application Entry Point, Routing and Autoloading
The single entry point of the application is through index.php, meaning that when a request reaches the application, index.php loads the required files, starts the application process, and passes control to the routing system, this way every request is handled through the application’s routing and controller structure.
The .htaccess file is used to support clean URLs through Apache’s mod_rewrite module. It first enables URL rewriting, then checks whether the requested path is already a real file or folder, in which case Apache serves it normally, which allows CSS, JavaScript, images, and uploaded files to load correctly, if not it is then sent to index.php, which acts as the front controller.
 
Figure 5 mod_rewrite in .htaccess
The project is using an autoloader file which is responsible for automatically loading classes when they are needed, instead of manually requiring every controller, model, or helper file, the autoloader maps class names to their file locations, therefore reducing repeated require statements and making the codebase easier to maintain as more classes are added.
The router.php file defines the routes used by the application. Each route connects a URL pattern to a specific controller action, for example /events is mapped to an events controller method that loads the event listing page, while an admin route such as /admin/create is mapped to a function that displays the create event form, providing URL separation from the page template.
 
Figure 6 Controller Routes
The overall request handling process is handled by application.php which is working with the router to identify which controller and method should be executed for the current URL. After the controller has processed the request and prepared the required data, the application loads the template and injects the layout into the web page.
This creates a clear flow: the .htaccess file redirects requests to index.php, the application loads required files, the router matches the URL, the controller prepares the data, and the view displays the final page.
 
Figure 7 Application flow
3.5       Docker Development Environment
Docker was used to provide a consistent development environment for the application, instead of depending on the local machine’s installed versions of PHP, Apache, MySQL, and related extensions.
The Docker setup includes a PHP and Apache web container for running the application and a MySQL database container for storing the system data. The PHP container provides the server-side runtime needed for the controllers, models, routing files, and templates. Apache serves the website and supports clean URLs through mod_rewrite. The MySQL container stores the database tables for events, users, bookings, blog posts, and subscribers.
The project’s Dockerfile configures the PHP-Apache environment by enabling Apache rewrite support and installing MySQL, required for database communication. Composer is also included so that PHPMailer, can be installed and managed properly. In addition, cron is installed and configured so that send-reminder.php script runs at 1-minute intervals (chosen deliberately so it can be tested).
4          Implementation of Core Features
4.1       Admin Event Management
The admin event management system was implemented to allow authorised staff to manage event content without needing direct access to the database, therefore after a successful login an administrator can access the dashboard using the shield icon in the navigation at the top of the page, where all existing events are displayed in a structured table featuring action buttons for editing or deleting individual events, as well as an option to create a new event.
 
Figure 8 Admin page
The create event form allows administrators to insert a new record. The form uses appropriate HTML input types, all fields are mandatory and the form also includes an inline message area to provide feedback on the missing input.
The page uses the createEventForm form with method="post", action="/admin/store", and enctype="multipart/form-data" to support image uploads (which are stored in src/assets/uploads), while the edit event page uses editEventForm and submits to /admin/update, including a hidden eventid field so the controller indentifies which record to update and also prefills the data in the form. Similarly, the delete button is using the eventid to identify and remove the correct record, while also asking for a confirmation before doing so. The controller validates the submitted event data, formats the datetime-local value into a MySQL-compatible date format, processes the uploaded image by checking for correct format, and then calls EventTable::save().
 
Figure 9 Create event page
 
Figure 10 Edit Event Page
4.2  Event Listing
The event listing page was implemented to allow visitors to browse events in a user-friendly format. Events are retrieved from the MySQL database and displayed as event cards, with each card including the event image, event type, status badges, title, date, location, description, and a link to read more. The page features event status badges to improve the user experience, shown as “Upcoming”, “Starting soon”, or “Closed”, these are color coded depending on the event date and time and calculated by comparing the time of event with the current time. This makes the event list more informative because users can quickly understand whether an event is still available or has already passed.
 
Figure 11 Events page
The events page is populated by the controller using EventTable::findAll() and additional methods such as findEventTypes(), findCategories(), and findLocations() to build the filter sidebar dynamically from database values of each event.
4.3  Single Event Page
A single event details page was created so users can view more in depth information about a selected event. When a user clicks “Read more”, the event ID is passed through the route /events/show/{eventid}. The event controller uses EventTable::findById() to retrieve the matching event and passes it to the single event view.
 
Figure 12 Single event page
This page demonstrates how the routing and controller system works with individual database records, highlighting how the eventid is used to retrieve the correct event from the database (events/show/2), and the selected event object is passed to the view for rendering.
4.4  Search and Filtering Functionality
The event listing page includes AJAX-based search and filtering interface made up of the event-search-input search box and the events-filter-form, which contains event type, category, location, date range, and sorting controls. When the user types into the search box, the JavaScript waits using a debounce timer before running updateEvents(). When a user changes any filter control, updateEvents() runs immediately.
The updateEvents() function calls buildQueryString(), which collects the search value and all selected form values. It then sends an asynchronous fetch() request to /events/search, including the headers allowing the request to be handled as an AJAX request rather than a normal page load.
The /events/search route is handled by EventController::search() which reads the submitted GET values into a $filters array. It also validates the date inputs to ensure they match the correct YYYY-MM-DD format and checks that the start date is not after the end date. If validation fails, it returns a JSON error response, if validation passes, the controller sends the filters to EventTable::filterEvents().
The filterEvents() method builds the SQL query dynamically based on the selected filters. It supports checkbox filters by generating named placeholders for each selected value, date range filtering using start_date and end_date, and sorting by date, newest, or location. The query is executed using prepared statements and named parameters, preventing SQL injection.
The filtered events are returned from PHP as a JSON format containing success: true and an events array before being passed by JavaScript to renderEvents(), which rebuilds the .events-list container with updated event cards. If there are no matching events, the page displays a “No events found” message. If the request fails, renderError() displays a friendly error message.
4.5  Dynamic Content Updates and User Feedback
Dynamic feedback was added to improve the user experience across the application. AJAX feedback is connected to message elements like createEventMessage, editEventMessage, loginMessage, and registerMessage. When the server returns a JSON success or error response, JavaScript updates these elements instead of forcing a full page reload.
                                               
Figure 13 User Feedback Message
These dynamic updates support the assignment requirement to use AJAX where appropriate and make the system feel more responsive and modern. Error handling is especially important because users need to know when an action has succeeded or failed, such as when a form contains invalid data or when the server cannot process a request.
 
Figure 14 User Feedback Message 2
5     Innovation and Extra Features
The project includes several advanced features beyond the core requirements, which were added to make the application more realistic as a community event management system and to improve the experience for both users and administrators.
    5.1  Account System
New and existing users can use the account system to register and log in through a dedicated account page that includes separate forms for registration and login using appropriate input types. On the account page, there is only one form featuring a switch that alternates between the two features using EventListeners in account.js.
This feature improves the application by allowing the system to distinguish between visitors, registered users, and administrators, while also supporting secure access control for restricted areas of the site.
The registration form uses id="registerForm" and submit a POST request to /account/registerSubmit, while the login form uses id="loginForm" and sends it to /account/loginSubmit. The submitted data is processed by AccountController, which validates the input, checks existing users through UserTable::findByEmail(), and creates new users through UserTable::register(). Passwords are hashed before being stored, and PHP sessions are used after successful login to keep the user authenticated.
 
Figure 15 Account Page
5.2  Event Booking System
The booking system allows logged-in users to book upcoming events from the single event page. A form submits the selected eventid to /booking/store. Before saving, the booking controller checks whether the user is logged in, whether the event is upcoming, and whether BookingTable::exists($userid, $eventid) already returns true. If the checks passes, the booking is saved through BookingTable::save().
 
Figure 16 Bookings Page
The page includes safeguards: users must be logged in to book an event, past events cannot be booked, and duplicate bookings are prevented. Duplicate bookings are prevented through BookingTable::exists(), which checks the user ID and event ID before creating a booking. A
A bookings page separates each user’s bookings into upcoming events that can be cancelled and past events that remain as history.
5.3  Advanced Date Range Filtering
Users can choose a start date and end date to find events happening within a specific period. The filter sidebar also includes a clear dates button, allowing users to quickly reset the date range without refreshing the page. The date inputs start_date and end_date are passed to EventTable::filterEvents(), where they are converted into full-day ranges using 00:00:00 and 23:59:59.
 
Figure 17 Date range filter
5.4  Email Confirmations and Reminders, Subscribers and Contact Form
The application uses PHPMailer with Google SMTP to send automated emails. SMTP credentials (host, port, username, app password, sender) are stored in a separate configuration file (src/config/mail.php).
The EmailService.php class centralises all email functionality so PHPMailer does not need to be configured separately in each controller or script. In the constructor, the class loads SMTP credentials, creates a PHPMailer instance, enables SMTP, sets the Google SMTP host, authentication details, configures a TLS encryption, port 587, and the sender address. The sendEmail() method is reused by every email type; it clears previous recipients and attachments, adds the new recipient, sets the subject, HTML body, plain-text fallback body, and sends the message. Specific public methods such as sendBookingConfirmation(), sendEventReminder(), sendNewEventNotification(), and sendContactMessage() only build the content needed for that email type, then pass it into the shared sending method. The class also includes helper methods: buildEmailLayout(), buildEventDetails(), buildDetailRow(), formatDate(), and escape(), which creates a consistent HTML email design, format event dates, and escape dynamic values before inserting them into the email body. This makes the email system reusable for booking confirmations, 24-hour reminders, subscriber alerts, and contact form messages while adhering to the DRY (Don’t Repeat Yourself) principle.
When a user books an event, the booking confirmation email is sent using the shared mailer class. The booking record also includes fields for tracking whether the confirmation was sent and when it was sent.
 
Figure 18 Booking Confirmation
For reminders, a cron job runs send-reminders.php script at scheduled intervals by checking the database for bookings linked to events happening within the next 24 hours where reminder_sent is set to 0. After sending the reminder email, the booking record is updated so the same reminder is not sent again.
 
Figure 19 Reminder Confirmation
 
Figure 20 Cron task and reminder script
Subscriber alerts use the same mailer class. When a new event is created, active subscribers are retrieved from the subscribers table and notified by email.
 
Figure 21 Subscriber notification
The contact form also uses the email system to send user enquiries to the site administrator. Users enter their name, email address, subject, and message, and the form submits this data to the contact controller for processing, then message sent through the same SMTP/PHPMailer setup, keeping email delivery consistent across the application. The demonstration is shown in the video but or testing the contact form functionality, the markers should enter their own credentials in the config.php file. This includes using app password for your Google account which implies turning 2FA on (for full instructions check the link in docs/important.md).
 
Figure 22 Contact message
5.5  Blog System
Administrators can manage blog posts from the admin dashboard in a similar way as events, while users can read updates through the separate blog page. Blog posts are managed through admin forms that submit to the following routes: /admin/storeBlog and /admin/updateBlog, then the controller passes the posted values to BlogTable::save(), while public blog pages retrieve posts through BlogTable::findAll() and BlogTable::findById().
 
Figure 23 Admin blog management
The public blog page displays posts as cards with a category, title, date, content preview, and a link to read the full post which have their own page where the full content is displayed. Note that in the current deployment, the blog is used to show the history of GitHub commits and progress on the assignment.
 
Figure 24 Blog Page
5.6       Home Page
The homepage is handled by HomeController::index(), which prepares the dynamic content shown on the landing page. In the constructor, the controller creates instances of EventTable and BlogTable so it can access event and blog data from the database. The index() method then calls findPopularEvents(3) to retrieve the three events with the highest booking count, findLatestEvents(2) to retrieve the two most recently added events, and findLatest(1) to retrieve the newest blog post. These results are returned in the variables array in HomeController and passed to home.html.php, injecting the homepage layout with recent events, popular events, and a blog update without hard-coded content.
 
Figure 25 Home page
6          Use of Required Technologies
The application integrates the required client-side and server-side technologies in a single full-stack workflow. HTML and CSS build the page structure and visual layout, JavaScript captures user interaction, AJAX sends requests to PHP without a full refresh, PHP processes the request and communicates with MySQL, and JSON is used to return structured data back to the browser.
Technology	How it was used in the project
HTML	Used to structure public pages, admin forms, navigation, event cards, tables, and content areas. For example, the create and edit event forms use labelled inputs for title, event type, category, date, location, image upload, and description.
CSS	Used to style the public website and admin area, including layouts, navigation, event cards, forms, buttons, filter sidebars, tables, typography, colours, and responsive page sections.
JavaScript	Used for front-end interactivity, including account form switching, capturing search/filter input, AJAX form feedback, dynamic DOM updates, date range handling, and user-friendly messages.
AJAX	Used to send asynchronous requests without full page reloads. For example, the events search/filter system sends selected filters to /events/search and updates the event list dynamically.
JSON	Used as the response format for AJAX requests. PHP returns structured success/error responses and filtered event data, which JavaScript reads before updating the page.
PHP	Used for server-side processing, routing, controllers, sessions, form handling, validation, CRUD operations, database access, email processing, and returning JSON responses.
MySQL	Used to store persistent data for events, users, bookings, blog posts, and subscribers. It supports public event listings, admin CRUD operations, searching/filtering, bookings, and SQL import/export for setup.
Docker	Used to create a consistent PHP-Apache and MySQL development environment that can be recreated on another machine.
PHPMailer	Used with Google SMTP to send booking confirmations, reminders, subscriber alerts, and contact form emails.
Cron	Used to run the reminder script automatically at scheduled intervals, checking for events happening within the next 24 hours.
Font Awesome	Used for interface icons, such as navigation, admin actions, buttons, and visual indicators.
7          Security and Maintainability
Security and maintainability were considered throughout the project to ensure the application was not only functional, but also suitable for future development. The system uses authentication, validation, prepared statements, escaped output, and a structured MVC-style organisation to keep the code safer and easier to manage.
Security Measure	Implementation
Authentication and sessions	Users and administrators log in through the account system. PHP sessions are used to identify authenticated users and protect restricted areas
Password hashing	User passwords are stored as hashed values rather than plain text. The seeded administrator account also uses a hashed password.
Prepared statements	Database operations are handled through table classes and prepared statements.
Output escaping	Dynamic content is escaped using htmlspecialchars() before being displayed in templates.
Form validation	Forms use required fields and server-side validation to reduce invalid submissions and also provide feedback when input is missing or incorrect.
File upload restrictions	Event image uploads are restricted to accepted image formats such as JPG, PNG, and WEBP.
Access Control	Admin actions are only available through the protected admin interface.
      
Maintainability	Implementation
MVC structure	Controllers, models, table classes, and views are separated. This keeps request handling, data representation, database access, and presentation logic in different parts of the project.
Reusable database helper	Common database operations such as finding, saving, inserting, and deleting records are centralised in a reusable helper class, reducing repeated SQL logic.
Table classes	Database-specific logic is placed in classes such as EventTable, UserTable, BookingTable, BlogTable, and SubscriberTable, rather than being written directly inside templates.
Reusable mailer class	Email configuration and layout logic are centralised in a shared PHPMailer-based class, which is reused for booking confirmations, reminders, subscriber alerts, and contact emails.
Docker environment	Docker provides a consistent PHP-Apache and MySQL environment, making the project easier to run and test on another machine.
Clear file organisation	PHP templates, models, controllers, configuration files, JavaScript, CSS, assets, and scripts are organised into separate areas of the project.
Comments and naming	Files, classes, and methods use descriptive names, with comments included for non-obvious logic such as filtering, bookings, and email reminder handling.
7.1  Reusable Code
Reusable code was used throughout the project to reduce repetition and keep the application easier to maintain proven by the layout.html.php file which provides the shared page structure, including the persistent navigation bar, footer, linked stylesheets, and script loading, so individual page templates only need to focus on their own content. Also the Database.php file centralizes the PDO database connection and the DatabaseHelper.php class provides reusable CRUD operations which are then reused by table classes. Other reusable parts include the routing/application classes for request handling and the shared PHPMailer email service for all email types. This structure enforces the DRY principle and makes future changes easier because shared behavior can be updated in one central location.
8     Important Code Fragments and Challenges
This section combines important code fragments with the main challenges and design decisions made during development. The selected examples were chosen because they support the application architecture, AJAX filtering, admin event management, email automation, and maintainability.
8.1	Application Request Handling
One of the most important design decisions was to use a front-controller routing structure instead of linking directly to individual PHP files. The request starts in .htaccess, which sends non-file requests to index.php. From there, Application.php coordinates the request by reading the URL, asking Router.php which controller should handle it, calling the correct controller method and finally loading the matching view template.
 
Figure 26 Application.php run function
This decision was meaningful because it allowed the application to use clean URLs such as /events, /admin/create, and /account, while keeping request handling centralized, therefore the main challenge was making sure the routing system worked consistently for all pages, form submission and invalid routes.
8.2	Event Filtering Query
The filterEvents() method in EventTable powers the AJAX search and filter system, it builds a query dynamically depending on the filters selected by the user by starting with a base query and then conditionally adding SQL clauses when filters are present.
A key challenge was making the JavaScript react correctly to different types of input. The search box needed to update after typing, while the checkbox filters, date fields, and sort dropdown needed to update immediately when changed. To solve this, the JavaScript listens for input events on the search box and change events on the filter form. It then collects all selected values using FormData, converts them into a query string, and sends them to the /events/search route using fetch().
 
Figure 27 events.js buildQueryString function
The more complex part was supporting checkbox filters because the number of selected values can change. A user might select no categories, one category, or several categories at the same time. On the JavaScript side, this meant the request had to send multiple values using names such as event_type[], category[], and location[]. On the PHP side, filterEvents() had to loop through those arrays and generate named placeholders dynamically, such as event_type_0, event_type_1, and so on. These placeholders are then bound through prepared statements.
 
Figure 28 EventTable.php query logic
This approach allowed the same filtering system to handle keyword search, multiple checkboxes, date range filtering, and sorting without writing separate queries for every possible combination. It also kept the query flexible while avoiding unsafe direct insertion of user input into SQL.
8.3	Reusable Email Service
The EmailService class is one of the most important maintainability decisions in the project. Instead of configuring PHPMailer separately for each email feature, the application uses one reusable class to handle SMTP authentication, sender details, recipients, subjects, and HTML email layouts.
 
Figure 29 EmailService.php code snippet
This shared service is reused for booking confirmations, 24-hour reminders, subscriber alerts, and contact form emails. The challenge was that each email type needed different content, but the sending process and layout were mostly the same. Centralizing this logic avoided duplication and made the email system easier to update.
9     Testing
Testing was carried out throughout development to check that the application met the assignment requirements and that both public and admin features worked correctly. The testing approach combined manual browser testing with whitebox PHPUnit tests for selected database functions. The main focus was to verify event management, authentication, search/filtering, AJAX responses, bookings, email-related logic,

Test Area	Test Performed	Expected Result	Result
User registration	Submitted the registration form with valid input	New user account is created and stored	Passed
User login	Logged in with valid and invalid credentials	Valid users can log in; invalid credentials show error	Passed
Admin access control	Tried accessing the admin page as a normal user	Admin pages are restricted	Passed
Create event	Submitted the create event form with valid event details	Event is saved	Passed
Edit event	Updated an existing event	Updated data is saved	Passed
Delete event	Deleted an event	Event is removed	Passed
Required fields	Submitted forms with missing values	Form display validation feedback and prevents invalid submission	Passed
Event image upload	Uploaded valid and invalid image formats	Only selected formats are accepted	Passed
Event listing	Opened the events page with dummy events in the database	Event cards display relevant fields	Passed
Keyword search	Searched for events using different words	Only matching events are displayed	Passed
Filters	Used all filters	Only matching events are displayed	Passed
Date range filter	Selected start/end dates	Events within the selected date range are displayed	Passed
Sort filter	Used all sorting options	Event are returned in correct oder	Passed
Single event page	Opened a single event page	Correct event detrails are loaded	Passed
Booking event	Booked an upcoming event	Booking is saved and feedback is shown	Passed
Duplicate booking	Tried booking the same event	System prevents duplicate booking	Passed
Past event booking	Tried booking a past event	Booking is blocked	Passed
Booking page	Viewed booking page	Bookings are rendered correctly and cancellable	Passed
Email confirmation	Checked email received	Confirmation is sent on user email	Passed
Reminder script	Ran the script manually and through cron	Reminders are sent if < 24 hours	Passed
Contact form	Submitted an enquiry	Message is sent to administrator	Passed
Browser check	Tested pages across Chrome, Firefox, Edge	Pages display and work as expected	Passed
Responsive Layout	Tested pages with smaller screens using Dev Tools	Layout usable on smaller screens	Passed
9.1       Testing Evidence
 
Figure 30 User registration test
 
Figure 31 Log in test
 
Figure 32 Restricted access test
 
Figure 33 Event creation test
 
Figure 34 Event edit test
 
Figure 35 Event delete test
 
Figure 36 Required fields test
 
Figure 37 Image format test
 
Figure 38 Search test
 
Figure 39 Filter test
 
Figure 40 Date range filter test
 
Figure 41 Booking test
 
Figure 42 Booking restrictions test
 
Figure 43 Different browser test
 
Figure 44 Responsive test
9.2       PHPUnit
For PHPUnit, I used whitebox/integration tests to check the main database table classes directly: EventTable, BlogTable, UserTable, and BookingTable. The tests used controlled test records, then called methods such as save(), findById(), delete(), filtering/search methods, user lookup, and booking checks to confirm that the database logic returned the expected results, helping verify important backend behavior.
 
Figure 45 PHPUnit test output
10        Setup and Deployment Instructions
The project uses Docker containers for PHP/Apache, MySQL, and phpMyAdmin.
To start the application, follow the process:
Install Docker and run the Docker Engine
Clone GitHub repository (title page) open a terminal window in the root folder and run:
docker compose up -d –build
After the containers started, the web application can be accessed at http://localhost:8080, and phpMyAdmin can be accessed at http://localhost:8081. The MySQL container may take around one minute to initialise, so if a temporary database connection error appears, the page should be refreshed after waiting briefly.
During the first database setup, the SQL seed script located at db/init/002_seed.sql creates the required database tables and inserts a default administrator account automatically. This allows the admin dashboard to be accessed immediately after deployment. The default admin credentials are:
Email: admin@csym019.test
Password: Admin123!
The application connects to the MySQL container using the following PDO credentials:
$host = 'db';
$db = 'csym019_db';
$user = 'csym019_user';
$pass = 'csym019_pass';
Composer dependencies are installed automatically inside the PHP container if the vendor folder is missing. The main dependencies are PHPMailer, used for SMTP email functionality, and PHPUnit, used for whitebox/integration testing.
PHPUnit tests are located in src/tests and can be run with:
docker compose exec web vendor/bin/phpunit
A successful test run should show output similar to OK (20 tests, 48 assertions). The tests cover selected database/model logic, including event filtering, event persistence, booking checks, user functions, and blog post operations.
To stop the application, run:
docker compose down
To reset the database and remove existing database data, run:
docker compose down -v
Email functionality is configured through src/config/mail.php and uses PHPMailer. The reminder script is designed to run through cron at one-minute intervals for testing purposes and checks for bookings with events starting within the next 24 hours. If cron does not run automatically, reminder emails can be triggered manually with:
docker compose exec web php scripts/send-reminders.php
The main project folders are organised as follows:
src/controllers for controller classes;
src/models for model and table classes;
src/pages for PHP templates;
src/framework for routing and application helpers;
src/javascript for JavaScript/AJAX files;
src/styles for CSS files;
src/tests for PHPUnit tests;
db/init for database schema and seed scripts;
src/scripts for the cron job script;
src/config for the mail configuration credentials.
11   Conclusion
The project successfully produced a full-stack event management system that meets the main assignment requirements, including admin event management, public event listings, AJAX search and filtering, secure database interaction, and testing. The MVC-style structure, reusable table classes, Docker setup helped keep the application organized and maintainable. The project also included extra features such as bookings, blog posts, email notifications, reminders, and subscriber alerts.
