<?php
namespace models;

use framework\Database;
use framework\DatabaseHelper;

/*
 * UserTable
 *
 * Data-access layer for the users table.
 * Provides methods for retrieving and modifying user records
 * while delegating SQL execution to the reusable DatabaseHelper.
 */
class UserTable
{
    /* Database helper configured for the users table */
    private DatabaseHelper $table;

    /* Initialise helper with connection, table name and model mapping */
    public function __construct()
    {
        $this->table = new DatabaseHelper(
            Database::getConnection(),
            'users',
            'userid',
            UserModel::class
        );
    }

    /* Retrieve all users */
    public function findAll(): array
    {
        return $this->table->findAll();
    }

    /* Retrieve a user by their primary key */
    public function findById(int $userid): object|false
    {
        return $this->table->find('userid', $userid);
    }

    /* Retrieve a user by email address */
    public function findByEmail(string $email): object|false
    {
        return $this->table->find('email', $email);
    }

    /* Insert a new user record */
    public function register(array $userData): string
    {
        return $this->table->insert($userData);
    }

    /* Insert or update a user record */
    public function save(array $userData): string|int
    {
        return $this->table->save($userData);
    }

    /* Delete a user by their primary key */
    public function delete(int $userid): void
    {
        $this->table->delete($userid);
    }
}