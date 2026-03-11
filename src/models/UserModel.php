<?php
namespace models;

/*
 * UserModel
 *
 * Represents a single record from the users table.
 * Instances of this class are automatically populated by PDO
 * when database results are fetched using FETCH_CLASS.
 */
class UserModel
{
    /* Primary key */
    public ?int $userid = null;

    /* User's first name */
    public string $firstname = '';

    /* User's last name */
    public string $lastname = '';

    /* Email address used for authentication */
    public string $email = '';

    /* Hashed password */
    public string $password = '';

    /* User role (e.g. admin, user) */
    public string $role = '';

    /* Timestamp when the account was created */
    public ?string $created_at = null;  
}