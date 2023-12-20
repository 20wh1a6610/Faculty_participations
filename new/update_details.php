<?php
// Include the database conn file
include('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $faculty_name = $_POST["faculty_name"];
    $designation = $_POST["designation"];
    $qualification = $_POST["qualification"];
    $joining_date = $_POST["joining_date"];
    $resigning_date = $_POST["resigning_date"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    
    // File upload for profile picture
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["profile_picture"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if file already exists
    if (file_exists($targetFile)) {
        // File already exists
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["profile_picture"]["size"] > 5000000) {
        // File size is too large
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg" && $fileType != "gif") {
        // Invalid file format
        $uploadOk = 0;
    }

    if ($uploadOk == 1) {
        // Upload the file
        if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $targetFile)) {
            // File uploaded successfully, update profile picture path in the database
            $profile_picture_path = $targetFile;

            $update_query = "UPDATE faculty_details SET 
                                Designation = '$designation',
                                Qualification = '$qualification',
                                Date_of_Joining = '$joining_date',
                                Date_of_Resigning = '$resigning_date',
                                Phone = '$phone',
                                Email = '$email',
                                Profile_Picture = '$profile_picture_path'
                            WHERE Faculty_Name = '$faculty_name'";

            $result = $conn->query($update_query);
            
            if ($result) {
                // Redirect back to the dashboard after successful update
                header("Location: dashboard.php");
                exit();
            } else {
                // Log the error
                error_log("Error updating faculty details: " . $conn->error);

                // Display an error message
                echo "Error updating faculty details. Please try again later.";
            }
        } else {
            // Display an error message for file upload issues
            echo "Error uploading profile picture. Please check file format and size.";
        }
    }
}
// Close database conn
$conn->close();
?>