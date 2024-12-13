<?php
// Include necessary files
include '../includes/db.php'; // Database connection
session_start();

// Check if the user is logged in
if (!isset($_SESSION['admin'])) {
    header('Location: ../public/login.php');
    exit();
}

// Get the receipt ID from the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Receipt ID is missing.");
}

$receipt_id = intval($_GET['id']);

// Fetch receipt details from the database
$query = "SELECT * FROM receipts WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $receipt_id);
$stmt->execute();
$result = $stmt->get_result();
$receipt = $result->fetch_assoc();

if (!$receipt) {
    die("Receipt not found.");
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt #<?php echo $receipt['id']; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f9;
        }

        .receipt-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #4CAF50;
        }

        .receipt-details {
            margin-top: 20px;
        }

        .receipt-details p {
            margin: 5px 0;
            font-size: 1.1em;
            color: #333;
        }

        .print-btn {
            display: block;
            width: 100px;
            margin: 20px auto;
            padding: 10px;
            text-align: center;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .print-btn:hover {
            background: #45a049;
        }

        @media print {
            .print-btn {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <h1>Receipt</h1>
        <div class="receipt-details">
            <p><strong>Receipt ID:</strong> <?php echo $receipt['id']; ?></p>
            <p><strong>Item Name:</strong> <?php echo htmlspecialchars($receipt['item_name']); ?></p>
            <p><strong>Quantity:</strong> <?php echo $receipt['quantity']; ?></p>
            <p><strong>Total Amount:</strong> <?php echo $receipt['total_amount']; ?> INR</p>
            <p><strong>Date:</strong> <?php echo date('Y-m-d H:i:s', strtotime($receipt['created_at'])); ?></p>
        </div>
        <button class="print-btn" onclick="window.print()">Print</button>
    </div>
</body>
</html>
