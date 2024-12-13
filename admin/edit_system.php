<?php
session_start(); // Ensure the session is started
include '../includes/db.php';
// Check if the user is logged in
if (!isset($_SESSION['admin'])) {
    header('Location: ../public/login.php');
    exit();
}

// Check if the ID is provided in the URL
if (isset($_GET['id'])) {
    $system_id = intval($_GET['id']); // Use intval for security
    $query = "SELECT * FROM systems WHERE id = $system_id";
    $result = mysqli_query($conn, $query);

    // Check if the result contains data
    if ($result && mysqli_num_rows($result) > 0) {
        $system = mysqli_fetch_assoc($result);
    } else {
        // Redirect or show an error if the system is not found
        echo "<p>System not found.</p>";
        exit();
    }
} else {
    // Redirect or show an error if ID is not provided
    echo "<p>Invalid system ID.</p>";
    exit();
}

// Handle Update (Edit the system)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate input
    $ups_id = mysqli_real_escape_string($conn, $_POST['ups_id']);
    $monitor_id = mysqli_real_escape_string($conn, $_POST['monitor_id']);
    $internet = mysqli_real_escape_string($conn, $_POST['internet']);
    $image = ""; // Default to empty string for no image
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        // Handle file upload
        $targetDir = "uploads/";
        $imageName = basename($_FILES['image']['name']);
        $imagePath = $targetDir . $imageName;

        // Check if file is an image
        $imageFileType = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES['image']['tmp_name']);
        if ($check !== false) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
                $image = $imagePath; // Store the image path in the database
            } else {
                echo "Error uploading the file.";
            }
        } else {
            echo "Uploaded file is not an image.";
        }
    } else {
        // If no image is uploaded, keep the previous image value
        $image = $system['image'];
    }

    $issue = mysqli_real_escape_string($conn, $_POST['issue']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $lab_name = mysqli_real_escape_string($conn, $_POST['lab_name']);
    $os_installed = mysqli_real_escape_string($conn, $_POST['os_installed']);
    $ram = mysqli_real_escape_string($conn, $_POST['ram']);

    // Update query
    $update_query = "UPDATE systems SET 
        ups_id = '$ups_id', 
        monitor_id = '$monitor_id', 
        internet = '$internet', 
        image = '$image', 
        issue = '$issue', 
        description = '$description', 
        lab_name = '$lab_name', 
        os_installed = '$os_installed', 
        ram = '$ram' 
        WHERE id = $system_id";

    if (mysqli_query($conn, $update_query)) {
        header('Location: manage_systems.php'); // Redirect on success
        exit();
    } else {
        echo "<p>Error updating system: " . mysqli_error($conn) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit System</title>
    <link rel="stylesheet" href="admin_panel.css">
    <link rel="stylesheet" href="bootstrap.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <style>
        /* General Styles */
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
    font-size: 24px;
    color: #333;
    text-align: center;
    margin-bottom: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
}

th, td {
    padding: 12px;
    text-align: left;
    border: 1px solid #ddd;
}

th {
    background-color: #f7f7f7;
    color: #333;
}

input[type="text"], textarea {
    width: 100%;
    padding: 10px;
    margin: 8px 0;
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
    display: block;
    width: 200px;
    margin: 20px auto;
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

/* Responsive Design */
@media (max-width: 768px) {
    main {
        width: 95%;
        padding: 20px;
    }

    table {
        font-size: 14px;
    }

    button {
        width: 100%;
    }
}

    </style>
    <main>
        <h1>Edit System: <?php echo htmlspecialchars($system['id']); ?></h1>
        <form method="POST" enctype="multipart/form-data">
    <label for="ups_id">UPS ID</label>
    <input type="text" name="ups_id" value="<?php echo htmlspecialchars($system['ups_id']); ?>" required><br>

    <label for="monitor_id">Monitor ID</label>
    <input type="text" name="monitor_id" value="<?php echo htmlspecialchars($system['monitor_id']); ?>" required><br>

    <label for="internet">Internet</label>
    <input type="text" name="internet" value="<?php echo htmlspecialchars($system['internet']); ?>" required><br>

    <label for="image">Image</label>
    <input type="file" name="image"><br>

    <label for="issue">Issue</label>
    <textarea name="issue"><?php echo htmlspecialchars($system['issue']); ?></textarea><br>

    <label for="description">Description</label>
    <textarea name="description"><?php echo htmlspecialchars($system['description']); ?></textarea><br>

    <label for="lab_name">Lab Name</label>
    <input type="text" name="lab_name" value="<?php echo htmlspecialchars($system['lab_name']); ?>" required><br>

    <label for="os_installed">Operating System Installed</label>
    <input type="text" name="os_installed" value="<?php echo htmlspecialchars($system['os_installed']); ?>" required><br>

    <label for="ram">RAM</label>
    <input type="text" name="ram" value="<?php echo htmlspecialchars($system['ram']); ?>" required><br>

    <button type="submit">Update System</button>
</form>

        <div class="back">
            <button class="btn btn-outline-primary" onclick="window.location.href='manage_systems.php'">BACK</button>
        </div>
    </main>
</body>
</html>
