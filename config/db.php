<?php
$host   = '127.0.0.1';
$db     = 'webapp_db';
$user   = 'root';
$pass   = '';
$charset= 'utf8mb4';

if (getenv('TEST_MODE')) {
    $pdo = new PDO('sqlite::memory:');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->exec('CREATE TABLE clients (firstName TEXT, lastName TEXT, company TEXT, phone TEXT)');
} else {
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    try {
        $pdo = new PDO($dsn, $user, $pass, $options);
    } catch (\PDOException $e) {
        die("DB connection failed: " . $e->getMessage());
    }
}
