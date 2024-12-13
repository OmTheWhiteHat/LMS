<?php 
session_start(); // Ensure the session is started
include '../includes/db.php';
// Check if the user is logged in
if (!isset($_SESSION['admin'])) {
    header('Location: ../public/login.php');
    exit();
}
// Example of using `$_SESSION['admin']` safely
$admin = isset($_SESSION['admin']) ? $_SESSION['admin'] : null;

if ($admin === null) {
    // Optionally log or handle missing admin details
    error_log("Admin session variable is null");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_panel.css">
    <link rel="stylesheet" href="bootstrap.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Iceberg&display=swap" rel="stylesheet">
    <title>Admin | Panel</title>
</head>
<body>
<header>
    <headmain class="main-header">
        <h1>Welcome to lms - <span><?php echo $_SESSION['admin']['username']; ?></span> 😊</h1>
    </headmain>
</header>
<style>
   div.col {
       margin: 30px 0;
   }
   div.col a button {
       width: 100%; /* Set the button width to 100% */
       padding: 0px 20px; /* Adjust padding to ensure the button looks good */
       height: 70px;
       font-weight: 600;
       background: rgba(0,0,0,0.7);
       border-radius: 15px;
       color: white;
       
   }
   .main-header h1 {
       font-size: 40px;
       font-family: "Iceberg", sans-serif;
       font-weight: 400;
       text-transform: uppercase;
       font-style: normal;
       padding: 0px 50px;
       color: rgb(0, 209, 87);
       text-align: center;
       border-radius: 40px;
   }
   
   .main-header h1 span {
       color: rgb(0, 185, 218);
   }
</style>

<div class="container text-center">
    <div class="row">
        <div class="col"><a href="manage_devices.php"><button class="menu_btn btn btn-outline-primary">Manage Devices</button></a></div>
        <div class="col"><a href="system_log.php"><button class="menu_btn btn btn-outline-warning">System Log</button></a></div>
        <div class="col"><a href="print_receipt.php"><button class="menu_btn btn btn-outline-primary">Print Receipt</button></a></div>
        <div class="col"><a href="manage_systems.php"><button class="menu_btn btn btn-outline-success">Manage Systems</button></a></div>
        <!-- <div class="col"><a href="manage_admin.php"><button class="menu_btn btn btn-outline-success">Manage Admins</button></a></div> -->
        <div class="col"><a href="manage_stocks.php"><button class="menu_btn btn btn-outline-success">Manage Stocks</button></a></div>
        <div class="col"><a href="resolved_issues.php"><button class="menu_btn btn btn-outline-warning">RESOLVE ISSUE</button></a></div>
        <div class="col"><a href="../public/logout.php"><button class="menu_btn btn btn-outline-danger">Logout</button></a></div>
    </div>
</div>

</body>
</html>
