<?php
require 'vendor/autoload.php';

$config = require 'config/database.php';

try {
    $db = new PDO(
        "mysql:host={$config['host']};dbname={$config['database']}",
        $config['username'],
        $config['password']
    );

    $stmt = $db->query('SELECT id, username, password FROM admins LIMIT 5');
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "Database connection successful!\n\n";
    echo "Available admin accounts:\n";
    echo str_repeat("-", 80) . "\n";

    foreach ($users as $user) {
        echo "ID: {$user['id']} | Username: {$user['username']} | Password: {$user['password']}\n";
    }
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage() . "\n";
}
