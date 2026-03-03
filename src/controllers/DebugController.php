<?php
namespace controllers;

use framework\Database;

class DebugController
{
    public function db(): array
    {
        $pdo = Database::getConnection();

        $dbName = $pdo->query('SELECT DATABASE() AS db')->fetch()['db'] ?? 'unknown';
        $eventCount = (int)($pdo->query('SELECT COUNT(*) AS c FROM events')->fetch()['c'] ?? 0);

        return [
            'title' => 'DB Debug',
            'template' => 'debug-db.html.php',
            'variables' => [
                'dbName' => $dbName,
                'eventCount' => $eventCount
            ]
        ];
    }
}