<?php
require_once 'config.php';

// If the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from the form
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

    header('Location: index.php'); // Redirect to the main page after update
    exit();
} 

// If the form is not yet submitted, fetch the job data
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Viewport meta tag for mobile responsiveness -->
    <title>Edit Job</title>
    <!-- Link to external CSS file -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container">
    <h1>Edit Job</h1>

    <form action="" method="post">
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

    <a href="index.php">Back to Jobs List</a>
</div>

</body>
</html>
