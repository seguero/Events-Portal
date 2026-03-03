Database
During initial database creation, a seed SQL script(002_seed.sql) located in the /db/init directory automatically creates the required tables and inserts a default administrator account. This allows immediate system access after deployment and ensures consistent testing conditions. The password is securely stored using PHP's password_hash() function before being inserted into the database.

Admin Credentials
user - admin@csym019.test
pass - Admin123!

PDO Credentials
$host = 'db';  
$db = 'csym019_db';  
$user = 'csym019_user';
$pass = 'csym019_pass';

web - localhost:8080
phpmyadmin - localhost:8081

Docker
-run server with docker compose up -d --build
-reset database data with docker compose down -v
-give it a minute for database to initialize otherwise encountering 'Connection Refused' error
