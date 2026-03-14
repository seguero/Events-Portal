<?php
namespace controllers;

use models\UserTable;

/*
 * AccountController
 *
 * Handles account-related pages and authentication actions.
 * The controller validates form input, delegates database access
 * to UserTable, and returns view/redirect instructions.
 */
class AccountController
{
    /* Data-access model for the users table */
    private UserTable $users;

    /* Initialise the user table model */
    public function __construct()
    {
        $this->users = new UserTable();
    }

    /* Render the account page containing login and register forms
       Redirect to profile if user is already logged in   
    */
   public function index(): array
    {
        if (!empty($_SESSION['loggedIn'])) {
            return ['redirect' => '/account/profile'];
        }

        return [
            'title' => 'Account',
            'template' => 'account.html.php',
            'styles' => ['account.css'],
            'scripts' => ['account.js'],
            'variables' => []
        ];
    }

    /* Render the profile page containing update details form
       Redirect to account if user is not logged in   
    */
    public function profile(): array
    {
    if (empty($_SESSION['loggedIn'])) {
        return ['redirect' => '/account'];
    }

    return [
        'title' => 'Profile',
        'template' => 'profile.html.php',
        'styles' => ['profile.css'],
        'variables' => [
            'user' => $_SESSION['user']
        ]
    ];
    }

    /* Update user information */
    public function update(): array
    {
        $firstname   = trim($_POST['firstname'] ?? '');
        $lastname    = trim($_POST['lastname'] ?? '');
        $email       = trim($_POST['email'] ?? '');
        $oldpassword = $_POST['oldpassword'] ?? '';
        $newpassword = $_POST['newpassword'] ?? '';

        $user = $this->users->findById($_SESSION['user']['userid']);

        if (!$user) {
            return ['redirect' => '/account'];
        }

        if ($newpassword !== '') {
            if (!password_verify($oldpassword, $user->password)) {
                return [
                    'title' => 'Profile',
                    'template' => 'profile.html.php',
                    'styles' => ['profile.css'],
                    'variables' => [
                        'user' => $_SESSION['user'],
                        'error' => 'Current password is incorrect'
                    ]
                ];
            }
        }

        $data = [
            'userid' => $user->userid,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email
        ];

        if ($newpassword !== '') {
            $data['password'] = password_hash($newpassword, PASSWORD_DEFAULT);
        }

        $this->users->save($data);

        $_SESSION['user']['firstname'] = $firstname;
        $_SESSION['user']['lastname'] = $lastname;
        $_SESSION['user']['email'] = $email;

        return ['redirect' => '/account/profile'];
    }

    /* Handle registration, validate input, and create a new user */
    public function registerSubmit(): array
    {
        $firstname = trim($_POST['firstname'] ?? '');
        $lastname  = trim($_POST['lastname'] ?? '');
        $email     = trim($_POST['email'] ?? '');
        $password  = $_POST['password'] ?? '';

        if ($firstname === '' || $lastname === '' || $email === '' || $password === '') {
            return $this->registerError('All fields are required.', $firstname, $lastname, $email);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->registerError('Please enter a valid email address.', $firstname, $lastname, $email);
        }

        if (strlen($password) < 6) {
            return $this->registerError('Password must be at least 6 characters.', $firstname, $lastname, $email);
        }

        $existingUser = $this->users->findByEmail($email);

        if ($existingUser) {
            return $this->registerError('That email is already registered.', $firstname, $lastname, $email);
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $this->users->register([
            'firstname' => $firstname,
            'lastname'  => $lastname,
            'email'     => $email,
            'password'  => $hash
        ]);

        return ['redirect' => '/home'];
    }

    /* Handle login, verify credentials, and store user details in session */
    public function loginSubmit(): array
    {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($email === '' || $password === '') {
            return $this->loginError('Email and password are required.', $email);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->loginError('Please enter a valid email address.', $email);
        }

        $user = $this->users->findByEmail($email);

        if (!$user || !password_verify($password, $user->password)) {
            return $this->loginError('Invalid email or password.', $email);
        }

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $_SESSION['loggedIn'] = true;
        $_SESSION['user'] = [
            'userid' => $user->userid,
            'firstname' => $user->firstname,
            'lastname' => $user->lastname,
            'email' => $user->email,
            'role' => $user->role
        ];

        return ['redirect' => '/home'];
    }

    /* Clear session data and log the user out */
    public function logout(): array
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        session_unset();
        session_destroy();

        return ['redirect' => '/home'];
    }

    /* Convenience redirect after successful account actions */
    public function success(): array
    {
        return ['redirect' => '/home'];
    }

    /* Return account page with registration error and previous form values */
    private function registerError(string $msg, string $firstname, string $lastname, string $email): array
    {
        return [
            'title' => 'Account',
            'template' => 'account.html.php',
            'styles' => ['account.css'],
            'scripts' => ['account.js'],
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

    /* Return account page with login error and previous email value */
    private function loginError(string $msg, string $email): array
    {
        return [
            'title' => 'Account',
            'template' => 'account.html.php',
            'styles' => ['account.css'],
            'scripts' => ['account.js'],
            'variables' => [
                'login_error' => $msg,
                'login_old' => [
                    'email' => $email
                ]
            ]
        ];
    }
}