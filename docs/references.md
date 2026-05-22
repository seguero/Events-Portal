# Font Awesome Icons Library

Font Awesome is loaded through a CDN and is used for navigation, buttons, and user interface icons.

Source:
https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css

Official website:
https://fontawesome.com/

Author:
Fonticons, Inc.

# Background Image

https://patternpictures.com/kristal-subtle-glass-white-background-pattern/

# Default Event Images

Web Development:
https://www.kindpng.com/downpng/wTbmiT_website-development-auckland-web-development-png-images-hd/

Docker:
https://freebiesupply.com/logos/docker-logo/

Web Security:
https://www.flaticon.com/free-icon/web-security_8021319

# Output Escaping and XSS Protection

Dynamic PHP output is escaped using htmlspecialchars() before being displayed in the browser. This helps reduce Cross-Site Scripting risk by converting special characters into HTML entities.

PHP documentation:
https://www.php.net/manual/en/function.htmlspecialchars.php

OWASP XSS reference:
https://owasp.org/www-community/attacks/xss/

# Apache mod_rewrite and Front Controller Routing

Clean URLs are handled using Apache's mod_rewrite module in the .htaccess file. Requests that do not match an existing file or directory are redirected to index.php, allowing the PHP router and application layer to handle routing through a Front Controller pattern.

Apache .htaccess documentation:
https://httpd.apache.org/docs/2.4/howto/htaccess.html

Apache mod_rewrite documentation:
https://httpd.apache.org/docs/2.4/mod/mod_rewrite.html

# Cron Reminder Script

Cron is used as an operating-system scheduler to execute the event reminder PHP script at scheduled intervals. The script checks for bookings linked to events occurring soon and sends reminder emails where required.

POSIX crontab reference:
https://pubs.opengroup.org/onlinepubs/9699919799/utilities/crontab.html

# PHPMailer

PHPMailer is installed through Composer and used to send application emails, including booking confirmations, subscriber notifications, contact form messages, and event reminders.

PHPMailer source:
https://github.com/PHPMailer/PHPMailer

PHPMailer documentation:
https://github.com/PHPMailer/PHPMailer/wiki

# Google SMTP

Google SMTP can be used as the mail server for PHPMailer when valid SMTP credentials are configured in the application email configuration file. This allows the application to send emails through a Gmail or Google Workspace account.

Google SMTP documentation:
https://knowledge.workspace.google.com/admin/gmail/send-email-from-a-printer-scanner-or-app
