<?php  
include 'header.php';

// Fetch systems information
$query = "SELECT * FROM systems";
$result = mysqli_query($conn, $query);

// Handle system status update (without file upload)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    // Get the system_id, selected type, and status
    $system_id = mysqli_real_escape_string($conn, $_POST['system_id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $device_type = mysqli_real_escape_string($conn, $_POST['device_type_info']);  // Added device type

    // Check if the system_id exists in the systems table
    $check_system_query = "SELECT id FROM systems WHERE id = '$system_id'";
    $check_system_result = mysqli_query($conn, $check_system_query);

    if (mysqli_num_rows($check_system_result) > 0) {
        // Insert the new system status
        $status_query = "INSERT INTO system_status (system_id, status, device_type, last_updated) 
                         VALUES ('$system_id', '$status', '$device_type', NOW())";  // Include device_type in the query
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

            <label for="device_type_info">Select Device Type</label>
            <select name="device_type_info" required>
                <option value="CPU">CPU</option>
                <option value="UPS">UPS</option>
                <option value="Monitor">Monitor</option>
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
                    <th>SYSTEM ID</th>
                    <th>DEVICE TYPE</th>
                    <th>Status</th>
                    <th>Last Update</th>
                </tr>
            </thead>
            <tbody>
    <?php while ($system = mysqli_fetch_assoc($result)) { 
        // Get all status entries for the current system
        $status_query = "SELECT * FROM system_status WHERE system_id = " . $system['id'] . " ORDER BY last_updated DESC";
        $status_result = mysqli_query($conn, $status_query);
        
        // Initialize status text and last updated time variables
        $status_text = '';
        $last_updated = '';

        // Check if there are any status entries for this system
        if (mysqli_num_rows($status_result) > 0) {
            // Loop through all statuses for this system
            while ($status = mysqli_fetch_assoc($status_result)) {
                // Concatenate status entries for display
                if (isset($status['status'])) {
                    $status_text .= $status['status'] . "<br>";
                } else {
                    $status_text .= "No status available<br>";
                }

                // Concatenate last updated times for display
                if (isset($status['last_updated'])) {
                    $last_updated .= $status['last_updated'] . "<br>";
                } else {
                    $last_updated .= "N/A<br>";
                }
            }
        } else {
            $status_text = 'No status available';
            $last_updated = 'N/A';
        }
    ?>
    <tr>
        <!-- Display system image -->
        <td><img src="<?php echo htmlspecialchars($system['image']); ?>" alt="System Image" style="width: 100px; height: auto;"></td>

        <!-- Display system ID -->
        <td><?php echo $system['id']; ?></td>

        <!-- Display system UPS ID and Monitor ID -->
        <td><?php echo isset($system['system_id']) ? $system['system_id'] : 'No ID'; ?> - <?php echo isset($system['monitor_id']) ? $system['monitor_id'] : 'No Monitor'; ?></td>

        <!-- Display Device Type -->
        <td><?php echo isset($system['device_type']) ? $system['device_type'] : 'No Device Type'; ?></td>

        <!-- Display all statuses for the current system -->
        <td><?php echo nl2br($status_text); ?></td>

        <!-- Display all last updated timestamps for the statuses -->
        <td><?php echo nl2br($last_updated); ?></td>
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
