<?php
include 'header.php';
include '../includes/db.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize input data
    $ups_id = mysqli_real_escape_string($conn, $_POST['ups_id']);
    $monitor_id = mysqli_real_escape_string($conn, $_POST['monitor_id']);
    $internet = mysqli_real_escape_string($conn, $_POST['internet']);
    $cpu_id = mysqli_real_escape_string($conn, $_POST['cpu_id']); // New field
    $issue = mysqli_real_escape_string($conn, $_POST['issue']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $lab_name = mysqli_real_escape_string($conn, $_POST['lab_name']);
    $os_installed = mysqli_real_escape_string($conn, $_POST['os_installed']);
    $ram = mysqli_real_escape_string($conn, $_POST['ram']);

    // Handle the image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_name = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_size = $_FILES['image']['size'];
        $image_type = $_FILES['image']['type'];

        // Validate file type (e.g., only allow JPG, PNG, GIF)
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($image_type, $allowed_types)) {
            // Move the uploaded file to a folder
            $upload_dir = '../uploads/';
            $image_path = $upload_dir . basename($image_name);
            if (move_uploaded_file($image_tmp, $image_path)) {
                // Successfully uploaded the image
            } else {
                echo "<p>Error uploading image.</p>";
                exit();
            }
        } else {
            echo "<p>Invalid file type. Only JPG, PNG, and GIF are allowed.</p>";
            exit();
        }
    } else {
        $image_path = ''; // If no image is uploaded, leave the field empty
    }

    // Insert data into the database
    $query = "INSERT INTO systems (ups_id, monitor_id, internet, cpu_id, image, issue, description, lab_name, os_installed, ram)
              VALUES ('$ups_id', '$monitor_id', '$internet', '$cpu_id', '$image_path', '$issue', '$description', '$lab_name', '$os_installed', '$ram')";

    if (mysqli_query($conn, $query)) {
        header('Location: manage_systems.php'); // Redirect on success
        exit();
    } else {
        echo "<p>Error adding system: " . mysqli_error($conn) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New System</title>
    <link rel="stylesheet" href="admin_panel.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<style>
    /* Styles for the page */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

main {
    width: 80%;
    margin: 20px auto;
    background-color: #fff;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

h1 {
    font-size: 26px;
    color: #333;
    text-align: center;
    margin-bottom: 20px;
}

form {
    margin-bottom: 30px;
}

label {
    font-size: 16px;
    color: #333;
    margin-bottom: 5px;
    display: inline-block;
}

input[type="text"], textarea, input[type="file"] {
    width: 100%;
    padding: 12px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-sizing: border-box;
}

textarea {
    height: 120px;
    resize: vertical;
}

button {
    background-color: #4CAF50;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease;
    display: inline-block;
}

button:hover {
    background-color: #45a049;
}

footer {
    text-align: center;
    padding: 10px;
    background-color: #333;
    color: #fff;
    position: absolute;
    bottom: 0;
    width: 100%;
}

footer p {
    margin: 0;
    font-size: 14px;
}

</style>
<main>
    <h1>Add New System</h1>
    <form method="POST" enctype="multipart/form-data">

        <label for="lab_name">Lab Name</label>
        <input type="text" name="lab_name" required><br>

        <label for="cpu_id">CPU ID</label> <!-- New field for CPU ID -->
        <input type="text" name="cpu_id" required><br>

        <label for="ups_id">UPS ID</label>
        <input type="text" name="ups_id" required><br>

        <label for="monitor_id">Monitor ID</label>
        <input type="text" name="monitor_id" required><br>

        <label for="image">Image</label>
        <input type="file" name="image"><br>

        <label for="os_installed">Operating System Installed</label>
        <input type="text" name="os_installed" required><br>

        <label for="ram">RAM</label>
        <input type="text" name="ram" required><br>

        <label for="internet">Internet</label>
        <select name="internet" required>
            <option value="Yes">Yes</option>
            <option value="No">No</option>
            <option value="Unknown">Unknown</option>
        </select><br>

        <label for="issue">Issue</label>
        <textarea name="issue" required></textarea><br>

        <label for="description">Description</label>
        <textarea name="description" required></textarea><br>

        <button type="submit">Add System</button>
    </form>
</main>
</body>
</html>
