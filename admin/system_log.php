<?php
include '../includes/db.php';
include 'header.php';
// Query to fetch the system log data
$query = "SELECT * FROM system_log ORDER BY login_time DESC"; 
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_panel.css">
    <link rel="stylesheet" href="bootstrap.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>System Log</title>
</head>
<body>
    <style>
        /* General styling for the body */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }

        /* Header style */
        h1 {
            text-align: center;
           
            margin-bottom: 20px;
        }

        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Table Header */
        th {
            background-color: #333;
            color: white;
            padding: 12px;
            text-align: left;
            font-size: 16px;
        }

        /* Table Data */
        td {
            background-color: #fff;
            padding: 12px;
            border: 1px solid #ddd;
            color: #555;
            text-align: left;
        }

        /* Hover effect for table rows */
        tr:hover {
            background-color: #f1f1f1;
        }

        /* Border for the table */
        table, th, td {
            border: 1px solid #ddd;
        }

        /* Style for small screens */
        @media screen and (max-width: 768px) {
            table {
                font-size: 14px;
                margin: 10px 0;
            }

            th, td {
                padding: 8px;
            }
        }

    </style>
</head>

    </style>
    <h1>System Login Log</h1>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Login Time</th>
                <th>IP Address</th>
                <th>User Agent</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($log = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $log['id']; ?></td>
                    <td><?php echo $log['username']; ?></td>
                    <td><?php echo $log['login_time']; ?></td>
                    <td><?php echo $log['ip_address']; ?></td>
                    <td><?php echo $log['user_agent']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
