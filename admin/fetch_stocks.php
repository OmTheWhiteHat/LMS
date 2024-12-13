<?php
include '../includes/db.php'; // Replace with your database connection file

$search = "";
if (isset($_POST['search'])) {
    $search = mysqli_real_escape_string($conn, $_POST['search']);
}

// Query to fetch stock items
$query = "SELECT * FROM item_stocks";
if (!empty($search)) {
    $query .= " WHERE item_name LIKE '%$search%' OR quantity LIKE '%$search%'";
}
$query .= " ORDER BY id DESC";

$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    echo '<table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>';
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>
                <td>' . $row['id'] . '</td>
                <td>' . $row['item_name'] . '</td>
                <td>' . $row['quantity'] . '</td>
                <td>
                    <a href="edit_stock.php?pid=' . $row['id'] . '"><i class="bx bx-edit-alt"></i> Edit</a> | 
                    <a href="manage_stocks.php?delete_id=' . $row['id'] . '" onclick="return confirm(\'Are you sure you want to delete this stock item?\');"><i class="bx bx-folder-minus"></i> Delete</a>
                </td>
              </tr>';
    }
    echo '</tbody></table>';
} else {
    echo '<p>No stock items found.</p>';
}
?>
