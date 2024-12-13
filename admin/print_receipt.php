<?php
// Include necessary files
include '../includes/db.php'; 
include 'header.php'; // Include the database connection

// Retrieve receipt data from the database
$query = "SELECT * FROM receipts ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    // Get the form data
    $id_name = mysqli_real_escape_string($conn, $_POST['id_name']);
    $quantity = intval($_POST['quantity']);
    $total_amount = floatval($_POST['total_amount']);

    // Insert the data into the receipt table
    $query = "INSERT INTO receipt (id_name, quantity, total_amount) 
              VALUES ('$id_name', $quantity, $total_amount)";

    if (mysqli_query($conn, $query)) {
        echo "<p>Receipt submitted successfully!</p>";
        echo "<a href='receipt_form.php'>Go back to the form</a>"; // Redirect to the form again
    } else {
        echo "<p>Error submitting receipt: " . mysqli_error($conn) . "</p>";
    }
}

// Handle deletion
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $delete_query = "DELETE FROM receipts WHERE id = $delete_id";
    if (mysqli_query($conn, $delete_query)) {
        echo "<p>Receipt deleted successfully.</p>";
        echo "<a href='receipt_form.php'>Go back to receipts list</a>";
    } else {
        echo "<p>Error deleting receipt: " . mysqli_error($conn) . "</p>";
    }
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
    <title>Receipt Management</title>
    <style>
        /* Global Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }

        .main-content {
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #4CAF50;
            text-align: center;
            margin-bottom: 20px;
        }

        p {
            text-align: center;
            margin-bottom: 30px;
            font-size: 1.1em;
            color: #666;
        }

        label {
            font-size: 1.1em;
            margin-bottom: 8px;
            display: block;
            color: #333;
        }

        input, button {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            font-size: 1em;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        input:focus, button:focus {
            outline: none;
            border-color: #4CAF50;
        }

        button {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        thead {
            background-color: #4CAF50;
            color: white;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tbody tr:hover {
            background-color: #f1f1f1;
        }

        .action-btn {
            padding: 8px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9em;
        }

        .action-btn:hover {
            background-color: #45a049;
        }

        .delete-btn {
            padding: 8px 15px;
            background-color: #f44336;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9em;
        }

        .delete-btn:hover {
            background-color: #e53935;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-content {
                padding: 15px;
            }

            table {
                font-size: 0.9em;
            }

            button {
                font-size: 0.9em;
            }
        }
    </style>
</head>
<body>
    <div class="main-content">
        <h1>Receipt Form</h1>
        <form method="POST" action="process_receipt.php">
            <label for="id_name">Item Name</label>
            <input type="text" id="id_name" name="id_name" required><br>

            <label for="quantity">Quantity</label>
            <input type="number" id="quantity" name="quantity" required><br>

            <label for="total_amount">Total Amount</label>
            <input type="number" id="total_amount" name="total_amount" step="0.01" required><br>

            <button type="submit" name="submit">Submit Receipt</button>
        </form>

        <h1>Receipts List</h1>
        <p>Select a receipt to print or view its details.</p>

        <!-- Table of receipts -->
        <table>
            <thead>
                <tr>
                    <th>Receipt ID</th>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Total Amount</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['item_name']; ?></td>
                            <td><?php echo $row['quantity']; ?></td>
                            <td><?php echo $row['total_amount']; ?> INR</td>
                            <td><?php echo date('Y-m-d H:i:s', strtotime($row['created_at'])); ?></td>
                            <td>
                                <button class="action-btn" onclick="printReceipt(<?php echo $row['id']; ?>)">Print</button>
                                <a href="receipt_form.php?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this receipt?')">
                                    <button class="delete-btn">Delete</button>
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">No receipts available.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script>
        // JavaScript function to handle receipt printing
        function printReceipt(receiptId) {
            const printWindow = window.open(`print_receipt_template.php?id=${receiptId}`, '_blank');
            printWindow.print();
        }
    </script>
</body>
</html>
