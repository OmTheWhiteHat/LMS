<?php
include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Item Stocks</title>
    <link rel="stylesheet" href="admin_panel.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <style>
        /* General body and main container styling */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f0f4f8;
    margin: 0;
    padding: 0;
    color: #333;
}

main {
    max-width: 100%;
    margin: 50px auto;
    padding: 20px 50px;
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

/* Heading styles */
h1 {
    text-align: center;
    font-size: 2.5rem;
    color: #2c3e50;
    margin-bottom: 30px;
}

/* Form styling */
form {
    margin-bottom: 20px;
    padding: 10px;
    background-color: #f9f9f9;
    border-radius: 8px;
    border: 1px solid #ddd;
}

form label {
    display: block;
    margin-bottom: 8px;
    font-size: 1rem;
    color: #555;
}

form input[type="text"],
form input[type="number"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 1rem;
}

form button[type="submit"] {
    background-color:  #4CAF50;
    color: white;
    padding: 10px 20px;
    font-size: 1rem;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

form button[type="submit"]:hover {
    background-color:rgb(36, 161, 41);
}

/* Search box styling */
#search {
    width: 100%;
    padding: 12px;
    font-size: 1rem;
    border: 1px solid #ccc;
    border-radius: 5px;
}

/* Table styling */
#table-container table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    font-size: 1rem;
}

#table-container th,
#table-container td {
    padding: 12px 15px;
    border: 1px solid #ddd;
    text-align: left;
}

#table-container th {
    background-color:  #4CAF50;
    color: white;
    font-weight: bold;
}

#table-container td {
    background-color: #f9f9f9;
}

#table-container tr:nth-child(even) td {
    background-color: #f1f1f1;
}

/* Action links styling */
#table-container a {
    color: #3498db;
    text-decoration: none;
    font-weight: bold;
}

#table-container a:hover {
    text-decoration: underline;
}

/* Footer styling */
footer {
    text-align: center;
    padding: 20px 0;
    background-color: #2c3e50;
    color: white;
    margin-top: 40px;
    font-size: 0.9rem;
}

    </style>
    <main>
        <h1>Manage Item Stocks</h1>

        <!-- Add New Stock Form -->
        <form method="POST" style="margin-bottom: 20px;">
            <label for="item_name">Item Name</label>
            <input type="text" name="item_name" required><br>

            <label for="quantity">Quantity</label>
            <input type="number" name="quantity" required><br>

            <button type="submit">Add Item</button>
        </form>

        <!-- Search Box -->
        <div style="margin-bottom: 20px;">
            <input type="text" id="search" placeholder="Search for stocks..." style="width: 100%; padding: 10px;">
        </div>

        <!-- Stock Table -->
        <div id="table-container">
            <!-- Table will be dynamically loaded here -->
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Computer Lab Management</p>
    </footer>

    <script>
        // Function to fetch stock data
        function fetchStockData(query = '') {
            $.ajax({
                url: 'fetch_stocks.php', // PHP script to fetch data
                method: 'POST',
                data: { search: query },
                success: function(data) {
                    $('#table-container').html(data); // Load data into table container
                }
            });
        }

        // Initial load of stock data
        fetchStockData();

        // Live search functionality
        $('#search').on('input', function() {
            const query = $(this).val();
            fetchStockData(query); // Fetch stocks based on search input
        });
    </script>
</body>
</html>
