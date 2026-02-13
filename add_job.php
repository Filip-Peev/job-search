<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve values from POST request, ensuring undefined values default to an empty string
    $company_name = $_POST['company_name'] ?? '';
    $company_structure = $_POST['company_structure'] ?? '';
    $web_site = $_POST['web_site'] ?? '';
    $major_products_services = $_POST['major_products_services'] ?? '';
    $company_type = $_POST['company_type'] ?? '';
    $major_technology_stack = $_POST['major_technology_stack'] ?? '';
    $company_culture = $_POST['company_culture'] ?? '';
    $position_title = $_POST['position_title'] ?? '';
    $url = $_POST['url'] ?? '';
    $job_responsibilities = $_POST['job_responsibilities'] ?? '';
    $job_requirements = $_POST['job_requirements'] ?? '';
    $technologies = $_POST['technologies'] ?? '';
    $benefits = $_POST['benefits'] ?? '';
    $first_contact = $_POST['first_contact'] ?? '';
    $contacted_person = $_POST['contacted_person'] ?? '';
    $schedule = $_POST['schedule'] ?? '';
    $how_it_went = $_POST['how_it_went'] ?? '';

    // Prepare and execute the SQL query to insert job data into the database
    $sql = "INSERT INTO jobs (
                company_name, company_structure, web_site, major_products_services, company_type,
                major_technology_stack, company_culture, position_title, url, job_responsibilities,
                job_requirements, technologies, benefits, first_contact, contacted_person, schedule, how_it_went
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
    $stmt = $pdo->prepare($sql);

    if (
        $stmt->execute([
            $company_name,
            $company_structure,
            $web_site,
            $major_products_services,
            $company_type,
            $major_technology_stack,
            $company_culture,
            $position_title,
            $url,
            $job_responsibilities,
            $job_requirements,
            $technologies,
            $benefits,
            $first_contact,
            $contacted_person,
            $schedule,
            $how_it_went
        ])
    ) {
        echo "<div style='position: fixed; top: 20px; left: 50%; transform: translateX(-50%); background-color: green; color: white; padding: 10px 20px; border-radius: 5px; font-size: 16px;'>Job added successfully!</div>";
        echo "<script>
                setTimeout(function() {
                    window.location.href = 'index.php';
                }, 1000);
              </script>";
        exit;
    } else {
        echo "<script>alert('Failed to add job. Please try again.'); window.history.back();</script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Job</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <h1>Add a New Job</h1>
        <form action="" method="post">
            <label for="company_name">Company Name:</label><br>
            <input type="text" id="company_name" name="company_name" placeholder="Enter the company name"><br>

            <label for="company_structure">Company Structure:</label><br>
            <input type="text" id="company_structure" name="company_structure" placeholder="Start-up / corporation"><br>

            <label for="web_site">Website:</label><br>
            <input type="text" id="web_site" name="web_site" placeholder="Company website"><br>

            <label for="major_products_services">Major Products/Services:</label><br>
            <input type="text" id="major_products_services" name="major_products_services"
                placeholder="Company Products / Services"><br>

            <label for="company_type">Company Type:</label><br>
            <input type="text" id="company_type" name="company_type" placeholder="Product / Service / Mixed"><br>

            <label for="major_technology_stack">Technology Stack:</label><br>
            <input type="text" id="major_technology_stack" name="major_technology_stack" placeholder="Java / Spring / MySQL / ASP.NET / Others"><br>

            <label for="company_culture">Company Culture:</label><br>
            <input type="text" id="company_culture" name="company_culture" placeholder="Collaborative..."><br>

            <label for="position_title">Position Title:</label><br>
            <input type="text" id="position_title" name="position_title" placeholder="What they are looking for..."><br>

            <label for="url">Job URL:</label><br>
            <input type="text" id="url" name="url" placeholder="Link to the Job Posting"><br>

            <label for="job_responsibilities">Job Responsibilities:</label><br>
            <input type="text" id="job_responsibilities" name="job_responsibilities"
                placeholder="Job Responsibilities"><br>

            <label for="job_requirements">Job Requirements:</label><br>
            <input type="text" id="job_requirements" name="job_requirements" placeholder="Job Requirements"><br>

            <label for="technologies">Technologies:</label><br>
            <input type="text" id="technologies" name="technologies" placeholder="Technologies you need to know / learn"><br>

            <label for="benefits">Benefits:</label><br>
            <input type="text" id="benefits" name="benefits" placeholder="Company Benefits they offer"><br>

            <label for="first_contact">First Contact:</label><br>
            <input type="text" id="first_contact" name="first_contact" placeholder="First Contact Date / Time"><br>

            <label for="contacted_person">Contacted Person:</label><br>
            <input type="text" id="contacted_person" name="contacted_person" placeholder="Contacted Person"><br>

            <label for="schedule">Schedule:</label><br>
            <input type="text" id="schedule" name="schedule" placeholder="Scheduled Meeting"><br>

            <label for="how_it_went">How It Went:</label><br>
            <input type="text" id="how_it_went" name="how_it_went" placeholder="How It Went..."><br>

            <input type="submit" value="Add Job">
        </form>
        <a href="index.php">Back to Jobs List</a>
    </div>
</body>

</html>