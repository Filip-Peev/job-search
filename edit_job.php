<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $company_name = $_POST['company_name'];
    $company_structure = $_POST['company_structure'];
    $web_site = $_POST['web_site'];
    $major_products_services = $_POST['major_products_services'];
    $company_type = $_POST['company_type'];
    $major_technology_stack = $_POST['major_technology_stack'];
    $company_culture = $_POST['company_culture'];
    $position_title = $_POST['position_title'];
    $url = $_POST['url'];
    $job_responsibilities = $_POST['job_responsibilities'];
    $job_requirements = $_POST['job_requirements'];
    $technologies = $_POST['technologies'];
    $benefits = $_POST['benefits'];
    $first_contact = $_POST['first_contact'];
    $contacted_person = $_POST['contacted_person'];
    $schedule = $_POST['schedule'];
    $how_it_went = $_POST['how_it_went'];

    $sql = "UPDATE jobs SET 
                company_name = ?, 
                company_structure = ?, 
                web_site = ?, 
                major_products_services = ?, 
                company_type = ?, 
                major_technology_stack = ?, 
                company_culture = ?, 
                position_title = ?, 
                url = ?, 
                job_responsibilities = ?,
                job_requirements = ?, 
                technologies = ?, 
                benefits = ?, 
                first_contact = ?, 
                contacted_person = ?, 
                schedule = ?, 
                how_it_went = ? 
            WHERE id = ?";
    try {
        $stmt = $pdo->prepare($sql);
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
            $how_it_went,
            $id
        ]);
    } catch (PDOException $e) {
        die("Error updating job: " . $e->getMessage());
    }

    // Redirect to the main page after update
    header('Location: index.php');
    exit();
}

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Job</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <div class="container">
        <h1>Edit Job</h1>

        <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo $job['id']; ?>">

            <label for="company_name">Company Name:</label><br>
            <input type="text" id="company_name" name="company_name" value="<?php echo $job['company_name']; ?>"><br>

            <label for="company_structure">Company Structure:</label><br>
            <input type="text" id="company_structure" name="company_structure"
                value="<?php echo $job['company_structure']; ?>"><br>

            <label for="web_site">Website:</label><br>
            <input type="text" id="web_site" name="web_site" value="<?php echo $job['web_site']; ?>"><br>

            <label for="major_products_services">Major Products/Services:</label><br>
            <input type="text" id="major_products_services" name="major_products_services"
                value="<?php echo $job['major_products_services']; ?>"><br>

            <label for="company_type">Company Type:</label><br>
            <input type="text" id="company_type" name="company_type" value="<?php echo $job['company_type']; ?>"><br>

            <label for="major_technology_stack">Technology Stack:</label><br>
            <input type="text" id="major_technology_stack" name="major_technology_stack"
                value="<?php echo $job['major_technology_stack']; ?>"><br>

            <label for="company_culture">Company Culture:</label><br>
            <input type="text" id="company_culture" name="company_culture"
                value="<?php echo $job['company_culture']; ?>"><br>

            <label for="position_title">Position Title:</label><br>
            <input type="text" id="position_title" name="position_title"
                value="<?php echo $job['position_title']; ?>"><br>

            <label for="url">Job URL:</label><br>
            <input type="text" id="url" name="url" value="<?php echo $job['url']; ?>"><br>

            <label for="job_responsibilities">Job Responsibilities:</label><br>
            <input type="text" id="job_responsibilities" name="job_responsibilities"
                value="<?php echo $job['job_responsibilities']; ?>"><br>

            <label for="job_requirements">Job Requirements:</label><br>
            <input type="text" id="job_requirements" name="job_requirements"
                value="<?php echo $job['job_requirements']; ?>"><br>

            <label for="technologies">Technologies:</label><br>
            <input type="text" id="technologies" name="technologies" value="<?php echo $job['technologies']; ?>"><br>

            <label for="benefits">Benefits:</label><br>
            <input type="text" id="benefits" name="benefits" value="<?php echo $job['benefits']; ?>"><br>

            <label for="first_contact">First Contact:</label><br>
            <input type="text" id="first_contact" name="first_contact" value="<?php echo $job['first_contact']; ?>"><br>

            <label for="contacted_person">Contacted Person:</label><br>
            <input type="text" id="contacted_person" name="contacted_person"
                value="<?php echo $job['contacted_person']; ?>"><br>

            <label for="schedule">Schedule:</label><br>
            <input type="text" id="schedule" name="schedule" value="<?php echo $job['schedule']; ?>"><br>

            <label for="how_it_went">How It Went:</label><br>
            <input type="text" id="how_it_went" name="how_it_went" value="<?php echo $job['how_it_went']; ?>"><br>

            <input type="submit" value="Update Job">
        </form>

        <a href="index.php">Back to Jobs List</a>
    </div>

</body>

</html>