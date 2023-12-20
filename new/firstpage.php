<?php
// Include your database connection file
include('db_connection.php');

// Retrieve faculty_name from the URL
$faculty_name = isset($_GET['faculty_name']) ? $_GET['faculty_name'] : '';

// Display faculty_name on the first page
if (!empty($faculty_name)) {
    echo '<p>Welcome to the first page, ' . $faculty_name . '!</p>';
} else {
    echo 'Invalid access to the first page.';
}

// Close the database connection
$conn->close();
?>
