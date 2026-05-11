<?php
namespace controllers;

use framework\EmailService;

/*
 * ContactController
 *
 * Handles the public contact page and contact form submissions.
 * The controller validates user input and uses EmailService
 * to send contact messages to the site administrator.
 */
class ContactController
{
    /* Service used to send contact form emails */
    private EmailService $emailService;

    /* Initialise the EmailService when the controller is created */
    public function __construct()
    {
        $this->emailService = new EmailService();
    }

    /* Render the Contact page */
    public function index(): array
    {
        return [
            'title' => 'Contact',
            'template' => 'contact.html.php',
            'styles' => ['contact.css'],
            'variables' => []
        ];
    }

    /* Process the contact form submission */
    public function send(): array
    {
        /* Retrieve and trim submitted form values */
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $subject = trim($_POST['subject'] ?? '');
        $message = trim($_POST['message'] ?? '');

        /* Validate that all fields have been completed */
        if ($name === '' || $email === '' || $subject === '' || $message === '') {
            return $this->contactError(
                'All fields are required.',
                $name,
                $email,
                $subject,
                $message
            );
        }

        /* Validate email address format */
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->contactError(
                'Please enter a valid email address.',
                $name,
                $email,
                $subject,
                $message
            );
        }

        /* Send the contact message using the shared email service */
        $sent = $this->emailService->sendContactMessage(
            $name,
            $email,
            $subject,
            $message
        );

        /* Return form with error message if the email could not be sent */
        if (!$sent) {
            return $this->contactError(
                'Your message could not be sent. Please try again later.',
                $name,
                $email,
                $subject,
                $message
            );
        }

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        /* Store success feedback for the redirected contact page */
        $_SESSION['flash_message'] = 'Your message has been sent successfully.';
        $_SESSION['flash_type'] = 'success';

        /* Redirect back to the contact page after successful submission */
        return ['redirect' => '/contact'];
    }

    /* Return the contact page with an error and previous form values */
    private function contactError(
        string $error,
        string $name,
        string $email,
        string $subject,
        string $message
    ): array {
        return [
            'title' => 'Contact',
            'template' => 'contact.html.php',
            'styles' => ['contact.css'],
            'variables' => [
                'error' => $error,
                'old' => [
                    'name' => $name,
                    'email' => $email,
                    'subject' => $subject,
                    'message' => $message
                ]
            ]
        ];
    }
}