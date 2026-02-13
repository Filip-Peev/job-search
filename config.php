<?php
define('DB_FILE', 'job_db.sqlite');

try {
    $pdo = new PDO("sqlite:" . DB_FILE);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    file_put_contents('db_error.log', $e->getMessage(), FILE_APPEND);
    die('There was an error connecting to the database. Please try again later.');
}

$create_table_query = "CREATE TABLE IF NOT EXISTS jobs (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        company_name TEXT,
        company_structure TEXT,
        web_site TEXT,
        major_products_services TEXT,
        company_type TEXT,
        major_technology_stack TEXT,
        company_culture TEXT,
        position_title TEXT,
        url TEXT,
        job_responsibilities TEXT,
        job_requirements TEXT,
        technologies TEXT,
        benefits TEXT,
        first_contact TEXT,
        contacted_person TEXT,
        schedule TEXT,
        how_it_went TEXT
);";

try {
    $pdo->exec($create_table_query);
} catch (PDOException $e) {
    file_put_contents('db_error.log', $e->getMessage(), FILE_APPEND);
    die('Error creating jobs table: Please try again later.');
}
