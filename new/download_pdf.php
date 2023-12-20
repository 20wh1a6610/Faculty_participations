<?php
// Check if the pdf parameter is set in the URL
if (isset($_GET['pdf'])) {
    $pdfPath = $_GET['pdf'];

    // Check if the file exists
    if (file_exists($pdfPath) && pathinfo($pdfPath, PATHINFO_EXTENSION) == 'pdf') {
        // Set headers for force download
        header('Content-Description: File Transfer');
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . basename($pdfPath) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($pdfPath));

        // Output the PDF file
        readfile($pdfPath);
        exit;
    } else {
        echo 'Error: File not found or not a PDF. Check the file path: ' . $pdfPath;
    }
} else {
    echo 'Error: PDF parameter not set.';
}
?>
