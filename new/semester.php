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

        h1, h2 {
            text-align: center;
        }

        table {
            background-color: white ;
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:hover {
            background-color: #f5f5f5;
        }
    </style>
    <title>Semester Details</title>
</head>

<body>

    <?php
    // Include your database connection file
    include('db_connection.php');

    // Check if faculty_name and selected_year are set in the POST request
    if (isset($_POST['faculty_name']) && isset($_POST['selected_year'])) {
        $faculty_name = $_POST['faculty_name'];
        $selected_year = $_POST['selected_year'];

        // Use prepared statements to prevent SQL injection
        $semester_query = $conn->prepare("SELECT id, event_name, file_path FROM faculty_participations WHERE faculty_name = ? AND Year = ?");
        $semester_query->bind_param("ss", $faculty_name, $selected_year);
        $semester_query->execute();
        $semester_result = $semester_query->get_result();

        if ($semester_result->num_rows > 0) {
            // Display semester details in table format
            echo '<h1>Participation Details</h1>';
            echo '<h2>Academic Year: ' . $selected_year . '</h2>';
            echo '<table>';
            echo '<tr>';
            echo '<th>Event Name</th>';
            echo '<th>View Image/PDF</th>';
            echo '</tr>';
            while ($semester_row = $semester_result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($semester_row['event_name']) . '</td>';

                // Debugging output
                echo '<td>';
                // echo 'File Path: ' . htmlspecialchars($semester_row['file_path']) . '<br>';
                if (!empty($semester_row['file_path']) && file_exists($semester_row['file_path'])) {
                    $fileInfo = pathinfo($semester_row['file_path']);
                    $fileExtension = strtolower($fileInfo['extension']);

                    if ($fileExtension == 'pdf') {
                        echo '<a href="' . htmlspecialchars($semester_row['file_path']) . '" target="_blank">View PDF</a>';
                    } elseif (in_array($fileExtension, ['jpg', 'jpeg', 'png'])) {
                        echo '<a href="view_image.php?image=' . htmlspecialchars($semester_row['file_path']) . '" target="_blank">View Image</a>';
                    } else {
                        echo 'Unsupported file type: ' . $fileExtension;
                    }
                } else {
                    echo 'File does not exist or file path is empty';
                }
                echo '</td>';

                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo '<p>No semester details found for the selected faculty in the year ' . htmlspecialchars($selected_year) . '.</p>';
        }

        // Close the prepared statement
        $semester_query->close();
    } else {
        echo '<p>Error: Faculty name or selected year not set.</p>';
    }

    // Close the database connection
    $conn->close();
    ?>
</body>

</html>
