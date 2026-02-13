<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $firm_name = $_POST['firm_name'];
    $business_model = $_POST['business_model'];
    $contact_info = $_POST['contact_info'];
    $location = $_POST['location'];
    
    // Prepare the SQL query to update job data
    $sql = "UPDATE jobs SET firm_name = ?, business_model = ?, contact_info = ?, location = ? WHERE id = ?";
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$firm_name, $business_model, $contact_info, $location, $id]);
    } catch (PDOException $e) {
        die("Error updating job: " . $e->getMessage());
    }
    
    header('Location: list_jobs.php'); // Redirect to the main page after update
    exit();
} else {
    die("Invalid request.");
}
