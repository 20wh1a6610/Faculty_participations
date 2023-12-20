<?php
include 'db_connection.php';

// Use prepared statements for deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $deleteId = $_POST['delete_id'];

    // Use prepared statement to prevent SQL injection
    $deleteQuery = "DELETE FROM faculty_participations WHERE id = ?";
    $stmt = mysqli_prepare($conn, $deleteQuery);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'i', $deleteId);
        $deleteResult = mysqli_stmt_execute($stmt);

        if ($deleteResult) {
            $deleteMessage = "Record deleted successfully.";
        } else {
            $deleteMessage = "Error: " . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
    } else {
        $deleteMessage = "Error: " . mysqli_error($conn);
    }
}

// // Fetch updated data after deletion
// $query = "SELECT * FROM faculty_participations";
// $result = mysqli_query($conn, $query);

// Fetch updated data after deletion
$faculty_name = isset($_GET['faculty_name']) ? $_GET['faculty_name'] : null; // Added to get faculty_name from the URL parameter

$query = "SELECT * FROM faculty_participations WHERE faculty_name = ?";
$stmt_query = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt_query, 's', $faculty_name);
mysqli_stmt_execute($stmt_query);
$result = mysqli_stmt_get_result($stmt_query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <title>Faculty Participation Details</title> -->
    <link rel="stylesheet" href="styles.css">
    <style>
        
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
</style>
    
</head>
<body>
<div class="heading-box">
    <!-- <h1>Department of Artificial Intelligence and Machine Learning</h1> -->
    <form action="logout.php" method="post">
        <button class="logout-button" type="submit" name="logout">Logout</button>
    </form>
</div>

    <h2>Faculty Participation Details</h2>

    <?php if (isset($deleteMessage)): ?>
        <div class="message"><?php echo $deleteMessage; ?></div>
    <?php endif; ?>

    <table>
        <tr>
            <!-- <th>ID</th> -->
            <th>Faculty Name</th>
            <th>Event Name</th>
            <th>Year</th>
            <th>Image/PDF</th>
            <th>Action</th>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            // echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['faculty_name'] . "</td>";
            echo "<td>" . $row['event_name'] . "</td>";
            echo "<td><pre>" . print_r($row['Year'], true) . "</pre></td>"; // Debugging statement

            // Display the image or link to the PDF based on the file type
            echo "<td>";
            if (!empty($row['file_path']) && file_exists($row['file_path'])) {
                $fileInfo = pathinfo($row['file_path']);
                $fileExtension = strtolower($fileInfo['extension']);

                if ($fileExtension == 'pdf') {
                    echo '<a href="' . $row['file_path'] . '" target="_blank">View PDF</a>';
                } elseif (in_array($fileExtension, ['jpg', 'jpeg', 'png'])) {
                    echo '<a href="view_image.php?image=' . $row['file_path'] . '" target="_blank">View Image</a>';
                }
            }
            echo "</td>";

            // Delete button using AJAX
            echo '<td><button class="delete-btn" data-delete-id="' . $row['id'] . '">Delete</button></td>';

            echo "</tr>";
        }
        ?>
    </table>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function () {
            // Initial binding of delete button click
            bindDeleteButtonClick();

            function bindDeleteButtonClick() {
                // Handle delete button click using AJAX
                $('table').on('click', '.delete-btn', function () {
                    var deleteId = $(this).data('delete-id');

                    // Unbind click event to prevent multiple bindings
                    $('table').off('click', '.delete-btn');

                    // AJAX request to delete.php
                    $.ajax({
                        type: 'POST',
                        url: 'display_participations.php',
                        data: { delete_id: deleteId },
                        dataType: 'json',
                        success: function (response) {
                            alert(response.message);

                            // Reload the table data after successful deletion
                            $.get('display_participations.php', function (data) {
                                $('table').html(data);
                                // Rebind click event after reloading data
                                bindDeleteButtonClick();
                            });
                        },
                        error: function (error) {
                            alert('Error: ' + error.message);
                        }
                    });
                });
            }
        });
    </script>
</body>
</html>

<?php
mysqli_close($conn);
?>