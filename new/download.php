<?php
// Include your database connection file
include('db_connection.php');

// Check if the image parameter is set in the URL
if (isset($_GET['image'])) {
    $imagePath = $_GET['image'];

    // Check if the file exists
    if (file_exists($imagePath)) {
        // Determine the content type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $contentType = finfo_file($finfo, $imagePath);
        finfo_close($finfo);

        // Set the content type header
        header("Content-Type: $contentType");

        // Set the Content-Disposition header to force download
        header("Content-Disposition: attachment; filename=\"" . basename($imagePath) . "\"");

        // Output the image data to the browser
        readfile($imagePath);
    } else {
        echo 'File not found.';
    }
} else {
    echo 'Error: Image parameter not set.';
}

// Close the database connection
$conn->close();
?>
