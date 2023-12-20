<?php
// Include your database connection file
include('db_connection.php');

// Retrieve the entered username and password from the form
$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

if (empty($username) || empty($password)) {
    echo "Username and password are required.";
} else {
    // Secure query using prepared statements
    $sql = "SELECT faculty_name FROM faculty_login WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $username, $password);
    $stmt->execute();
    $stmt->bind_result($faculty_name);

    if ($stmt->fetch()) {
        // Redirect to the first page
        header('Location: firstpage.php?faculty_name=' . urlencode($faculty_name));
        exit();
    } else {
        echo "Invalid credentials";
    }

    // Close the prepared statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
