<?php
namespace controllers;

use framework\Database;
use PDO;

/*
 * AccountController
 * Handles account-related pages and actions:
 * - Display account page (login/register UI)
 * - Register a new user
 * - Log in an existing user (session-based)
 * - Log out a user (destroy session)
 */
class AccountController
{
    /*
     * GET /account
     * Renders the Account page (contains both login + register forms).
     */
    public function index(): array
    {
        return [
            'title' => 'Account',
            'template' => 'account.html.php',
            'styles' => ['account.css'],
            'variables' => []
        ];
    }

    /*
     * POST /account/registerSubmit
     * Validates register form input, checks for existing email, hashes password,
     * inserts the user into the database, then redirects to /home on success.
     */
    public function registerSubmit(): array
    {
        // Sanitize / normalize user input
        $firstname = trim($_POST['firstname'] ?? '');
        $lastname  = trim($_POST['lastname'] ?? '');
        $email     = trim($_POST['email'] ?? '');
        $password  = $_POST['password'] ?? '';

        // Basic validation (required fields)
        if ($firstname === '' || $lastname === '' || $email === '' || $password === '') {
            return $this->registerError('All fields are required.', $firstname, $lastname, $email);
        }

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->registerError('Please enter a valid email address.', $firstname, $lastname, $email);
        }

        // Enforce minimum password length
        if (strlen($password) < 6) {
            return $this->registerError('Password must be at least 6 characters.', $firstname, $lastname, $email);
        }

        // Connect to database using PDO connection helper
        $pdo = Database::getConnection();

        // Check for duplicate email (prevent multiple accounts with same email)
        $stmt = $pdo->prepare('SELECT userid FROM users WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);

        if ($stmt->fetch()) {
            return $this->registerError('That email is already registered.', $firstname, $lastname, $email);
        }

        // Hash password before storing
        $hash = password_hash($password, PASSWORD_DEFAULT);

        // Insert new user record
        $insert = $pdo->prepare(
            'INSERT INTO users (firstname, lastname, email, password)
             VALUES (:firstname, :lastname, :email, :password)'
        );

        $insert->execute([
            'firstname' => $firstname,
            'lastname'  => $lastname,
            'email'     => $email,
            'password'  => $hash
        ]);

        // After register: go home
        return ['redirect' => '/home'];
    }

    /*
     * POST /account/loginSubmit
     * Validates login input, retrieves user by email, verifies password,
     * creates a session and stores user details, then redirects to /home.
     */
    public function loginSubmit(): array
    {
        // Sanitize / normalize user input
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        // Basic validation (required fields)
        if ($email === '' || $password === '') {
            return $this->loginError('Email and password are required.', $email);
        }

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->loginError('Please enter a valid email address.', $email);
        }

        $pdo = Database::getConnection();

        // Fetch user by email (password hash included for verification)
        $stmt = $pdo->prepare(
            'SELECT userid, firstname, lastname, email, password
             FROM users
             WHERE email = :email
             LIMIT 1'
        );
        $stmt->execute(['email' => $email]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify user exists + password matches hash
        if (!$user || !password_verify($password, $user['password'])) {
            return $this->loginError('Invalid email or password.', $email);
        }

        // Start session (only if not already active)
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        // Store session flags + user details for UI + authorisation checks
        $_SESSION['loggedIn'] = true;
        $_SESSION['user'] = [
            'userid' => $user['userid'],
            'firstname' => $user['firstname'],
            'lastname' => $user['lastname'],
            'email' => $user['email']
        ];

        // On successful login, redirect user to homepage
        return ['redirect' => '/home'];
    }

    /*
     * GET /account/logout
     * Clears all session data and destroys the session, then redirects to /home.
     */
    public function logout(): array
    {
        // Start session (only if not already active)
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        // Remove session variables and destroy the session entirely
        session_unset();
        session_destroy();

        return ['redirect' => '/home'];
    }

    /**
     * Convenience redirect endpoint
     */
    public function success(): array
    {
        return ['redirect' => '/home'];
    }

    /*
     * Helper method: returns the Account page with register error + old values.
     * Keeps the user input so they don't have to retype everything.
     */
    private function registerError(string $msg, string $firstname, string $lastname, string $email): array
    {
        return [
            'title' => 'Account',
            'template' => 'account.html.php',
            'styles' => ['account.css'],
            'variables' => [
                'error' => $msg,
                'old' => [
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'email' => $email
                ]
            ]
        ];
    }

    /*
     * Helper method: returns the Account page with login error + old email value.
     */
    private function loginError(string $msg, string $email): array
    {
        return [
            'title' => 'Account',
            'template' => 'account.html.php',
            'styles' => ['account.css'],
            'variables' => [
                'login_error' => $msg,
                'login_old' => [
                    'email' => $email
                ]
            ]
        ];
    }
}