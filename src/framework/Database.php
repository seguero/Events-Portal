<?php
namespace framework;

use PDO;
use PDOException;

/*
 * Database
 *
 * Provides a centralized PDO connection using the Singleton pattern.
 * Responsibilities:
 * - Establish a single shared database connection
 * - Configure PDO error handling and fetch mode
 * - Prevent multiple unnecessary connections per request
 *
 * This class ensures consistent database access across controllers.
 */
class Database
{
    /*
     * Holds the single PDO instance (shared connection).
     */
    private static ?PDO $connection = null;

    /*
     * Returns a PDO connection instance.
     * If no connection exists yet, it creates one.
     * Subsequent calls reuse the same connection.
     * @return PDO
     */
    public static function getConnection(): PDO
    {
        // Create connection only once (lazy initialization)
        if (self::$connection === null) {

            // Database credentials (must match docker-compose configuration)
            $host = 'db';                // Docker service name
            $db   = 'csym019_db';        // Database name
            $user = 'csym019_user';      // Database username
            $pass = 'csym019_pass';      // Database password

            try {
                // Create PDO connection using MySQL driver
                self::$connection = new PDO(
                    "mysql:host=$host;dbname=$db;charset=utf8mb4",
                    $user,
                    $pass
                );

                // Throw exceptions on database errors (improves debugging + security)
                self::$connection->setAttribute(
                    PDO::ATTR_ERRMODE,
                    PDO::ERRMODE_EXCEPTION
                );

                // Set default fetch mode to associative array
                self::$connection->setAttribute(
                    PDO::ATTR_DEFAULT_FETCH_MODE,
                    PDO::FETCH_ASSOC
                );

            } catch (PDOException $e) {
                // Stop execution if connection fails
                die('Database connection failed: ' . $e->getMessage());
            }
        }

        // Return existing or newly created connection
        return self::$connection;
    }
}