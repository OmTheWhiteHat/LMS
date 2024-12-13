<?php  
include 'header.php';

// Fetch systems information
$query = "SELECT * FROM systems";
$result = mysqli_query($conn, $query);

// Handle system status update (without file upload)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    // Get the system_id and status
    $system_id = mysqli_real_escape_string($conn, $_POST['system_id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Check if the system_id exists in the systems table
    $check_system_query = "SELECT id FROM systems WHERE id = '$system_id'";
    $check_system_result = mysqli_query($conn, $check_system_query);

    if (mysqli_num_rows($check_system_result) > 0) {
        // Insert the new system status
        $status_query = "INSERT INTO system_status (system_id, status, last_updated) 
                         VALUES ('$system_id', '$status', NOW())";
        if (mysqli_query($conn, $status_query)) {
            echo "<p>Status updated successfully!</p>";
            // Redirect to reload the page
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit(); // Make sure to call exit() after header to stop further script execution
        } else {
            echo "<p>Error updating status: " . mysqli_error($conn) . "</p>";
        }
    } else {
        echo "<p>Error: Invalid system ID.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Devices</title>
    <link rel="stylesheet" href="admin_panel.css">
    <link rel="stylesheet" href="bootstrap.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
<style>
    /* Admin Panel Styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f9;
    color: #333;
    margin: 0;
    padding: 0;
}

main {
    padding: 20px;
    max-width: 1200px;
    margin: 0 auto;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    color: #4CAF50;
    margin-bottom: 20px;
}

h2 {
    color: #333;
    margin-bottom: 15px;
    font-size: 1.2em;
}

form {
    margin-bottom: 30px;
}

label {
    font-size: 1em;
    font-weight: bold;
    margin-bottom: 5px;
    display: inline-block;
}

select, button {
    width: 100%;
    padding: 10px;
    margin: 8px 0 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 1em;
}

button {
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #45a049;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table th, table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

table th {
    background-color: #4CAF50;
    color: white;
}

table tr:nth-child(even) {
    background-color: #f9f9f9;
}

table tr:hover {
    background-color: #f1f1f1;
}

footer {
    text-align: center;
    padding: 10px;
    background-color: #333;
    color: white;
    margin-top: 20px;
}

footer p {
    margin: 0;
}

@media (max-width: 768px) {
    main {
        padding: 15px;
    }

    table th, table td {
        padding: 8px;
    }

    form label, form select, form button {
        font-size: 0.9em;
    }
}

</style>
    <main>
        <h1>Manage Devices</h1>
        
        <!-- Form to update system status without file upload -->
        <h2>Update System Status</h2>
        <form method="POST">
            <label for="system_id">Select System</label>
            <select name="system_id" required>
                <?php
                // Populate the systems dropdown
                $systems_result = mysqli_query($conn, $query);
                while ($system = mysqli_fetch_assoc($systems_result)) {
                    echo "<option value='" . $system['id'] . "'>" . $system['cpu_id'] . " - " . $system['ups_id'] . " - " . $system['monitor_id'] . "</option>";
                }
                ?>
            </select><br>

            <label for="status">Status</label>
            <select name="status" required>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
                <option value="Maintenance">Maintenance</option>
                <option value="Fault">Fault</option>
            </select><br>

            <button type="submit" name="update_status"><i class='bx bx-edit-alt'></i> Update Status</button>
        </form>

        <h2>Current Device Status</h2>
        <table>
            <thead>
                <tr>
                    <th>IMAGE</th>
                    <th>ID</th>
                    <th>System ID</th>
                    <th>CPU ID</th> <!-- New column for CPU_ID -->
                    <th>Status</th>
                    <th>Last Update</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($system = mysqli_fetch_assoc($result)) { 
                    // Get the latest status for each system
                    $status_query = "SELECT * FROM system_status WHERE system_id = " . $system['id'] . " ORDER BY last_updated DESC LIMIT 1";
                    $status_result = mysqli_query($conn, $status_query);
                    $status = mysqli_fetch_assoc($status_result);

                    // Check if there's a valid status entry
                    if ($status) {
                        $status_text = $status['status'];
                        $last_updated = $status['last_updated'];
                    } else {
                        $status_text = 'No status available';
                        $last_updated = 'N/A';
                    }
                    ?>
                    <tr>
                        <?php echo '<td><img src="' . htmlspecialchars($system['image']) . '" alt="System Image" style="width: 100px; height: auto;"></td>'; ?>
                        <td><?php echo $system['id']; ?></td>
                        <td><?php echo $system['ups_id']; ?> - <?php echo $system['monitor_id']; ?></td>
                        <td><?php echo $system['cpu_id']; ?></td> <!-- Display CPU_ID -->
                        <td><?php echo $status_text; ?></td>
                        <td><?php echo $last_updated; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </main>

    <footer>
        <p>&copy; 2024 Computer Lab Management</p>
    </footer>

</body>
</html>