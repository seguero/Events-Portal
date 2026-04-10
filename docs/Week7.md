--WEEK 7--

8th Coding Session
This session focused on implementing AJAX functionality across the application and improving user experience through dynamic content updates and enhanced feedback mechanisms. The work builds upon the existing MVC structure by integrating asynchronous interactions and refining access control and error handling.

-implemented AJAX-based search and filtering on the public events page, allowing users to dynamically update event listings without reloading the page
-created a unified filtering system combining search input, categories, locations, event types, date filters and sorting into a single request handled by EventController and EventTable
-developed dynamic DOM updates for event cards using JavaScript, improving responsiveness and usability
-implemented AJAX search functionality in the admin panel to update the events table in real time
-added AJAX form handling for login and registration, displaying inline success and error messages without page reloads
-implemented AJAX profile updates with real-time feedback and validation
-extended AJAX functionality to admin event management, enabling asynchronous creation and editing of events
-integrated AJAX booking functionality on the single event page, allowing users to book events without reloading and providing instant confirmation or error messages
-added reusable message components across forms to display success and error states consistently
-implemented debounce technique in JavaScript to optimise search performance and reduce unnecessary requests
-improved user experience by disabling buttons and showing loading states during AJAX requests
-introduced flash messaging using session variables to provide friendly feedback when redirecting users due to unauthorized access or invalid actions
-enhanced access control by displaying informative messages when users attempt to access restricted pages such as admin or profile sections
-implemented a custom 404 error handling system with a dedicated error controller and template, replacing default plain text responses
-refactored routing logic to handle invalid controllers and actions by redirecting to the 404 page
-improved overall error handling across the application
-refined UI styling for event pages and forms to maintain visual consistency and improve clarity of user interactions

MINOR BLOCK

Encountered an issue with admin event search after introducing AJAX filtering on the public events page:

Error:
Admin search returned a “Server could not be reached” message despite a 200 status response.

Root cause:
The admin search logic in AdminController was calling a search() method in EventTable that had been replaced/modified to support filtering for the public events page. This resulted in an invalid or unexpected response format, breaking JSON parsing in the frontend.

Resolution:
Introduced a separate adminSearch() method in EventTable dedicated to simple keyword-based searching for the admin panel, and updated AdminController::search() to use this method instead of the public filtering logic.

Impact:
Minor refactor to separate admin and public search logic; restored correct AJAX functionality for admin search while maintaining clean separation of concerns and preserving the more advanced filtering system for the public events page.

    //Plan for next coding session
    -finish the views of other pages (blog, about, contact)
    -implement date range picker filtering
    -email reminder notifications for booked events
    -once functionality is fully achieved, commence front-end design
    -improve responsiveness across all pages
