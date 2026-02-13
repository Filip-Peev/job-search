<?php
// Define database file path
define('DB_FILE', 'job_db.sqlite');

// Establish a PDO connection
try {
    $pdo = new PDO("sqlite:" . DB_FILE);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Log the error message to a file
    file_put_contents('db_error.log', $e->getMessage(), FILE_APPEND);
    die('There was an error connecting to the database. Please try again later.');
}

// Create table if it doesn't exist
$create_table_query = "CREATE TABLE IF NOT EXISTS jobs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    firm_name TEXT NOT NULL,
    business_model TEXT NOT NULL,
    contact_info TEXT NOT NULL,
    location TEXT NOT NULL
);";

try {
    $pdo->exec($create_table_query);
} catch (PDOException $e) {
    // Log the error message to a file
    file_put_contents('db_error.log', $e->getMessage(), FILE_APPEND);
    die('Error creating jobs table: Please try again later.');
}

?>