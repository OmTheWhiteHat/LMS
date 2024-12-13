<?php
include '../includes/db.php'; // Include database connection

// Check if the 'id' parameter exists in the URL
if (isset($_GET['id'])) {
    $resolved_issue_id = $_GET['id'];

    // Fetch the resolved issue details from the database
    $sql = "SELECT r.id, r.issue_description, r.resolution_details, r.resolution_date, r.system_id, s.cpu_id, s.monitor_id, s.ups_id
            FROM resolved_issues r
            JOIN systems s ON r.system_id = s.id
            WHERE r.id = $resolved_issue_id";
    $result = $conn->query($sql);

    // Check if the issue exists
    if ($result->num_rows > 0) {
        $resolved_issue = $result->fetch_assoc();
    } else {
        echo "No resolved issue found.";
        exit();
    }
} else {
    echo "No issue ID provided.";
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Resolved Issue</title>
    <link rel="stylesheet" href="admin_panel.css">
    <link rel="stylesheet" href="bootstrap.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <style>
        /* Add your custom styles here */
        .resolved-issue-details {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f4f4f4;
            color: #000;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .resolved-issue-details h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .resolved-issue-details p {
            font-size: 18px;
            line-height: 1.6;
        }
        .resolved-issue-details .label {
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <main>
        <div class="resolved-issue-details">
            <h2>Resolved Issue Details</h2>
            <p><span class="label">System ID:</span> <?php echo $resolved_issue['system_id']; ?></p>
            <p><span class="label">CPU:</span> <?php echo $resolved_issue['cpu_id']; ?></p>
            <p><span class="label">Monitor:</span> <?php echo $resolved_issue['monitor_id']; ?></p>
            <p><span class="label">UPS:</span> <?php echo $resolved_issue['ups_id']; ?></p>

            <p><span class="label">Issue Description:</span> <?php echo $resolved_issue['issue_description']; ?></p>
            <p><span class="label">Resolution Details:</span> <?php echo $resolved_issue['resolution_details']; ?></p>
            <p><span class="label">Resolution Date:</span> <?php echo $resolved_issue['resolution_date']; ?></p>
            <div>
                <a href="resolved_issues.php"><button class="btn btn-outline-success">GO BACK</button></a>
            </div>
        </div>
        
    </main>

    <?php
    // Close the database connection
    $conn->close();
    ?>
</body>
</html>
