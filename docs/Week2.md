--WEEK 2--

3rd Coding Session
This session successfully transitioned the project from static HTML pages to a structured, scalable MVC-based PHP application running inside a container environment.

-set up local development environment using Docker Compose (Apache PHP 8.2 + MySQL)
-created compose.yaml and custom Dockerfile to enable mod_rewrite and .htaccess support
-implemented rewrite rules to support clean URLs and a proper Front Controller pattern
-verified routing works for /, /home, and /home/index
-established structured MVC architecture inside src/
-created framework/ directory for core infrastructure logic
-implemented Application (Front Controller) and Router classes
-created custom autoload.php with namespace-based class loading
-separated framework, controllers, models, and views for clean architecture
-refactored home.html.php into a pure view and implemented layout templating with $content injection
-added dynamic page titles, variables passing, and controller-driven stylesheet loading ($styles)
-kept global/reusable CSS in layout and injected page-specific styles conditionally
-updated asset paths to absolute URLs to work with front controller routing
-implemented basic XSS prevention using htmlspecialchars() for safe output escaping
-tested complete request lifecycle:
Request -> Apache rewrite -> index.php -> Application -> Router -> Controller -> View -> Layout -> Response

    // Plan for next coding session
    -create and test database connection
    -implement user registration for booking event attendance
    -first admin user will be generated during initialization of docker container instead of being hard-coded in the PHP file and I'm planning to do the same with events, booking and other dummy data the database might need. So instead of having a pre-populated database, it will be created as soon as docker compose is called and can also be reset using -v flag. This will prevent version conflicts and ensures reproducibility on different machines, also eliminating the need of manual imports.
    -start with the layout on other pages (events, account, contact, blog, about)
