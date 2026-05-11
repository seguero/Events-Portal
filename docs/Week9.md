--WEEK 9--

10th Coding Session
This session focused on completing the remaining advanced features, improving the content management side of the application, and polishing the user interface after the main functionality had been achieved. The work builds upon the existing MVC architecture by expanding admin capabilities, improving event presentation, adding new public-facing pages, and enhancing communication features through email subscriptions and contact functionality.

-implemented dynamic date range filtering on the public events page using separate start date and end date inputs
-updated the event filtering backend so EventController and EventTable can process custom date ranges instead of relying on static date options
-added validation to prevent invalid date ranges and improve the reliability of filtering results
-updated the events page JavaScript so the new date inputs are included automatically in AJAX filter requests
-added a clear date button to reset the dynamic date range filter and reload matching events
-improved the visual status of event cards by differentiating upcoming, starting soon, and closed events
-added colour-coded event card states for upcoming events, events within 24 hours, and past events
-fixed layout issues on the events page where horizontal event cards caused text to appear squashed
-updated event card CSS so images, badges, titles, descriptions, dates, locations, and read more buttons display correctly
-added event image upload functionality to the admin forms
-added server-side image validation for file type and file size
-enabled admins to replace an event image when editing an existing event
-updated public event cards to show uploaded event images instead of the placeholder image
-updated the single event page to display the uploaded event image at the top of the event details
-added a public blog page backed by a database table instead of hardcoded content
-created blog post models and table classes to manage blog related database operations
-added seeded blog posts based on the project development progress and version history
-separated the project progress notes into multiple versioned blog entries from v0.1 to v1.0
-added admin functionality for creating, editing, and deleting blog posts
-added flash messages for admin blog and event actions to provide clearer feedback after create, update, and delete operations
-updated the homepage blog section to display the latest blog post dynamically from the database
-added a public contact page with a simple enquiry form
-connected the contact form to the existing PHPMailer-based EmailService
-reused the shared HTML email layout functions for contact form emails to keep email design consistent
-added a newsletter subscription feature through the footer subscribe form
-created a subscribers database table to store subscribed email addresses
-added SubscriberModel and SubscriberTable classes to keep subscriber data access consistent with the rest of the MVC structure
-added SubscriberController to validate and process newsletter subscriptions
-extended EmailService with a new event notification email method
-reused existing email layout and event detail card functions for subscriber event notification emails
-updated admin event creation so active subscribers are automatically emailed when a new event is added
-polished the footer newsletter design so the subscribe form is displayed inside a dark card-style container
-added responsive styling to stack layouts cleanly on smaller screens
-polished responsiveness across all pages, forms, cards, tables, and footer elements
-improved overall maintainability by keeping new features within the existing MVC-style structure

MINOR BLOCKS

Encountered several issues while implementing the final advanced features and polishing the application:

Issue 1: Date filtering still used the old static date logic
Error: The event filter method still contained logic for today, this week, and this month even after adding date range inputs.
Root cause: The original filterEvents method expected a single date radio value instead of start_date and end_date values.
Resolution: Replaced the old date switch block with start_date and end_date SQL conditions using prepared parameters.
Impact: Users can now select any two dates and filter events dynamically between those dates.

Issue 2: Event card text became squashed after changing the card layout
Error: Event titles and details appeared squashed into a single column.
Root cause: The event card used a horizontal layout while the grid allowed cards to become too narrow. The image column consumed most of the available width.
Resolution: Increased the minimum card width, adjusted the image/text grid ratio, changed the card body to a flexible column layout, and added responsive stacking for smaller screens.
Impact: Event cards now display badges, titles, descriptions, locations, dates, and read more buttons clearly.

Issue 3: Event creation showed a server error despite successfully creating the event
Error: The AJAX form displayed “Server could not be reached” even though the event was saved.
Root cause: The event was saved first, but the code then attempted to use an undefined eventId variable when notifying subscribers. This caused a PHP error after insertion and broke the JSON response.
Resolution: Captured the return value from the save method as eventId before retrieving the new event and sending subscriber notifications.
Impact: Event creation now completes with a valid JSON response and subscriber notifications can be triggered correctly.

Issue 4: Subscriber records were created but notification emails did not arrive
Error: The subscribers table showed new records, but no new-event email was received.
Root cause: The subscription form worked, but the email notification logic depended on the event creation workflow correctly retrieving the newly saved event before sending emails.
Resolution: Ensured notification logic runs after saving the event and before returning JSON or redirect responses.
Impact: Subscriber notification emails can now be attempted correctly when new events are created.

    //Plan for next coding session
    -perform full end-to-end testing of all existing functionality
    -test all AJAX paths for create, edit, booking, filtering, and form validation
    -verify email delivery for booking confirmations, reminders, contact messages, and new-event subscriber notifications
    -test responsiveness across desktop, tablet, and mobile screen sizes using browser developer tools
    -review database seed files and confirm all required tables and sample data are recreated correctly
    -prepare screenshots and testing evidence for the technical report
    -write the final report sections
    -prepare the final video demonstration
    -finalise the ZIP submission, source code document, README instructions, and GitHub repository contents
