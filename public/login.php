<?php
session_start();
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Hash password with MD5

    // Query to check if the admin exists
    $query = "SELECT * FROM admins WHERE username = '$username' LIMIT 1";
    $result = mysqli_query($conn, $query);
    $admin = mysqli_fetch_assoc($result);

    if ($admin && $password == $admin['password']) { // Compare MD5 hashed password
        $_SESSION['admin'] = $admin;

        // Collect session, IP address, and user agent
        $session_id = session_id();
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        // Insert login information into system_log table
        $log_query = "INSERT INTO system_log (username, ip_address, user_agent) 
                      VALUES ('$username', '$ip_address', '$user_agent')";
        mysqli_query($conn, $log_query);

        // Redirect to the admin dashboard
        header('Location: ../admin/dashboard.php');
        exit();
    } else {
        echo '<script>alter("Invalid Credient")</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<style>
        /* Reset some default browser styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        /* Container for the login form */
        .login-container {
            background-color: #fff;
            width: 100%;
            max-width: 400px;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        header {
            text-align: center;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 1.8em;
            color: #333;
            margin-bottom: 10px;
        }

        p {
            font-size: 1em;
            color: #777;
        }

        /* Form styling */
        form {
            display: flex;
            flex-direction: column;
        }

        input[type="text"], input[type="password"] {
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1em;
            transition: border 0.3s;
        }

        input[type="text"]:focus, input[type="password"]:focus {
            border: 1px solid #4CAF50;
            outline: none;
        }

        button {
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            font-size: 1.2em;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #45a049;
        }

        /* Error message styling */
        .error-message {
            color: red;
            text-align: center;
            margin-top: 10px;
            font-size: 1em;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .login-container {
                padding: 20px;
                width: 100%;
                margin: 0 15px;
            }

            h1 {
                font-size: 1.5em;
            }

            button {
                font-size: 1em;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <header>
            <h1>Admin Login</h1>
        </header>
        <main>
            <form method="POST">
                <input type="text" name="username" placeholder="Username" required><br>
                <input type="password" name="password" placeholder="Password" required><br>
                <button type="submit">Login</button>
            </form>
            <!-- Display error message if credentials are invalid -->
            <?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_SESSION['admin'])): ?>
                <div class="error-message">Invalid credentials!</div>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>
