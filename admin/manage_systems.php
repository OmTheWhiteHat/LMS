<?php
include 'header.php';
?>
<?php
if (isset($_GET['status']) && $_GET['status'] == 'deleted') {
    echo '<p style="color: green;">System deleted successfully!</p>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Systems</title>
    <link rel="stylesheet" href="admin_panel.css">
    <link rel="stylesheet" href="bootstrap.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<style>
    /* General Styles */
/* General Styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

main {
    width: calc(100% - 50px);
    margin: 20px auto;
    background-color: #fff;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    min-height: 100vh;
}

h1 {
    font-size: 26px;
    color: #333;
    text-align: center;
    margin-bottom: 20px;
    font-weight: bold;
}

h2 {
    font-size: 22px;
    color: #333;
    margin-bottom: 15px;
}

/* Form Styles */
form {
    margin-bottom: 30px;
}

label {
    font-size: 16px;
    color: #333;
    margin-bottom: 5px;
    display: inline-block;
}

input[type="text"], textarea, input[type="file"] {
    width: 100%;
    padding: 12px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-sizing: border-box;
    font-size: 16px;
}

textarea {
    height: 120px;
    resize: vertical;
}

button {
    background-color: #4CAF50;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease;
    display: inline-block;
}

button:hover {
    background-color: #45a049;
}

hr {
    margin: 30px 0;
    border: 1px solid #ddd;
}

a {
    text-decoration: none;
    color: #007BFF;
}

a:hover {
    text-decoration: underline;
}

a:active {
    color: #0056b3;
}

button.delete {
    background-color: #e74c3c;
    padding: 8px 15px;
    border-radius: 5px;
    color: white;
    border: none;
    cursor: pointer;
}

button.delete:hover {
    background-color: #c0392b;
}

/* Table Styles */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    padding: 12px;
    text-align: left;
    border: 1px solid #ddd;
}

th {
    background-color: #f7f7f7;
    color: #333;
    font-weight: bold;
}

td {
    color: #555;
}

img {
    width: 50px;
    height: 50px;
}

/* Responsive Design for Table */
@media (max-width: 768px) {
    /* Allow horizontal scrolling for tables on smaller screens */
    #table-container {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    table {
        font-size: 14px;
        width: 100%;
        table-layout: fixed;
    }

    th, td {
        padding: 10px;
    }

    td {
        word-wrap: break-word;
    }

    th {
        font-size: 14px;
    }

    /* Make buttons and inputs more responsive */
    button {
        width: 100%;
    }

    label, input[type="text"], textarea {
        font-size: 14px;
    }
}

footer {
    text-align: center;
    padding: 10px;
    background-color: #333;
    color: #fff;
    position: absolute;
    bottom: 0;
    width: 100%;
}

footer p {
    margin: 0;
    font-size: 14px;
}

</style>
<main>
    <h1>Manage Systems</h1>

    <!-- Button to Add New System -->
    <div style="margin-bottom: 20px; text-align: center;">
        <a href="add_system.php">
            <button type="button">Add New System</button>
        </a>
    </div>

    <!-- Search Box -->
    <div style="margin-bottom: 20px;">
        <input type="text" id="search" placeholder="Search..." style="width: 100%; padding: 10px;">
    </div>

    <!-- Table for Display -->
    <div id="table-container" class="container-fluid">
        <!-- Table will be dynamically loaded here -->
    </div>
</main>

<script>
    // Function to fetch data
    function fetchData(query = '') {
        $.ajax({
            url: 'fetch_systems.php', // PHP script to fetch data
            method: 'POST',
            data: {search: query},
            success: function(data) {
                $('#table-container').html(data); // Load data into the table container
            }
        });
    }

    // Call fetchData initially to load all systems
    fetchData();

    // Live Search
    $('#search').on('input', function() {
        const query = $(this).val();
        fetchData(query); // Fetch data based on user input
    });
</script>
</body>
</html>
