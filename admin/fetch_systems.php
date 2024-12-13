<?php
include '../includes/db.php'; // Replace with your database connection file

$search = "";
if (isset($_POST['search'])) {
    $search = mysqli_real_escape_string($conn, $_POST['search']);
}

// Query to fetch filtered results
$query = "SELECT * FROM systems";
if (!empty($search)) {
    $query .= " WHERE ups_id LIKE '%$search%'
                OR cpu_id LIKE '%$search%' 
                OR monitor_id LIKE '%$search%' 
                OR internet LIKE '%$search%' 
                OR issue LIKE '%$search%' 
                OR description LIKE '%$search%' 
                OR lab_name LIKE '%$search%' 
                OR os_installed LIKE '%$search%' 
                OR ram LIKE '%$search%'";
}
$query .= " ORDER BY id DESC";

$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    echo '<table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>Image</th>
                    <th>ID</th>
                    <th>CPU ID</th>
                    <th>UPS ID</th>
                    <th>Monitor ID</th>
                    <th>Internet</th>
                    <th>Issue</th>
                    <th>Description</th>
                    <th>Lab Name</th>
                    <th>Operating System</th>
                    <th>RAM</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>';
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>
                <td data-label="Image"><img src="' . htmlspecialchars($row['image']) . '" alt="System Image" style="width: 100px; height: auto;"></td>
                <td data-label="ID">' . htmlspecialchars($row['id']) . '</td>
                <td data-label="CPU ID">' . htmlspecialchars($row['cpu_id']) . '</td>
                <td data-label="UPS ID">' . htmlspecialchars($row['ups_id']) . '</td>
                <td data-label="Monitor ID">' . htmlspecialchars($row['monitor_id']) . '</td>
                <td data-label="Internet">' . htmlspecialchars($row['internet']) . '</td>
                <td data-label="Issue">' . htmlspecialchars($row['issue']) . '</td>
                <td data-label="Description">' . htmlspecialchars($row['description']) . '</td>
                <td data-label="Lab Name">' . htmlspecialchars($row['lab_name']) . '</td>
                <td data-label="Operating System">' . htmlspecialchars($row['os_installed']) . '</td>
                <td data-label="RAM">' . htmlspecialchars($row['ram']) . '</td>
                <td data-label="Actions">
                    <a href="edit_system.php?id=' . htmlspecialchars($row['id']) . '"><i class="bx bx-edit-alt"></i> Edit</a> | 
                    <a href="delete_system.php?delete_id=' . htmlspecialchars($row['id']) . '" onclick="return confirm(\'Are you sure you want to delete this system?\');"><i class="bx bx-folder-minus"></i> Delete</a>
                </td>
              </tr>';
    }
    echo '</tbody></table>';
} else {
    echo '<p>No systems found.</p>';
}
?>