<?php
// Set default timezone for email reminder functionality
date_default_timezone_set('Europe/London');

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../autoload.php';

use models\BookingTable;
use framework\EmailService;

echo "Reminder script started\n"; 

/*
 * Reminder sender script using Cron
 *
 * Finds all bookings for events starting within the next 24 hours
 * and sends reminder emails if they have not already been sent.
 *
 * This file is designed to be executed by the server's cron scheduler,
 * in this case once per minute for testing purposes, 
 * to send reminder emails for events happening within the next 24 hours.
 *
 * Cron is an operating-system scheduling tool, not a PHP library.
 * Reference: https://man7.org/linux/man-pages/man5/crontab.5.html

 */

$bookingTable = new BookingTable();
$mailer = new EmailService();

$bookings = $bookingTable->findBookingsNeedingReminder();

echo 'Bookings found: ' . count($bookings) . "\n";

foreach ($bookings as $booking) {
    echo "Processing booking ID {$booking->bookingid} for {$booking->email}\n";
    $fullName = trim(($booking->firstname ?? '') . ' ' . ($booking->lastname ?? ''));

    $emailSent = $mailer->sendEventReminder(
        $booking->email,
        $fullName !== '' ? $fullName : 'User',
        $booking
    );

    if ($emailSent) {
        $bookingTable->markReminderSent((int)$booking->bookingid);
        echo "Reminder sent for booking ID {$booking->bookingid}\n";
    } else {
        echo "Reminder failed for booking ID {$booking->bookingid}\n";
    }
}

echo "Reminder script finished\n";