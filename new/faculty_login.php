<?php
// Include the database connection file
include('db_connection.php');

// Start a new or resume an existing session
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mocking user authentication - replace this with your actual authentication logic
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Mocking a simple query to check the credentials - replace this with your actual query
    $query = "SELECT faculty_name, password FROM faculty_login WHERE username = ?";
    
    // Using prepared statement to prevent SQL injection
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the query returned a row, indicating a successful login
    if ($result->num_rows == 1) {
        // Fetch the faculty_name and hashed password
        $row = $result->fetch_assoc();
        $stored_password_hash = $row['password'];

        // Check if the entered password matches the stored hashed password
        if (password_verify($password, $stored_password_hash)) {
            // Passwords match, store faculty_name in the session
            $_SESSION['faculty_name'] = $row['faculty_name'];

            // Redirect to the dashboard after successful login
            header("Location: dashboard.php");
            exit();
        } else {
            // Display an error message for incorrect password
            $error_message = "Invalid password";
        }
    } else {
        // Display an error message for unsuccessful login
        $error_message = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <style>
       body {
    background-image: linear-gradient(rgba(121, 183, 210, 0.352), rgba(121, 183, 210, 0.447)),
        url('https://images.shiksha.com/mediadata/images/1650960174phpCqxuRI.jpeg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    margin: 0;
    font-family: "Poppins", sans-serif;
}

.wrapper {
    margin-top: 50px;
    margin-right: 5px;
    margin-bottom:10px;
    width: 300px;
    background: rgba(173, 187, 190, 0.842);
    padding-right: 5px;
    padding-left: 5px;
    color: #000000;
    border-radius: 20px;
    border: 2px solid  rgb(54,74,72,0.984);
    display: flex;
    flex-direction: column;
    align-items: center;
    height: 50vh;
}

.wrapper h2 {
    font-size: 36px;
    text-align: top;
    padding-top: -30px;
}

.inputbox {
    position: relative;
    width: 100%;
    margin-top: 20px; /* Adjusted margin-top */
}

.inputbox input {
    width: 100%;
    height: 40px;
    background: transparent;
    border: none;
    outline: none;
    border: 2px solid rgba(0, 0, 0, 0.2);
    border-radius: 40px;
    font-size: 16px;
    color: #000000;
    padding: 10px 20px;
    box-sizing: border-box;
    margin-bottom: 20px; /* Added margin-bottom */
}

.inputbox i {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 50px;
    cursor: pointer;
}

.remember-forgot {
    display: flex;
    justify-content: space-between;
    font-size: 14.5px;
    margin: -15px 0 15px;
}

.remember-forgot label input {
    accent-color: #030303;
    margin-right: 3px;
}

.remember-forgot a {
    color: #000000;
    text-decoration: none;
}

.remember-forgot a:hover {
    text-decoration: underline;
}

.btn {
    width: 100%;
    height: 45px;
    background: #2db4e6d3;
    background-color: rgb(20,122,110);
    border: 2px solid  rgb(54,74,72,0.984);
    border-radius: 40px;
    box-shadow: 0 0 10px rgba(0, 0, 0, .1);
    cursor: pointer;
    font-size: 16px;
    color: #000000;
    display: inline-block;
    transition: background 0.3s ease-in-out;
    margin-bottom: 10px;
}

.btn:hover {
    background: rgb(17,92,83);
}

.btn-admin,
.btn-faculty {
    width: 49%;
    height: 70px;
    background: rgb(82, 161, 114);
    border: 2px solid #09620cda;
    border-radius: 40px;
    box-shadow: 0 0 10px rgba(0, 0, 0, .1);
    cursor: pointer;
    font-size: 18px;
    font-style: oblique;
    color: #000000;
    display: inline-block;
    transition: background 0.3s ease-in-out;
    margin-right: 1%;
    margin-bottom: 3%;
} 

.btn-admin:hover,
.btn-faculty:hover {
    background: #374347;
}

    </style>
</head>
<body>

    <div class="wrapper">
        <h2>Login</h2>

        <?php
        // Display error message if login was unsuccessful
        if (isset($error_message)) {
            echo "<p style='color: red;'>$error_message</p>";
        }
        ?>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="username">Username:</label><br>
            <input type="text" name="username" required><br>

            <label for="password">Password:</label><br>
            <input type="password" name="password" required><br>

            <label>Don't have an account?</label><br>
            <a href="register_page.php">Create account</a><br><br>

            <input type="submit" value="Login" class="btn">
        </form>
    </div>

</body>
</html>