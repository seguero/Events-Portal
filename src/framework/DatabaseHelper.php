<?php
namespace framework;

use PDO;

/*
 * DatabaseHelper
 *
 * Provides reusable database operations (CRUD) for any table in the system.
 * Table-specific models instantiate this helper by supplying the PDO connection,
 * table name, primary key and the class used to map database rows into objects.
 *
 * This centralises SQL logic and prevents repetition across models.
 */
class DatabaseHelper
{
    /* PDO database connection */
    private PDO $pdo;

    /* Table name handled by this helper instance */
    private string $table;

    /* Primary key column of the table */
    private string $primaryKey;

    /* Class used to map query results into objects */
    private string $className;

    /* Initialise helper with table configuration */
    public function __construct(
        PDO $pdo,
        string $table,
        string $primaryKey,
        string $className = 'stdClass'
    ) {
        $this->pdo = $pdo;
        $this->table = $table;
        $this->primaryKey = $primaryKey;
        $this->className = $className;
    }

    /* Retrieve all rows from the table */
    public function findAll(): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table}");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, $this->className);

        return $stmt->fetchAll();
    }

    /* Retrieve a single row by a specific field */
    public function find(string $field, mixed $value): object|false
    {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM {$this->table} WHERE {$field} = :value"
        );

        $stmt->execute([
            'value' => $value
        ]);

        $stmt->setFetchMode(PDO::FETCH_CLASS, $this->className);

        return $stmt->fetch();
    }

    /* Retrieve distinct values from a column */
    public function findDistinct(string $field): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT DISTINCT {$field} FROM {$this->table} ORDER BY {$field} ASC"
        );

        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }

    /* Retrieve multiple rows matching a field value */
    public function findBy(string $field, mixed $value): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM {$this->table} WHERE {$field} = :value"
        );

        $stmt->execute([
            'value' => $value
        ]);

        $stmt->setFetchMode(PDO::FETCH_CLASS, $this->className);

        return $stmt->fetchAll();
    }

    /* Insert a new record */
    public function insert(array $record): string
    {
        $keys = array_keys($record);

        $fields = implode(', ', $keys);
        $placeholders = ':' . implode(', :', $keys);

        $sql = "INSERT INTO {$this->table} ({$fields}) VALUES ({$placeholders})";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($record);

        return $this->pdo->lastInsertId();
    }

    /* Update an existing record based on the primary key */
    public function update(array $record): void
    {
        $fields = [];

        foreach ($record as $key => $value) {
            if ($key !== $this->primaryKey) {
                $fields[] = "{$key} = :{$key}";
            }
        }

        $sql = "UPDATE {$this->table}
                SET " . implode(', ', $fields) . "
                WHERE {$this->primaryKey} = :primaryKey";

        $record['primaryKey'] = $record[$this->primaryKey];

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($record);
    }

    /* Insert or update depending on whether the primary key exists */
    public function save(array $record): string|int
    {
        if (isset($record[$this->primaryKey]) && !empty($record[$this->primaryKey])) {
            $this->update($record);
            return $record[$this->primaryKey];
        }

        return $this->insert($record);
    }

    /* Delete a record by primary key */
    public function delete(mixed $id): void
    {
        $stmt = $this->pdo->prepare(
            "DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id"
        );

        $stmt->execute([
            'id' => $id
        ]);
    }

    /* Retrieve ID of the last inserted record */
    public function getLastInsertId(): string
    {
        return $this->pdo->lastInsertId();
    }
}