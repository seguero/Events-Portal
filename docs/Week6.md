--WEEK 6--

7th Coding Session
This session focused on implementing the event booking system and enhancing user interaction with events through dedicated event pages and booking management features. The work extended the MVC architecture by introducing booking functionality and improving the overall user experience.

-added a dedicated single event view page to display detailed information for a selected event using dynamic routing with event IDs
-extended the Application routing system to support URL parameters, allowing controller methods to receive dynamic values
-implemented the show() method in EventController to retrieve and display individual events from the database
-integrated booking functionality into the event page, allowing logged-in users to book events
-created a bookings table linking users and events using foreign keys (userid, eventid)
-implemented BookingTable and BookingController to manage booking-related operations
-implemented safeguards including event validation, prevention of booking past events, and duplicate booking checks
-added conditional logic on the event page to handle different booking states (already booked, event ended, available)
-created a bookings page where users can view their bookings
-designed a two-column layout for the bookings page for better organisation
-added booking cancellation functionality allowing users to remove bookings
-improved UX with a dedicated bookings.css

1st MINOR BLOCK

Encountered a routing limitation while implementing the single event (detail) page functionality:

Error:
404 - Action not found when accessing URLs such as /event/show/1

Root cause:
The front controller (Application) only parsed routes into two segments (controller/action), causing the action to be interpreted as show/5 instead of separating the method and parameter.

Resolution:
Refactored the routing logic to split the URL into controller, action, and parameters using explode() and passed parameters dynamically to controller methods.

Impact:
Minor framework adjustment required; enabled dynamic routing with parameters, allowing implementation of event-specific pages and improving overall routing flexibility for future features.

2nd MINOR BLOCK

Encountered a limitation in the reusable database helper while implementing booking validation:

Error:
Call to undefined method DatabaseHelper::find() when checking if a user had already booked an event.

Root cause:
The DatabaseHelper class did not support queries with multiple conditions (e.g. userid AND eventid), while the booking logic required checking both criterias.

Resolution:
Implemented a custom query inside BookingTable::exists() using a prepared statement with COUNT(\*) to check for existing bookings based on both userid and eventid.

Impact:
Minor adjustment to the data access layer; booking validation now works correctly without modifying the core reusable helper, preserving simplicity.

    //Plan for next coding session
    -use AJAX to display success and error messages without reloading the page for login, register, profile update, booking and admin actions
    -connect public event search and filters to AJAX and JSON responses
    -handle unauthorized page access with friendlier feedback messages
    -finish the views of other pages (blog, about, contact)
    -once functionality is fully achieved, commence front-end design
    -improve responsiveness across all pages
