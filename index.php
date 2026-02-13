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

// JSON export functionality
if (isset($_GET['export']) && $_GET['export'] === 'json') {
    header('Content-Type: application/json');
    header('Content-Disposition: attachment; filename="jobs_list.json"');
    echo json_encode($jobs_list, JSON_PRETTY_PRINT);
    exit;
}

// JSON import functionality (replace all existing jobs)
$import_message = '';
if (isset($_POST['import_json']) && isset($_FILES['json_file'])) {
    $file = $_FILES['json_file']['tmp_name'];
    if ($file) {
        $json_data = file_get_contents($file);
        $jobs = json_decode($json_data, true);

        if (is_array($jobs)) {
            try {
                $pdo->beginTransaction();

                // Delete all existing jobs
                $pdo->exec("DELETE FROM jobs");

                // Prepare insert statement
                $insert_sql = "INSERT INTO jobs 
                    (company_name, company_structure, web_site, major_products_services, company_type,
                    major_technology_stack, company_culture, position_title, url, job_responsibilities,
                    job_requirements, technologies, benefits, first_contact, contacted_person,
                    schedule, how_it_went) 
                    VALUES 
                    (:company_name, :company_structure, :web_site, :major_products_services, :company_type,
                    :major_technology_stack, :company_culture, :position_title, :url, :job_responsibilities,
                    :job_requirements, :technologies, :benefits, :first_contact, :contacted_person,
                    :schedule, :how_it_went)";

                $stmt = $pdo->prepare($insert_sql);

                $count = 0;
                foreach ($jobs as $job) {
                    $stmt->execute([
                        ':company_name' => $job['company_name'] ?? '',
                        ':company_structure' => $job['company_structure'] ?? '',
                        ':web_site' => $job['web_site'] ?? '',
                        ':major_products_services' => $job['major_products_services'] ?? '',
                        ':company_type' => $job['company_type'] ?? '',
                        ':major_technology_stack' => $job['major_technology_stack'] ?? '',
                        ':company_culture' => $job['company_culture'] ?? '',
                        ':position_title' => $job['position_title'] ?? '',
                        ':url' => $job['url'] ?? '',
                        ':job_responsibilities' => $job['job_responsibilities'] ?? '',
                        ':job_requirements' => $job['job_requirements'] ?? '',
                        ':technologies' => $job['technologies'] ?? '',
                        ':benefits' => $job['benefits'] ?? '',
                        ':first_contact' => $job['first_contact'] ?? '',
                        ':contacted_person' => $job['contacted_person'] ?? '',
                        ':schedule' => $job['schedule'] ?? '',
                        ':how_it_went' => $job['how_it_went'] ?? '',
                    ]);
                    $count++;
                }

                $pdo->commit();
                $import_message = "$count job(s) imported successfully! Previous jobs have been replaced.";

                // Reload jobs list
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $jobs_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                $pdo->rollBack();
                $import_message = "Import failed: " . $e->getMessage();
            }
        } else {
            $import_message = "Invalid JSON file.";
        }
    }
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

    <h1><a href="index.php" style="text-decoration: none; color: inherit;">Jobs</a></h1>

    <div class="button-bar">
        <a href="add_job.php" class="add-job-btn" style="display: inline-block;">Add New Job</a>
    </div>

    <div class="searchbar-container">
        <input type="search" id="searchBar" placeholder="Filter jobs..." oninput="searchJobs()">
    </div>

    <?php if ($import_message): ?>
        <p id="status-message" style="color: white; font-weight: bold; background-color: #28a745; padding: 10px; border-radius: 5px;">
            <?php echo htmlspecialchars($import_message); ?>
        </p>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Company Name</th>
                <?php foreach ($jobs_list as $job): ?>
                    <th><?php echo htmlspecialchars($job['company_name'] ?? 'Job'); ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>

        <tbody>
            <?php
            $fields = [
                'Company Structure' => 'company_structure',
                'Website' => 'web_site',
                'Major Products / Services' => 'major_products_services',
                'Company Type' => 'company_type',
                'Technology Stack' => 'major_technology_stack',
                'Company Culture' => 'company_culture',
                'Position Title' => 'position_title',
                'Job URL' => 'url',
                'Responsibilities' => 'job_responsibilities',
                'Requirements' => 'job_requirements',
                'Technologies' => 'technologies',
                'Benefits' => 'benefits',
                'First Contact' => 'first_contact',
                'Contacted Person' => 'contacted_person',
                'Schedule' => 'schedule',
                'How It Went' => 'how_it_went',
            ];

            foreach ($fields as $label => $key):
            ?>
                <tr>
                    <th><?php echo $label; ?></th>
                    <?php foreach ($jobs_list as $job): ?>
                        <td><?php echo htmlspecialchars($job[$key] ?? ''); ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>

            <tr>
                <th>Modify</th>
                <?php foreach ($jobs_list as $job): ?>
                    <td>
                        <a href="edit_job.php?id=<?php echo $job['id']; ?>">Edit</a>
                        <form action="delete_job.php" method="POST" style="display:inline;"
                            onsubmit="return confirm('Are you sure you want to delete this job?');">
                            <input type="hidden" name="id" value="<?php echo $job['id']; ?>">
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                <?php endforeach; ?>
            </tr>
        </tbody>
    </table>

    <div class="button-bar" style="display: flex; gap: 10px; margin-top: 25px; align-items: center;">
        <a href="index.php?export=json" class="add-job-btn" style="display: inline-block;">Export JSON</a>

        <form id="importForm" action="index.php" method="POST" enctype="multipart/form-data" style="display: inline-flex; margin: 0; padding: 0; align-items: center;">
            <input type="file" name="json_file" id="jsonFileInput" accept=".json" style="display:none;" required>
            <input type="hidden" name="import_json" value="1">
            <button type="button" class="add-job-btn" onclick="document.getElementById('jsonFileInput').click();" style="cursor: pointer;">Import JSON</button>
        </form>
    </div>

    <script>
        // Search/filter functionality
        function searchJobs() {
            const query = document.getElementById('searchBar').value.toLowerCase();
            const table = document.querySelector('table');
            const rows = table.rows;
            if (rows.length === 0) return;

            const columnCount = rows[0].cells.length;

            for (let r = 0; r < rows.length; r++) {
                const cells = rows[r].cells;
                for (let c = 1; c < cells.length; c++) {
                    cells[c].classList.remove('highlight', 'highlight-col');
                }
            }

            if (query === "") return;

            for (let c = 1; c < columnCount; c++) {
                let matchFound = false;

                for (let r = 1; r < rows.length - 1; r++) {
                    const cell = rows[r].cells[c];
                    if (cell && cell.textContent.toLowerCase().includes(query)) {
                        matchFound = true;
                        cell.classList.add('highlight');
                    }
                }

                if (matchFound) {
                    for (let r = 1; r < rows.length - 1; r++) {
                        if (rows[r].cells[c]) {
                            rows[r].cells[c].classList.add('highlight-col');
                        }
                    }
                }
            }
        }

        // Auto-submit import form when file selected
        document.getElementById('jsonFileInput').addEventListener('change', function() {
            if (this.files.length > 0) {
                document.getElementById('importForm').submit();
            }
        });

        // If an import message exists, wait 4 seconds and reload
        <?php if (!empty($import_message)): ?>
            setTimeout(function() {
                window.location.href = 'index.php';
            }, 4000);
        <?php endif; ?>
    </script>

</body>

</html>