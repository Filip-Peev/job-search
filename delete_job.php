<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    // Prepare the SQL query to delete the job entry
    $sql = "DELETE FROM jobs WHERE id = ?";
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
    } catch (PDOException $e) {
        die("Error deleting job: " . $e->getMessage());
    }

    // Redirect to the main page after deletion
    header('Location: index.php');
    exit();
} else {
    die("Invalid request.");
}
