<?php
require_once 'config.php'; // Ensure this path matches your actual file location

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firm_name = $_POST['firm_name'];
    $business_model = $_POST['business_model'];
    $contact_info = $_POST['contact_info'];
    $location = $_POST['location'];

    // Prepare and execute the SQL query to insert job data into the SQLite database
    $sql = "INSERT INTO jobs (firm_name, business_model, contact_info, location) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([$firm_name, $business_model, $contact_info, $location])) {
        // Success message and auto redirect after 1 seconds
        echo "<div style='position: fixed; top: 20px; left: 50%; transform: translateX(-50%); background-color: green; color: white; padding: 10px 20px; border-radius: 5px; font-size: 16px;'>Job added successfully!</div>";
        echo "<script>
                setTimeout(function() {
                    window.location.href = 'index.php';
                }, 1000); // Redirect after 1 second
              </script>";
        exit;
    } else {
        // If query execution fails, show the error alert and let the user click to go back
        echo "<script>alert('Failed to add job. Please try again.'); window.history.back();</script>";
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Viewport meta tag for mobile responsiveness -->
    <title>Add Job</title>
    <!-- Link to external CSS file -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Add a New Job</h1>
        <form action="" method="post">
            <label for="firm_name">Firm Name:</label><br>
            <input type="text" id="firm_name" name="firm_name"><br>

            <label for="business_model">Business Model:</label><br>
            <input type="text" id="business_model" name="business_model"><br>

            <label for="contact_info">Contact Info:</label><br>
            <input type="text" id="contact_info" name="contact_info"><br>

            <label for="location">Location:</label><br>
            <input type="text" id="location" name="location"><br>

            <input type="submit" value="Add Job">
        </form>
    </div>
</body>
</html>
