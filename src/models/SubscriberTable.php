<?php
namespace models;

use framework\Database;
use framework\DatabaseHelper;
use PDO;

/*
 * SubscriberTable
 *
 * Data-access layer for newsletter subscribers.
 */
class SubscriberTable
{
    /* Database helper configured for the subscribers table */
    private DatabaseHelper $table;

    /* Initialise helper with connection, table name and model mapping */
    public function __construct()
    {
        $this->table = new DatabaseHelper(
            Database::getConnection(),
            'subscribers',
            'subscriberid',
            SubscriberModel::class
        );
    }

    /* Find subscriber by email */
    public function findByEmail(string $email): object|false
    {
        return $this->table->find('email', $email);
    }

    /* Retrieve all active subscribers */
    public function findActive(): array
    {
        $pdo = Database::getConnection();

        $stmt = $pdo->prepare(
            'SELECT * FROM subscribers
             WHERE is_active = 1
             ORDER BY subscribed_at DESC'
        );

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, SubscriberModel::class);
    }

    /* Create a new subscriber */
    public function subscribe(string $email): string
    {
        return $this->table->insert([
            'email' => $email,
            'is_active' => 1
        ]);
    }

    /* Reactivate an existing subscriber */
    public function reactivate(int $subscriberid): void
    {
        $this->table->save([
            'subscriberid' => $subscriberid,
            'is_active' => 1
        ]);
    }
}