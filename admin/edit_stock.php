<?php
include '../includes/db.php';
// Check if 'pid' is passed in the URL
if (isset($_GET['pid'])) {
    $pid = intval($_GET['pid']);

    // Fetch the stock item details
    $query = "SELECT * FROM item_stocks WHERE id = $pid";
    $result = mysqli_query($conn, $query);
    $stock_item = mysqli_fetch_assoc($result);

    if (!$stock_item) {
        echo "<p>Stock item not found!</p>";
        exit();
    }

    // Handle the update after form submission
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $item_name = $_POST['item_name'];
        $quantity = $_POST['quantity'];

        // Update the stock item
        $update_query = "UPDATE item_stocks SET item_name = '$item_name', quantity = $quantity WHERE id = $pid";
        if (mysqli_query($conn, $update_query)) {
            // Redirect back to manage_stocks.php after updating
            header('Location: manage_stocks.php');
            exit();
        } else {
            echo "<p>Error: " . mysqli_error($conn) . "</p>";
        }
    }
} else {
    echo "<p>Invalid request. Product ID is missing.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Stock</title>
    <link rel="stylesheet" href="admin_panel.css">
    <link rel="stylesheet" href="bootstrap.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <style>
        /* General body and page styling */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f9;
    margin: 0;
    padding: 0;
}

/* Main container */
main {
    max-width: 800px;
    margin: 50px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

/* Heading styling */
h1 {
    font-size: 2rem;
    color: #333;
    margin-bottom: 20px;
    text-align: center;
}

/* Form labels and inputs styling */
label {
    font-size: 1rem;
    color: #555;
    display: block;
    margin: 10px 0 5px;
}

/* Input fields styling */
input[type="text"],
input[type="number"] {
    width: 100%;
    padding: 10px;
    font-size: 1rem;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-bottom: 20px;
}

/* Submit button styling */
button[type="submit"] {
    background-color: #4CAF50;
    color: #fff;
    padding: 10px 20px;
    font-size: 1rem;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button[type="submit"]:hover {
    background-color: #45a049;
}

/* Link styling for Back to Stock List */
a {
    display: inline-block;
    margin-top: 20px;
    font-size: 1rem;
    color: #007bff;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

/* Footer styling */
footer {
    text-align: center;
    padding: 10px 0;
    background-color: #333;
    color: #fff;
    margin-top: 40px;
}

    </style>
    <main>
        <h1>Edit Stock Item</h1>

        <!-- Edit Stock Form -->
        <form method="POST">
            <label for="item_name">Item Name</label>
            <input type="text" name="item_name" value="<?php echo htmlspecialchars($stock_item['item_name']); ?>" required><br>

            <label for="quantity">Quantity</label>
            <input type="number" name="quantity" value="<?php echo htmlspecialchars($stock_item['quantity']); ?>" required><br>

            <button type="submit">Update Item</button>
        </form>

        <a href="manage_stocks.php">Back to Stock List</a>
    </main>

    <footer>
        <p>&copy; 2024 Computer Lab Management</p>
    </footer>

</body>
</html>
