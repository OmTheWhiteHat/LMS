<?php
include 'header.php';

// Fetch all admins
$query = "SELECT * FROM admins";
$result = mysqli_query($conn, $query);

// Handle Admin Deletion
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $delete_query = "DELETE FROM admins WHERE id = $delete_id";
    if (mysqli_query($conn, $delete_query)) {
        header('Location: manage_admin.php'); // Reload the page after deletion
        exit();
    } else {
        echo "<p>Error: " . mysqli_error($conn) . "</p>";
    }
}

// Handle Add New Admin
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_admin'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $role = $_POST['role'];

    $insert_query = "INSERT INTO admins (username, password, role) VALUES ('$username', '$password', '$role')";
    mysqli_query($conn, $insert_query);
    header('Location: manage_admin.php');
    exit();
}

// Handle Admin Update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_admin'])) {
    $admin_id = intval($_POST['admin_id']);
    $username = $_POST['username'];
    $role = $_POST['role'];

    // Only update the password if a new one is provided
    if (!empty($_POST['password'])) {
        $password = md5($_POST['password']);
        $update_query = "UPDATE admins SET username = '$username', password = '$password', role = '$role' WHERE id = $admin_id";
    } else {
        $update_query = "UPDATE admins SET username = '$username', role = '$role' WHERE id = $admin_id";
    }

    mysqli_query($conn, $update_query);
    header('Location: manage_admin.php');
    exit();
}

// Fetch Admin Data for Editing
$edit_admin = null;
if (isset($_GET['edit_id'])) {
    $edit_id = intval($_GET['edit_id']);
    $edit_query = "SELECT * FROM admins WHERE id = $edit_id";
    $edit_result = mysqli_query($conn, $edit_query);
    $edit_admin = mysqli_fetch_assoc($edit_result);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Admins</title>
    <link rel="stylesheet" href="admin_panel.css">
    <link rel="stylesheet" href="bootstrap.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <style>
        /* General styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
    margin: 0;
    padding: 0;
}

main {
    width: 90%;
    max-width: 1200px;
    margin: 20px auto;
    background-color: #ffffff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

h1, h2 {
    color: #343a40;
    font-size: 24px;
    margin-bottom: 20px;
    text-align: center;
}

form {
    margin-bottom: 30px;
    padding: 20px;
    background-color: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 8px;
}

label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #495057;
}

input[type="text"], input[type="password"], select {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    margin-bottom: 15px;
    border: 1px solid #ced4da;
    border-radius: 5px;
}

button {
    padding: 10px 20px;
    font-size: 16px;
    font-weight: bold;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #4CAF50;
}

/* Table styles */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table th, table td {
    padding: 12px 15px;
    text-align: left;
    border-bottom: 1px solid #dee2e6;
}

table th {
    background-color: #e9ecef;
    font-size: 16px;
    color: #495057;
    text-transform: uppercase;
}

table tr:hover {
    background-color: #f1f1f1;
}

a {
    color: #4CAF50;
    text-decoration: none;
    font-weight: 500;
}

a:hover {
    text-decoration: underline;
}

/* Responsive styles */
@media (max-width: 768px) {
    main {
        width: 95%;
    }

    table {
        font-size: 14px;
    }

    form {
        padding: 15px;
    }

    input[type="text"], input[type="password"], select {
        font-size: 14px;
    }

    button {
        font-size: 14px;
    }
}

    </style>
    <main>
        <h1>Manage Admins</h1>

        <!-- Add or Update Admin Form -->
        <form method="POST">
            <?php if ($edit_admin): ?>
                <input type="hidden" name="admin_id" value="<?php echo $edit_admin['id']; ?>">
                <h2>Edit Admin</h2>
            <?php else: ?>
                <h2>Add New Admin</h2>
            <?php endif; ?>

            <label for="username">Username</label>
            <input type="text" name="username" value="<?php echo $edit_admin['username'] ?? ''; ?>" required><br>

            <label for="password">Password <?php echo $edit_admin ? '(Leave blank to keep current password)' : ''; ?></label>
            <input type="password" name="password"><br>

            <label for="role">Role</label>
            <select name="role">
                <option value="Admin" <?php echo isset($edit_admin) && $edit_admin['role'] === 'Admin' ? 'selected' : ''; ?>>Admin</option>
                <option value="Manager" <?php echo isset($edit_admin) && $edit_admin['role'] === 'Manager' ? 'selected' : ''; ?>>Manager</option>
            </select><br>

            <button type="submit" name="<?php echo $edit_admin ? 'update_admin' : 'add_admin'; ?>">
                <?php echo $edit_admin ? 'Update Admin' : 'Add Admin'; ?>
            </button>
        </form>

        <!-- Existing Admins Table -->
        <h2>Existing Admins</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($admin = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $admin['id']; ?></td>
                        <td><?php echo $admin['username']; ?></td>
                        <td><?php echo $admin['role']; ?></td>
                        <td>
                            <a href="?edit_id=<?php echo $admin['id']; ?>">Edit</a> | 
                            <a href="?delete_id=<?php echo $admin['id']; ?>" onclick="return confirm('Are you sure you want to delete this admin?');">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </main>
</body>
</html>
