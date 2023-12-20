<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background-image: url('bgimagedash.jpg');
            background-size: cover;
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }

        .faculty-details {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }

        .faculty-details img {
            max-width: 200px;
            max-height: 200px;
            border-radius: 10px;
        }

        .faculty-info {
            max-width: 500px;
            padding: 20px;
            border-radius: 0 0 10px 10px;
        }

        .academic-years {
            text-align: center;
            margin-top: 20px;
        }

        .academic-years button {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            margin: 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
    <title>Faculty Details</title>
</head>

<body>

    <?php
    // Include your database connection file
    include('db_connection.php');

    // Check if the faculty_name is set in the POST request
    if (isset($_POST['faculty_name'])) {
        $faculty_name = $_POST['faculty_name'];

        // Fetch additional details of the selected faculty from the faculty_details table
        $sql = "SELECT * FROM faculty_details WHERE faculty_name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $faculty_name);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Display faculty details as needed
            while ($row = $result->fetch_assoc()) {
                $facultyName = $row['Faculty_Name'];
                $designation = $row['Designation'];
                $qualification = $row['Qualification'];
                $dateOfJoining = $row['Date_of_Joining'];
                $dateOfResigning = $row['Date_of_Resigning'];
                $phone = $row['Phone'];
                $email = $row['Email'];
                $profilePicPath = $row['Profile_Picture']; // New column for profile picture path

                echo '<div class="container">';
                echo '<div class="header">';
                echo "<h1>$facultyName</h1>";
                echo '</div>';

                echo '<div class="faculty-details">';
                // Display profile picture if available
                if (!empty($profilePicPath) && file_exists($profilePicPath)) {
                    echo '<img src="' . $profilePicPath . '" alt="Profile Picture">';
                } else {
                    echo '<p>No profile picture available</p>';
                }

                echo '<div class="faculty-info">';
                echo "<p>Designation: $designation</p>";
                echo "<p>Qualification: $qualification</p>";
                echo "<p>Date of Join: $dateOfJoining</p>";
                echo "<p>Date of Resign: $dateOfResigning</p>";
                echo "<p>Phone: $phone</p>";
                echo "<p>Email: $email</p>";
                echo '</div>';
                echo '</div>';

                // Fetch unique years from faculty_participations for the selected faculty
                $year_query = "SELECT DISTINCT Year FROM faculty_participations WHERE faculty_name = ?";
                $year_stmt = $conn->prepare($year_query);
                $year_stmt->bind_param("s", $faculty_name);
                $year_stmt->execute();
                $year_result = $year_stmt->get_result();

                if ($year_result->num_rows > 0) {
                    // Display Semester buttons for each unique year
                    echo '<div class="academic-years">';
                    echo '<h2>Academic Year</h2>';
                    while ($year_row = $year_result->fetch_assoc()) {
                        $selected_year = $year_row['Year'];
                        echo '<form action="semester.php" method="post">';
                        echo '<input type="hidden" name="faculty_name" value="' . $faculty_name . '">';
                        echo '<input type="hidden" name="selected_year" value="' . $selected_year . '">';
                        echo '<button type="submit" name="submit_year">Year: ' . $selected_year . '</button>';
                        echo '</form>';
                    }
                    echo '</div>';
                } else {
                    echo '<p>No semester details found for the selected faculty.</p>';
                }
                echo '</div>';
            }
        } else {
            echo '<p>No details found for the selected faculty.</p>';
        }

        $stmt->close();
        $year_stmt->close();
    } else {
        echo '<p>Error: Faculty name not set.</p>';
    }

    // Close the database connection
    $conn->close();
    ?>
</body>

</html>
