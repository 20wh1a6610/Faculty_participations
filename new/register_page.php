<?php
// Include the database connection file
include('db_connection.php');

// Start a new or resume an existing session
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $faculty_name = $_POST["faculty_name"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Validation (you can add more validation as needed)
    if ($password != $confirm_password) {
        $error_message = "Password and Confirm Password do not match";
    } else {
        // Hash the password before storing it in the database (enhance security)
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert data into faculty_login table
        $insert_login_query = "INSERT INTO faculty_login (faculty_name, username, password) 
                                VALUES ('$faculty_name', '$username', '$hashed_password')";

        if ($conn->query($insert_login_query)) {
            // Insert successful, proceed with inserting into faculty_details
            $insert_details_query = "INSERT INTO faculty_details (Faculty_Name) VALUES ('$faculty_name')";

            if ($conn->query($insert_details_query)) {
                // Redirect to the login page after successful registration
                header("Location: faculty_login.php");
                exit();
            } else {
                // Log the error
                error_log("Error inserting into faculty_details: " . $conn->error);

                // Display an error message
                $error_message = "Error during registration. Please try again later.";
            }
        } else {
            // Log the error
            error_log("Error inserting into faculty_login: " . $conn->error);

            // Display an error message
            $error_message = "Error during registration. Please try again later.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
       
       body {
    background-image: linear-gradient(rgba(121, 183, 210, 0.352), rgba(121, 183, 210, 0.447)), url('img3.jpeg');
    background-size: 100% 100%;
    background-repeat: no-repeat;
    display: flex;
    justify-content: center;
    align-items: center; /* Align to the bottom */
    min-height: 100vh;
    margin: 0;
    font-family: "Poppins", sans-serif;
}

.wrapper {
    margin-top: 20px;
    width: 420px;
    background: rgba(173, 187, 190, 0.842);
    padding: 20px;
    color: #000000;
    border-radius: 20px;
    border: 2px solid  rgb(54,74,72,0.984);

    box-sizing: border-box; /* Include padding and border in element's total width and height */
    text-align: center; /* Include padding and border in element's total width and height */
}

.wrapper h2 {
    font-size: 36px;
    text-align: center;
    margin-bottom: 20px;
}

.inputbox {
    margin-bottom: 20px;
    border-radius: 10px;
}

.inputbox input {
    width: 100%;
    height: 40px;
    background: transparent;
    border: none;
    outline: none;
    border: 2px solid rgba(0, 0, 0, 0.2);
    border-radius: 20px;
    font-size: 16px;
    color: #000000;
    padding: 10px 20px;
    box-sizing: border-box;
}

.inputbox i {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 20px;
    cursor: pointer;
}

.btn {
    width: 100%;
    height: 45px;
    background: rgb(20,122,110);
    border: 2px solid  rgb(54,74,72,0.984);
    border-radius: 40px;
    box-shadow: 0 0 10px rgba(0, 0, 0, .1);
    cursor: pointer;
    font-size: 16px;
    color: #000000;
    display: inline-block;
    transition: background 0.3s ease-in-out;
}

.btn:hover {
    background: rgb(17,92,83);
}
    </style>
</head>
<body>

    <div class="wrapper">
        <h2>Register</h2>

        <?php
        // Display error message if registration encountered an error
        if (isset($error_message)) {
            echo "<p style='color: red;'>$error_message</p>";
        }
        ?>
   
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="faculty_name">Faculty Name:</label><br>
            <input type="text" name="faculty_name" required><br>

            <label for="username">Username:</label><br>
            <input type="text" name="username" required><br>

            <label for="password">New Password:</label><br>
            <input type="password" name="password" required><br>

            <label for="confirm_password">Confirm Password:</label><br>
            <input type="password" name="confirm_password" required><br><br>

            <input type="submit" class= "btn" value="Register">
        </form>
 
    </div>

</body>
</html>