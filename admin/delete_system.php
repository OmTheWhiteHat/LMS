<?php
include '../includes/db.php'; // Replace with your database connection file

// Check if the 'delete_id' parameter is passed via GET
if (isset($_GET['delete_id'])) {
    $delete_id = mysqli_real_escape_string($conn, $_GET['delete_id']);
    
    // First, fetch the image path from the database
    $query = "SELECT image FROM systems WHERE id = '$delete_id'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        // Get the image path
        $row = mysqli_fetch_assoc($result);
        $image_path = $row['image'];
        
        // Delete the system record from the database
        $delete_query = "DELETE FROM systems WHERE id = '$delete_id'";
        if (mysqli_query($conn, $delete_query)) {
            // If the system was deleted successfully, check if the image exists and delete it
            if (!empty($image_path) && file_exists($image_path)) {
                unlink($image_path); // Delete the image from the server
            }

            // Redirect to the management page with a success message
            header('Location: manage_systems.php?status=deleted');
            exit();
        } else {
            echo '<p>Error deleting system: ' . mysqli_error($conn) . '</p>';
        }
    } else {
        echo '<p>System not found.</p>';
    }
} else {
    echo '<p>No system selected for deletion.</p>';
}
?>
