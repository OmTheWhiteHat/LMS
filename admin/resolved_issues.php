<?php
include 'header.php';  // Include the header (navigation, etc.)
include '../includes/db.php'; // Include database connection

// Handling the form submission for adding or updating a resolved issue
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $system_id = $_POST['system_id'];
    $issue_description = $_POST['issue_description'];
    $resolution_details = $_POST['resolution_details'];

    // Check if we're updating an existing issue or inserting a new one
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        // Update existing issue
        $id = $_POST['id'];
        $sql = "UPDATE resolved_issues 
                SET system_id = '$system_id', issue_description = '$issue_description', resolution_details = '$resolution_details'
                WHERE id = '$id'";

        if ($conn->query($sql) === TRUE) {
            echo "Resolved issue updated successfully.";
            // Redirect to the resolved issues list page
            header("Location: resolved_issues.php");
            exit; // Ensure script stops after the redirect
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        // Insert new resolved issue
        $sql = "INSERT INTO resolved_issues (system_id, issue_description, resolution_details)
                VALUES ('$system_id', '$issue_description', '$resolution_details')";

        if ($conn->query($sql) === TRUE) {
            echo "New resolved issue added successfully.";
            // Redirect to the resolved issues list page
            header("Location: resolved_issues.php");
            exit; // Ensure script stops after the redirect
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Fetch resolved issues with system details
$sql = "SELECT r.id, r.issue_description, r.resolution_details, r.resolution_date, s.id as system_id
        FROM resolved_issues r
        JOIN systems s ON r.system_id = s.id";
$result = $conn->query($sql);

// Handling the case where we need to edit an existing issue
$edit_issue = null;
if (isset($_GET['id'])) {
    $edit_id = $_GET['id'];
    $sql_edit = "SELECT * FROM resolved_issues WHERE id = '$edit_id'";
    $edit_result = $conn->query($sql_edit);
    if ($edit_result->num_rows > 0) {
        $edit_issue = $edit_result->fetch_assoc();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resolved Issues</title>
    <link rel="stylesheet" href="admin_panel.css">
    <link rel="stylesheet" href="bootstrap.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        /* Add your custom styles here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            padding: 20px;
        }
        h1 {
            text-align: center;
            font-size: 30px;
            margin-bottom: 30px;
            color: #4CAF50;
        }
        #resolved-issues-container {
            margin: 0 auto;
            max-width: 90%;
            overflow-x: auto;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        td a {
            color: #4CAF50;
            text-decoration: none;
        }
        td a:hover {
            text-decoration: underline;
        }
        form {
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 8px;
            margin-top: 30px;
        }
        label {
            font-size: 16px;
            margin-bottom: 10px;
            display: block;
        }
        select, textarea, button {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            margin-bottom: 20px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }
        button {
            background-color: #28a745;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <main>
        <h1>Resolved Issues</h1>

        <!-- Table to display resolved issues -->
        <div id="resolved-issues-container">
            <table>
                <thead>
                    <tr>
                        <th>System ID</th>
                        <th>Issue Description</th>
                        <th>Resolution Details</th>
                        <th>Resolution Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . $row['system_id'] . "</td>
                                    <td>" . $row['issue_description'] . "</td>
                                    <td>" . $row['resolution_details'] . "</td>
                                    <td>" . $row['resolution_date'] . "</td>
                                    <td><a href='?id=" . $row['id'] . "'><i class='bx bx-edit-alt'></i> Edit</a>&nbsp;|&nbsp;<a href='view_resolved_issue.php?id=" . $row['id'] . "'><i class='bx bx-file'></i> View</a></td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No resolved issues found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <br>
        <h1><?php echo $edit_issue ? 'Edit Resolved Issue' : 'Add Resolved Issue'; ?></h1>

        <!-- Form for adding or updating resolved issues -->
        <form method="POST">
            <?php if ($edit_issue): ?>
                <input type="hidden" name="id" value="<?php echo $edit_issue['id']; ?>">
            <?php endif; ?>
            <label for="system_id">System ID (Select System):</label>
            <select id="system_id" name="system_id" required>
                <option value="" disabled <?php echo !$edit_issue ? 'selected' : ''; ?>>Select a System</option>
                <?php
                // Fetch systems from the systems table
                $sql = "SELECT id, cpu_id, monitor_id, ups_id FROM systems";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "' " . ($edit_issue && $edit_issue['system_id'] == $row['id'] ? 'selected' : '') . ">" . 
                             "CPU: " . $row['cpu_id'] . " | " . 
                             "Monitor: " . $row['monitor_id'] . " | " . 
                             "UPS: " . $row['ups_id'] . 
                             "</option>";
                    }
                } else {
                    echo "<option value=''>No systems available</option>";
                }
                ?>
            </select>

            <label for="issue_description">Issue Description:</label>
            <textarea id="issue_description" name="issue_description" required><?php echo $edit_issue ? $edit_issue['issue_description'] : ''; ?></textarea>

            <label for="resolution_details">Resolution Details:</label>
            <textarea id="resolution_details" name="resolution_details" required><?php echo $edit_issue ? $edit_issue['resolution_details'] : ''; ?></textarea>

            <button type="submit"><?php echo $edit_issue ? 'Update' : 'Submit'; ?></button>
        </form>
    </main>

    <?php
    // Close the database connection at the very end of the script
    $conn->close();
    ?>
</body>
</html>
