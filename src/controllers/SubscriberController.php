<?php
namespace controllers;

use models\SubscriberTable;

/*
 * SubscriberController
 *
 * Handles newsletter subscription requests from the public footer form.
 * The controller validates submitted email addresses and communicates
 * with SubscriberTable to create or reactivate subscriptions.
 */
class SubscriberController
{
    /* Model used to interact with the subscribers database table */
    private SubscriberTable $subscribers;

    /* Initialise the SubscriberTable model when the controller is created */
    public function __construct()
    {
        $this->subscribers = new SubscriberTable();
    }

    /* Process newsletter subscription form submission */
    public function subscribe(): array
    {
        /* Retrieve and trim submitted email address */
        $email = trim($_POST['newsletter-email'] ?? '');

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        /* Redirect back with an error if no email was provided */
        if ($email === '') {
            $_SESSION['flash_message'] = 'Please enter your email address.';
            $_SESSION['flash_type'] = 'error';

            return ['redirect' => $_SERVER['HTTP_REFERER'] ?? '/home'];
        }

        /* Validate email address format */
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['flash_message'] = 'Please enter a valid email address.';
            $_SESSION['flash_type'] = 'error';

            return ['redirect' => $_SERVER['HTTP_REFERER'] ?? '/home'];
        }

        /* Check whether the email is already stored as a subscriber */
        $existingSubscriber = $this->subscribers->findByEmail($email);

        if ($existingSubscriber) {
            /* Reactivate previous subscription if it was inactive */
            if ((int) $existingSubscriber->is_active === 0) {
                $this->subscribers->reactivate((int) $existingSubscriber->subscriberid);

                $_SESSION['flash_message'] = 'Your subscription has been reactivated.';
                $_SESSION['flash_type'] = 'success';
            } else {
                $_SESSION['flash_message'] = 'You are already subscribed.';
                $_SESSION['flash_type'] = 'info';
            }

            return ['redirect' => $_SERVER['HTTP_REFERER'] ?? '/home'];
        }

        /* Save a new active subscriber */
        $this->subscribers->subscribe($email);

        /* Store success feedback for the redirected page */
        $_SESSION['flash_message'] = 'Thank you for subscribing to event updates.';
        $_SESSION['flash_type'] = 'success';

        /* Redirect back to the page where the form was submitted */
        return ['redirect' => $_SERVER['HTTP_REFERER'] ?? '/home'];
    }
}