<!--
Font Awesome Icons Library (CDN)
Source: https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css
Author: Fonticons, Inc.
Used for navbar and UI icons
-->
<!--
To mitigate Cross-Site Scripting (XSS) vulnerabilities, all dynamic output is escaped using PHP’s htmlspecialchars() function, which converts special characters into HTML entities, preventing browser execution of injected scripts
https://www.php.net/manual/en/function.htmlspecialchars.php
https://owasp.org/www-community/attacks/xss/
-->
<!--
Mod Rewrite
Clean URLs were implemented using Apache’s mod_rewrite module via a .htaccess configuration file, redirecting all non-existent file and directory requests to a single entry point (index.php), following the Front Controller design pattern
https://httpd.apache.org/docs/2.4/howto/htaccess.html
https://httpd.apache.org/docs/2.4/mod/mod_rewrite.html
-->
<!--
CRONTAB
A cron job was implemented to automate reminder emails by executing a PHP script at scheduled intervals.
https://pubs.opengroup.org/onlinepubs/9699919799/utilities/crontab.html
-->
