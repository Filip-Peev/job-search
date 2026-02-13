<?php
require_once 'config.php';

// SQL statement to create the jobs table if it doesn't exist
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
    // Execute the creation query
    $pdo->exec($create_table_query);
    echo "<div style='font-family: Arial; padding: 20px; background: #d4edda; color: #155724; border-radius: 5px;'>
            <h2>Success!</h2>
            <p>Database and 'jobs' table have been initialized.</p>
            <p>Redirecting you to the home page in 3 seconds...</p>
          </div>";
    header('Refresh: 3; url=index.php');
} catch (PDOException $e) {
    file_put_contents('db_error.log', $e->getMessage(), FILE_APPEND);
    die('Error initializing database: ' . $e->getMessage());
}
?>