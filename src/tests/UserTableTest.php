<?php

use PHPUnit\Framework\TestCase;
use framework\Database;
use models\UserTable;

/*
 * UserTableTest
 *
 * Whitebox/integration tests for user database logic.
 * These tests check registration, email lookup, password hashing,
 * updating, and deletion using controlled PHPUnit test data.
 */
final class UserTableTest extends TestCase
{
    private PDO $pdo;
    private UserTable $users;

    protected function setUp(): void
    {
        $this->pdo = Database::getConnection();
        $this->users = new UserTable();

        $this->resetTestData();
    }

    protected function tearDown(): void
    {
        $this->resetTestData();
    }

    /*
     * Remove only test records created by this file.
     * This protects real application users from being affected by the tests.
     */
    private function resetTestData(): void
    {
        $this->pdo->exec(
            "DELETE FROM bookings
             WHERE userid IN (
                 SELECT userid FROM users
                 WHERE email LIKE 'phpunit-user%@example.com'
             )"
        );

        $this->pdo->exec(
            "DELETE FROM users
             WHERE email LIKE 'phpunit-user%@example.com'"
        );
    }

    /*
     * Create a user through the real UserTable::register() method.
     */
    private function createTestUser(string $email = 'phpunit-user@example.com'): int
    {
        return (int) $this->users->register([
            'firstname' => 'PHPUnit',
            'lastname' => 'User',
            'email' => $email,
            'password' => password_hash('password123', PASSWORD_DEFAULT),
            'role' => 'user'
        ]);
    }

    /*
     * Registration should insert a new user that can be found by email.
     */
    public function testRegisterCreatesUserAndFindByEmailReturnsIt(): void
    {
        $this->createTestUser();

        $user = $this->users->findByEmail('phpunit-user@example.com');

        $this->assertNotFalse($user);
        $this->assertSame('PHPUnit', $user->firstname);
        $this->assertSame('User', $user->lastname);
        $this->assertSame('phpunit-user@example.com', $user->email);
        $this->assertSame('user', $user->role);
    }

    /*
     * Stored passwords should be hashed rather than saved as plain text.
     */
    public function testRegisteredUserPasswordIsHashed(): void
    {
        $this->createTestUser();

        $user = $this->users->findByEmail('phpunit-user@example.com');

        $this->assertNotFalse($user);
        $this->assertNotSame('password123', $user->password);
        $this->assertTrue(password_verify('password123', $user->password));
    }

    /*
     * findByEmail() should return false when no matching account exists.
     */
    public function testFindByEmailReturnsFalseForMissingUser(): void
    {
        $user = $this->users->findByEmail('missing-phpunit-user@example.com');

        $this->assertFalse($user);
    }

    /*
     * save() should update an existing user when the primary key is provided.
     */
    public function testSaveCanUpdateExistingUser(): void
    {
        $userid = $this->createTestUser();

        $this->users->save([
            'userid' => $userid,
            'firstname' => 'Updated',
            'lastname' => 'User',
            'email' => 'phpunit-user@example.com',
            'password' => password_hash('password123', PASSWORD_DEFAULT),
            'role' => 'admin'
        ]);

        $updatedUser = $this->users->findById($userid);

        $this->assertNotFalse($updatedUser);
        $this->assertSame('Updated', $updatedUser->firstname);
        $this->assertSame('admin', $updatedUser->role);
    }

    /*
     * delete() should remove a user from the database.
     */
    public function testDeleteRemovesUser(): void
    {
        $userid = $this->createTestUser();

        $this->users->delete($userid);

        $deletedUser = $this->users->findById($userid);

        $this->assertFalse($deletedUser);
    }
}