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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jobs List</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <a href="index.php" style="text-decoration: none;">
        <h1>Jobs</h1>
    </a>


    <a href="add_job.php" class="add-job-btn">Add New Job</a>

    <div class="searchbar-container">
        <!-- Search bar -->
        <input type="text" id="searchBar" placeholder="Filter..." oninput="searchJobs()">
    </div>

    <table>
        <thead>
            <tr>
                <th>Firm Name</th>
                <th>Business Model</th>
                <th>Contact Info</th>
                <th>Location</th>
                <th>Modify</th>
            </tr>
        </thead>
        <tbody id="jobTableBody">
            <?php foreach ($jobs_list as $job): ?>
                <tr>
                    <td><?php echo htmlspecialchars($job['firm_name']); ?></td>
                    <td><?php echo htmlspecialchars($job['business_model']); ?></td>
                    <td><?php echo htmlspecialchars($job['contact_info']); ?></td>
                    <td><?php echo htmlspecialchars($job['location']); ?></td>
                    <td>
                        <a href="edit_job.php?id=<?php echo $job['id']; ?>">Edit</a> |
                        <form action="delete_job.php" method="POST" style="display:inline;"
                            onsubmit="return confirm('Are you sure you want to delete this job?');">
                            <input type="hidden" name="id" value="<?php echo $job['id']; ?>">
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <script>
        function searchJobs() {
            let input = document.getElementById('searchBar').value.toLowerCase();
            let table = document.getElementById('jobTableBody');
            let rows = table.getElementsByTagName('tr');
            let found = false;

            // Loop through all table rows and hide those that don't match the search
            for (let i = 0; i < rows.length; i++) {
                let cells = rows[i].getElementsByTagName('td');
                let rowText = "";

                // Combine the text from each cell in the row
                for (let j = 0; j < cells.length - 1; j++) {  // Skip the last cell (Modify column)
                    rowText += cells[j].textContent.toLowerCase() + " ";
                }

                if (rowText.includes(input)) {
                    rows[i].style.display = '';
                    rows[i].classList.add('highlight'); // Highlight matching rows
                    found = true;
                } else {
                    rows[i].style.display = 'none';
                    rows[i].classList.remove('highlight');
                }
            }

            // Scroll to the first found row
            if (found) {
                for (let i = 0; i < rows.length; i++) {
                    if (rows[i].style.display !== 'none') {
                        rows[i].scrollIntoView({ behavior: 'smooth', block: 'center' });
                        break;
                    }
                }
            }
        }
    </script>

</body>

</html>