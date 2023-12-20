<?php
$localhost = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "faculty_db";

# Connection string
$conn = mysqli_connect($localhost, $dbusername, $dbpassword, $dbname);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    # Retrieve form data
    $faculty_name = isset($_POST["faculty_name"]) ? $_POST["faculty_name"] : "";
    $Year = isset($_POST["Year"]) ? $_POST["Year"] : "";
    $event_name = isset($_POST["event_name"]) ? $_POST["event_name"] : "";

    # File upload
    $file_name = isset($_FILES["certificate"]["name"]) ? $_FILES["certificate"]["name"] : "";
    $file_tmp_name = isset($_FILES["certificate"]["tmp_name"]) ? $_FILES["certificate"]["tmp_name"] : "";
    
    // Ensure the 'img' directory exists
    $uploads_dir = 'img';
    if (!is_dir($uploads_dir)) {
        mkdir($uploads_dir, 0777, true);
    }

    $file_path = $uploads_dir . '/' . rand(1000, 10000) . "-" . $file_name;

    if (move_uploaded_file($file_tmp_name, $file_path)) {
        # SQL query to insert into database
        $sql = "INSERT INTO faculty_participations(faculty_name, Year, event_name, file_path) 
                VALUES ('$faculty_name', '$Year', '$event_name','$file_path')";

        if (mysqli_query($conn, $sql)) {
            // File has been successfully uploaded and inserted into the database.
            // Redirect back to dashboard.php after submission
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "File upload failed.";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Participations</title>
    <style>
        body {
            background-image: url('bgimagedash.jpg');
            background-size: cover;
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        h1 {
            text-align: center;
            color: green;
            margin-bottom: 20px;
        }

        .form-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }

        input,
        select,
        file {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <div class="form-container">
        <h1>Faculty Participations</h1>
        <form method="POST" enctype="multipart/form-data">

            <label for="faculty_name">Faculty Name:</label>
            <input type="text" id="faculty_name" name="faculty_name" required>

            <label for="Year">Year:</label>
            <input type="text" id="Year" name="Year" required>

            <label for="event_name">Event Name:</label>
            <input type="text" id="event_name" name="event_name" required>

            <label for="certificate">Upload Certificate:</label>
            <input type="file" id="certificate" name="certificate" required>

            <button type="submit" name="submit">SUBMIT</button>
        </form>
    </div>
</body>

</html>
