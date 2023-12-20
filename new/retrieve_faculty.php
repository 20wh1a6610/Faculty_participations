<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            background-image: url('bgimagedash.jpg');
            background-size: cover;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            margin-top: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .heading-box {
            background-color: #333;
            color: white;
            padding: 30px;
            
            position: absolute;
            top: 0;
            left: 0;
            
            
            width: 100%;
            
            display: flex;
            justify-content: center; /* Align items at the top right */
            align-items: center;
        }

        h1 {
        margin: 0;
    }

        form {
            display: flex;
            align-items: center;
        }

        button.logout-button {
            margin-left: 20px;
        }


       



.buttons-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-top: 20px;
}


/* ... (rest of the CSS remains unchanged) ... */





        .buttons-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
        }

        button {
            padding: 10px 20px;
            margin: 10px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 200px; /* Fixed width for better appearance */
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #45a049;
        }

        .logout-button {    
            padding: 5px;
            font-size: 16px;
            background-color:  #295a2b; /* Red color for logout */
            color: white;
            border: none;
            border-radius: 30px;
            cursor: pointer;
           width: 100px;

           
        }

        .logout-button:hover {
            background-color: #c9302c;
        }

</style>
    </head>
<body>

<div class="heading-box">
    <h1>Department of Artificial Intelligence and Machine Learning</h1>
    <form action="logout.php" method="post">
        <button class="logout-button" type="submit" name="logout">Logout</button>
    </form>
</div>



    <div class="buttons-container">
        <?php
        // Include your database connection file
        include('db_connection.php');

        // Retrieve all faculty names from the database
        $sql = "SELECT faculty_name FROM faculty_login";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Display each faculty name as a button
                echo '<form action="faculty_details.php" method="post">';
                echo '<button type="submit" name="faculty_name" value="' . $row['faculty_name'] . '">' . $row['faculty_name'] . '</button>';
                echo '</form>';
            }
        } else {
            echo '<p>No faculty names found in the database.</p>';
        }

        // Close the database connection
        $conn->close();
        ?>
    </div>
</body>

</html>