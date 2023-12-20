<?php
// Start the session
session_start();

// Destroy all session data
session_destroy();

// Redirect to the login page or any other desired page after logout
header("Location: completefirst.php");
exit();
?>
