<?php
namespace models;

/*
 * SubscriberModel
 *
 * Represents a newsletter subscriber.
 */
class SubscriberModel
{
    /* Primary key */
    public ?int $subscriberid = null;

    /* Subscriber email address */
    public string $email = '';

    /* Whether the subscription is active */
    public int $is_active = 1;

    /* Timestamp when the subscription was created */
    public ?string $subscribed_at = null;
}