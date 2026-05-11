<?php
namespace framework;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/*
 * EmailService
 *
 * Handles email sending with PHPMailer.
 * A shared layout is used so confirmation and reminder emails
 * have a consistent and professional appearance.
 */
class EmailService
{
    private PHPMailer $mail;
    private array $config;

    /*
     * Constructor
     * Loads SMTP settings from the mail config file.
     */
    public function __construct()
    {
        $this->config = require __DIR__ . '/../config/mail.php';

        $this->mail = new PHPMailer(true);
        $this->mail->isSMTP();
        $this->mail->Host = 'smtp.gmail.com';
        $this->mail->SMTPAuth = true;
        $this->mail->Username = $this->config['smtp_email'] ?? '';
        $this->mail->Password = $this->config['smtp_password'] ?? '';
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->Port = 587;

        $fromEmail = $this->config['smtp_from_email'] ?? $this->mail->Username;
        $fromName = $this->config['smtp_from_name'] ?? 'Event Portal';

        $this->mail->setFrom($fromEmail, $fromName);
    }

    /*
     * Shared email sender used by all email types.
     */
    private function sendEmail(
        string $toEmail,
        string $toName,
        string $subject,
        string $htmlBody,
        string $altBody,
        string $logPrefix
    ): bool {
        try {
            $this->mail->clearAddresses();
            $this->mail->clearAttachments();

            $this->mail->addAddress($toEmail, $toName);
            $this->mail->isHTML(true);
            $this->mail->Subject = $subject;
            $this->mail->Body = $htmlBody;
            $this->mail->AltBody = $altBody;

            return $this->mail->send();
        } catch (Exception $e) {
            error_log($logPrefix . $this->mail->ErrorInfo);
            return false;
        }
    }

    /*
     * Send booking confirmation email.
     */
    public function sendBookingConfirmation(string $toEmail, string $toName, object $event): bool
    {
        $subject = 'Booking Confirmation - ' . ($event->title ?? 'Event');

        $intro = '<p style="margin:0 0 16px;">Hello ' . $this->escape($toName) . ',</p>
                  <p style="margin:0 0 20px;">Your booking has been successfully confirmed. Here are your event details:</p>';

        $body = $this->buildEmailLayout(
            'Booking Confirmed',
            $intro . $this->buildEventDetails($event) .
            '<p style="margin:24px 0 0;">Thank you for booking with us. We look forward to seeing you there.</p>',
            '#198754'
        );

        $altBody =
            "Booking Confirmed\n\n" .
            "Hello {$toName},\n\n" .
            "Your booking has been successfully confirmed.\n" .
            "Title: " . ($event->title ?? '') . "\n" .
            "Type: " . ($event->event_type ?? '') . "\n" .
            "Category: " . ($event->category ?? '') . "\n" .
            "Date: " . $this->formatDate($event->event_date ?? '') . "\n" .
            "Location: " . ($event->location ?? '') . "\n\n" .
            "Thank you for booking with us.";

        return $this->sendEmail($toEmail, $toName, $subject, $body, $altBody, 'Email failed: ');
    }

    /*
     * Send 24-hour event reminder email.
     */
    public function sendEventReminder(string $toEmail, string $toName, object $event): bool
    {
        $subject = 'Reminder: ' . ($event->title ?? 'Your event') . ' starts in less than 24 hours';

        $intro = '<p style="margin:0 0 16px;">Hello ' . $this->escape($toName) . ',</p>
                  <p style="margin:0 0 20px;">This is a reminder that your booked event starts in less than 24 hours.</p>';

        $body = $this->buildEmailLayout(
            'Event Reminder',
            $intro . $this->buildEventDetails($event) .
            '<p style="margin:24px 0 0;">We look forward to seeing you there.</p>',
            '#fd7e14'
        );

        $altBody =
            "Event Reminder\n\n" .
            "Hello {$toName},\n\n" .
            "This is a reminder that your event starts in less than 24 hours.\n" .
            "Title: " . ($event->title ?? '') . "\n" .
            "Type: " . ($event->event_type ?? '') . "\n" .
            "Category: " . ($event->category ?? '') . "\n" .
            "Date: " . $this->formatDate($event->event_date ?? '') . "\n" .
            "Location: " . ($event->location ?? '') . "\n\n" .
            "We look forward to seeing you there.";

        return $this->sendEmail($toEmail, $toName, $subject, $body, $altBody, 'Reminder email failed: ');
    }

    /*
     * Send contact form message to the site administrator.
     */
    public function sendContactMessage(
        string $name,
        string $email,
        string $subject,
        string $message
    ): bool {
        $toEmail = $this->config['contact_recipient'] ?? $this->mail->Username;
        $toName = 'CSYM019 Event Portal';

        $emailSubject = 'Contact Form: ' . $subject;

        $content = '
            <p style="margin:0 0 16px;">A new contact form message has been submitted through the Event Portal.</p>

            <div style="background-color:#f8f9fa; border:1px solid #e9ecef; border-radius:10px; padding:20px;">
                ' . $this->buildDetailRow('Name', $name) . '
                ' . $this->buildDetailRow('Email', $email) . '
                ' . $this->buildDetailRow('Subject', $subject) . '
                ' . $this->buildDetailRow('Message', nl2br($this->escape($message)), false) . '
            </div>

            <p style="margin:24px 0 0;">You can reply directly to the sender using the email address above.</p>
        ';

        $body = $this->buildEmailLayout(
            'New Contact Message',
            $content,
            '#4f6dff'
        );

        $altBody =
            "New Contact Message\n\n" .
            "Name: {$name}\n" .
            "Email: {$email}\n" .
            "Subject: {$subject}\n\n" .
            "Message:\n{$message}";

        return $this->sendEmail(
            $toEmail,
            $toName,
            $emailSubject,
            $body,
            $altBody,
            'Contact email failed: '
        );
    }

    /*
    * Send new event notification email to a subscriber.
    */
    public function sendNewEventNotification(string $toEmail, object $event): bool
    {
        $subject = 'New Event Added - ' . ($event->title ?? 'Event');

        $intro = '<p style="margin:0 0 16px;">Hello,</p>
                <p style="margin:0 0 20px;">A new event has been added to the Event Portal.</p>';

        $body = $this->buildEmailLayout(
            'New Event Added',
            $intro . $this->buildEventDetails($event) .
            '<p style="margin:24px 0 0;">Visit the Event Portal to view more details and book your place.</p>',
            '#4f6dff'
        );

        $altBody =
            "New Event Added\n\n" .
            "A new event has been added to the Event Portal.\n" .
            "Title: " . ($event->title ?? '') . "\n" .
            "Type: " . ($event->event_type ?? '') . "\n" .
            "Category: " . ($event->category ?? '') . "\n" .
            "Date: " . $this->formatDate($event->event_date ?? '') . "\n" .
            "Location: " . ($event->location ?? '') . "\n\n" .
            "Visit the Event Portal to view more details.";

        return $this->sendEmail(
            $toEmail,
            'Subscriber',
            $subject,
            $body,
            $altBody,
            'New event notification failed: '
        );
    }

    /*
     * Build the shared email layout.
     */
    private function buildEmailLayout(string $heading, string $content, string $accentColor): string
    {
        return '
            <div style="margin:0; padding:24px; background-color:#f4f6f8; font-family:Arial, Helvetica, sans-serif; color:#1f2933;">
                <div style="max-width:640px; margin:0 auto; background-color:#ffffff; border-radius:12px; overflow:hidden; box-shadow:0 2px 10px rgba(0,0,0,0.08);">
                    <div style="background-color:' . $accentColor . '; padding:24px 32px; color:#ffffff;">
                        <h1 style="margin:0; font-size:24px; line-height:1.3;">' . $this->escape($heading) . '</h1>
                    </div>

                    <div style="padding:32px; font-size:15px; line-height:1.7;">
                        ' . $content . '
                    </div>

                    <div style="padding:18px 32px; background-color:#f8f9fa; border-top:1px solid #e9ecef; font-size:13px; color:#6c757d;">
                        This is an automated message from the Event Portal.
                    </div>
                </div>
            </div>
        ';
    }

    /*
     * Build the styled event details card.
     */
    private function buildEventDetails(object $event): string
    {
        return '
            <div style="background-color:#f8f9fa; border:1px solid #e9ecef; border-radius:10px; padding:20px;">
                ' . $this->buildDetailRow('Title', $event->title ?? '') . '
                ' . $this->buildDetailRow('Type', $event->event_type ?? '') . '
                ' . $this->buildDetailRow('Category', $event->category ?? '') . '
                ' . $this->buildDetailRow('Date', $this->formatDate($event->event_date ?? '')) . '
                ' . $this->buildDetailRow('Location', $event->location ?? '') . '
                ' . $this->buildDetailRow('Description', nl2br($this->escape($event->description ?? '')), false) . '
            </div>
        ';
    }

    /*
     * Build one labelled row inside the details card.
     */
    private function buildDetailRow(string $label, string $value, bool $escapeValue = true): string
    {
        $displayValue = $value !== '' ? ($escapeValue ? $this->escape($value) : $value) : 'N/A';

        return '
            <div style="padding:10px 0; border-bottom:1px solid #dee2e6;">
                <p style="margin:0 0 4px; font-size:13px; font-weight:bold; color:#495057;">' . $this->escape($label) . '</p>
                <p style="margin:0; color:#212529; line-height:1.6;">' . $displayValue . '</p>
            </div>
        ';
    }

    /*
     * Format event date for display.
     */
    private function formatDate(string $date): string
    {
        if ($date === '') {
            return '';
        }

        $timestamp = strtotime($date);
        return $timestamp ? date('d M Y, H:i', $timestamp) : $date;
    }

    /*
     * Escape values for safe HTML output.
     */
    private function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
}