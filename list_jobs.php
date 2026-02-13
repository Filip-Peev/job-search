<?php
require_once 'config.php';

// Select all rows from the jobs table
$sql = "SELECT * FROM jobs";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    // Fetch all results as an associative array
    $jobs_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching job list: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Job List</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>

    <h1>Jobs</h1>
    <table border="1">
        <tr>
            <th>Firm Name</th>
            <th>Business Model</th>
            <th>Contact Info</th>
            <th>Location</th>
            <th>Edit/Delete</th>
        </tr>
        <?php foreach ($jobs_list as $job): ?>
            <tr>
                <td><?php echo htmlspecialchars($job['firm_name']); ?></td>
                <td><?php echo htmlspecialchars($job['business_model']); ?></td>
                <td><?php echo htmlspecialchars($job['contact_info']); ?></td>
                <td><?php echo htmlspecialchars($job['location']); ?></td>
                <td>
                    <a href="edit_job.php?id=<?php echo $job['id']; ?>">Edit</a> |
                    
                    <!-- Form to delete the job -->
                    <form action="delete_job.php" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this job?');">
                        <input type="hidden" name="id" value="<?php echo $job['id']; ?>">
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <a href="add_job.php">Add a New Job</a>

</body>

</html>
