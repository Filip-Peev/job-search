<?php
require_once 'config.php';

if (isset($_GET['id'])) {
    $job_id = $_GET['id'];
    
    // Fetch job data by its ID
    $sql = "SELECT * FROM jobs WHERE id = ?";
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$job_id]);
        $job = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$job) {
            die("Job not found.");
        }
    } catch (PDOException $e) {
        die("Error fetching job data: " . $e->getMessage());
    }
} else {
    die("Invalid request.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Job</title>
</head>
<body>

<h1>Edit Job</h1>

<form action="update_job.php" method="post">
    <!-- Hidden input to identify the job being edited -->
    <input type="hidden" name="id" value="<?php echo $job['id']; ?>">
    
    <label for="firm_name">Firm Name:</label><br>
    <input type="text" id="firm_name" name="firm_name" value="<?php echo htmlspecialchars($job['firm_name']); ?>"><br>
    
    <label for="business_model">Business Model:</label><br>
    <input type="text" id="business_model" name="business_model" value="<?php echo htmlspecialchars($job['business_model']); ?>"><br>
    
    <label for="contact_info">Contact Info:</label><br>
    <input type="text" id="contact_info" name="contact_info" value="<?php echo htmlspecialchars($job['contact_info']); ?>"><br>
    
    <label for="location">Location:</label><br>
    <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($job['location']); ?>"><br>
    
    <input type="submit" value="Update Job">
</form>

<a href="list_jobs.php">Back to Jobs List</a>

</body>
</html>
