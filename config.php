<?php
define('DB_FILE', 'job_db.sqlite');

try {
    // Establish connection to the SQLite database
    $pdo = new PDO("sqlite:" . __DIR__ . '/' . DB_FILE);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Log any connection errors
    file_put_contents('db_error.log', $e->getMessage(), FILE_APPEND);
    die('There was an error connecting to the database. Please try again later.');
}
?>