<?php
// Include the database connection file
include('db_connection.php');

// Start a new or resume an existing session
session_start();

// Retrieve the faculty_name from the session variable
$faculty_name = $_SESSION['faculty_name'];

// Fetch faculty details from the database
$sql_details = "SELECT * FROM faculty_details WHERE faculty_name = ?";
$stmt_details = $conn->prepare($sql_details);
$stmt_details->bind_param("s", $faculty_name);
$stmt_details->execute();
$result_details = $stmt_details->get_result();

// Define an empty $details array
$details = array();

// Check if faculty details are available
if ($result_details->num_rows > 0) {
    // Define $details only when there are results
    $details = $result_details->fetch_assoc();
}




// Fetch faculty certifications from the database
$sql_years = "SELECT DISTINCT Year FROM faculty_participations WHERE faculty_name = ?";
$stmt_years = $conn->prepare($sql_years);
$stmt_years->bind_param("s", $faculty_name);
$stmt_years->execute();
$result_years = $stmt_years->get_result();

// Define an empty $years array
$years = array();

// Check if faculty years are available
if ($result_years->num_rows > 0) {
    // Define $years only when there are results
    while ($row = $result_years->fetch_assoc()) {
        $years[] = $row['Year'];
    }
}

// Handle adding a new year
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["new_year"])) {
    $new_year = $_POST["new_year"];
    $insert_year_query = "INSERT INTO faculty_participations (faculty_name, Year) VALUES (?, ?)";
    $stmt_insert_year = $conn->prepare($insert_year_query);
    $stmt_insert_year->bind_param("ss", $faculty_name, $new_year);
    $stmt_insert_year->execute();
}

// Handle file upload
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["year"])) {
    $year = $_POST["year"];
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["certificate"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if file already exists
    if (file_exists($targetFile)) {
        // File already exists
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["certificate"]["size"] > 5000000) {
        // File size is too large
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg" && $fileType != "gif" && $fileType != "pdf") {
        // Invalid file format
        $uploadOk = 0;
    }

    if ($uploadOk == 1) {
        // Upload the file
        if (move_uploaded_file($_FILES["certificate"]["tmp_name"], $targetFile)) {
            // File uploaded successfully, insert into database
            $insert_query = "INSERT INTO faculty_participations (faculty_name, Year, Certificate) VALUES (?, ?, ?)";
            $stmt_insert = $conn->prepare($insert_query);
            $stmt_insert->bind_param("sss", $faculty_name, $year, $targetFile);
            $stmt_insert->execute();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
      body {
        background-image: url('bgimagedash.jpg');
            background-size: cover;
            /* background-position: center;
            background-repeat: no-repeat; */
            /* background-color: black; */
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: blue;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
        }

        .heading-box {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: green;
            padding: 10px;
            text-align: right;
        }

        .logout-button {
            background-color: 	lightgreen;
            color: #333;
            border: none;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            cursor: pointer;
            float: right;
            margin-left:1000px;
        }

        #content {
            display: flex;
            flex-direction: row; /* Align content in a row */
            margin-top: 20px;
        }

        #details {
            flex: 1; /* Take up remaining space */
            padding: 0 20px; /* Add padding for spacing */
            text-align: center;
        }

        #details img {
            max-width: 200px;
            max-height: 200px;
            border-radius: 10px;
            margin-top: 10px;
            order: -1; /* Move the image to the start */
        }

        /* #button{
            margin-top: auto; /* Push buttons to the bottom 
            display: flex;
            flex-direction: column; /* Arrange buttons vertically 
            align-items: center; /* Center buttons horizontally 
           
        } */

        #button {
            background-color: #4CAF50;
            color: green;
            padding: 10px;
            margin: 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #formWrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin-top: 75px;
        }

        #editForm {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        #editForm h2 {
            margin-bottom: 15px;
        }

        #editForm form {
            width: 100%;
            max-width: 400px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #editForm label {
            margin-bottom: 10px;
        }

        #editForm input[type="file"],
        #editForm input[type="text"],
        #editForm input[type="date"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        #editForm input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 5px;
            margin: 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

    </style>

</head>
<body>
<div class="heading-box">
 
    <form action="logout.php" method="post">
        <button class="logout-button" type="submit" name="logout">Logout</button>
    </form>
</div>
    <?php
    // Check if faculty details are available
    if (!empty($details)) {
        echo "<div id='details'>";
        if (!empty($details['Profile_Picture'])) {
            echo "<img src='{$details['Profile_Picture']}' alt='Profile Picture' style='max-width: 200px;'>";
        }
        echo "<h1>Welcome, {$details['Faculty_Name']}!</h1>";
        echo "<p>Designation: {$details['Designation']}</p>";
        echo "<p>Qualification: {$details['Qualification']}</p>";
        echo "<p>Date of Joining: {$details['Date_of_Joining']}</p>";
        echo "<p>Date of Resigning: {$details['Date_of_Resigning']}</p>";
        echo "<p>Phone: {$details['Phone']}</p>";
        echo "<p>Email: {$details['Email']}</p>";
        echo "</div>";

        // Add an "Edit" button for faculty details
        echo "<button onclick='toggleEditForm()'>Edit Details</button>";

        // // Display years for certifications
        // if (!empty($years)) {
        //     echo "<h2>Certifications</h2>";
        //     foreach ($years as $year) {
        //         echo "<div id='year_$year'>";
        //         echo "<button onclick='toggleCertifications(\"$year\")'>$year</button>";
        //     }
        // } else {
        //     echo "<p>No certifications found for this faculty.</p>";
        // }
        echo "<button onclick='openDisplayPage()'>View certificates</button>";
        // Add a single button to open display.php
        echo "<button onclick='openEditPage()'>Add/Edit Certificates</button>";

        // Display the form to add or edit certificates
        echo "<div id='editCertificateForm' style='display: none;'>";
        echo "<form method='post' action='' enctype='multipart/form-data'>";
        echo "<input type='hidden' name='faculty_name' value='$faculty_name'>";
        echo "<input type='hidden' id='yearInput' name='year' value=''>";
        echo "<label for='certificate'>Certificate:</label>";
        echo "<input type='file' name='certificate' accept='image/*, application/pdf' required>";
        echo "<input type='submit' value='Add/Edit'>";
        echo "</form>";
        echo "</div>";
    } else {
        echo "<h1>Welcome, $faculty_name!</h1>";
        echo "<p>No faculty details found. You can add them below:</p>";
    }
    ?>
    <div id="formWrapper">
    <div id="editForm" style="display: none;">
        <!-- Add or update faculty details form -->
        <h2>Edit Faculty Details</h2>
            <!-- <form method='post' action='update_details.php'>
            <label for='profile_picture'>Profile Picture:</label>
            <input type='file' name='profile_picture' accept='image/*'> -->

            <form method='post' action='update_details.php' enctype='multipart/form-data'>
            <label for='profile_picture'>Profile Picture:</label>
            <input type='file' name='profile_picture' accept='image/*'>

            <input type='hidden' name='faculty_name' value='<?php echo $faculty_name; ?>'>
            <label for='designation'>Designation:</label>
            <input type='text' name='designation' value='<?php echo $details['Designation'] ?? ''; ?>'>
            <label for='qualification'>Qualification:</label>
            <input type='text' name='qualification' value='<?php echo $details['Qualification'] ?? ''; ?>'>
            <label for='joining_date'>Date of Joining:</label>
            <input type='date' name='joining_date' value='<?php echo $details['Date_of_Joining'] ?? ''; ?>'>
            <label for='resigning_date'>Date of Resigning:</label>
            <input type='date' name='resigning_date' value='<?php echo $details['Date_of_Resigning'] ?? ''; ?>'>
            <label for='phone'>Phone:</label>
            <input type='text' name='phone' value='<?php echo $details['Phone'] ?? ''; ?>'>
            <label for='email'>Email:</label>
            <input type='text' name='email' value='<?php echo $details['Email'] ?? ''; ?>'>
            <input type='submit' value='Update'>
        </form>
    </div>

    </div>
    </div>

    <script>
        function toggleEditForm() {
            var editForm = document.getElementById('editForm');
            if (editForm.style.display === 'none') {
                editForm.style.display = 'block';
            } else {
                editForm.style.display = 'none';
            }
        }

        function toggleCertificateForm(year) {
            var editCertificateForm = document.getElementById('editCertificateForm');
            var yearInput = document.getElementById('yearInput');
            yearInput.value = year;

            if (editCertificateForm.style.display === 'none') {
                editCertificateForm.style.display = 'block';
            } else {
                editCertificateForm.style.display = 'none';
            }
        }

        function toggleCertifications(year) {
            var certificationsDiv = document.getElementById('certifications_' + year);
            if (certificationsDiv.style.display === 'none') {
                certificationsDiv.style.display = 'block';
            } else {
                certificationsDiv.style.display = 'none';
            }
        }

        function openEditPage() {
            window.location.href = 'insert_participation.php';
        }

        function openDisplayPage() {
            //window.location.href = 'display_participations.php';
            var facultyName = "<?php echo $faculty_name; ?>";
            window.location.href = 'display_participations.php?faculty_name=' + encodeURIComponent(facultyName);
        }

    </script>

</body>
</html>