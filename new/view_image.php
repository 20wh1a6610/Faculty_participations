<?php
// Include your database connection file
include('db_connection.php');

// Check if the pdf parameter is set in the URL
if (isset($_GET['pdf'])) {
    $pdfPath = $_GET['pdf'];

    // Debugging: Output the received parameters
    echo 'PDF Parameter: ' . $pdfPath;

    // Check if the file exists and is a PDF
    if (is_file($pdfPath) && pathinfo($pdfPath, PATHINFO_EXTENSION) === 'pdf') {
        // Output the PDF file
        header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename="' . basename($pdfPath) . '"');
        readfile($pdfPath);
        exit;
    } else {
        echo '<br>Error: File not found or not a PDF. Check the file path: ' . $pdfPath;
    }
} else {
    echo 'Error: PDF parameter not set.';
}

// Close the database connection
$conn->close();
?>
