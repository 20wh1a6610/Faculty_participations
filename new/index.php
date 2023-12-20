<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // For simplicity, let's assume the correct username and password are "admin"
    if ($username === 'admin' && $password === 'admin123') {
        // Redirect to retrieve_faculty.php upon successful login
        header('Location: retrieve_faculty.php');
        exit(); // Ensure no further code is executed after the redirect
    } else {
        $errorText = 'Invalid username or password. Please try again.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
    
        body {
            background-image: linear-gradient(rgba(121, 183, 210, 0.352), rgba(121, 183, 210, 0.447)), url('img3.jpeg');
            background-size: 100% 100%;
            background-repeat: no-repeat;
            display: flex;
            justify-content: center;
            align-items: flex-end; /* Align to the bottom */
            min-height: 100vh;
            margin: 0;
            font-family: "Poppins", sans-serif;
        }

        .wrapper {
            margin-top: 20px;
            width: 420px;
            background: rgba(173, 187, 190, 0.842);
            padding-right: 10px;
            padding-left: 10px;

            color: #000000;
            border-radius: 20px;
            border: 2px solid  rgb(54,74,72,0.984);
        }

        .wrapper h1 {
            font-size: 36px;
            text-align: center;
        }

        .inputbox {
            position: relative;

            width: 100%;
            margin: 30px 0;
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
        }

        .inputbox i {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 20px;
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
    <title>Login Form</title>
</head>

<body>
    <div class="wrapper">
        <form action="" method="post">
            <h1>Login</h1>
            <div class="inputbox">
                <input type="text" placeholder="Username" required name="username">
                <i class="bx bxs-user"></i>
            </div>
            <div class="inputbox">
                <input type="password" placeholder="Password" required name="password">
                <i class="bx bxs-lock-alt" onclick="togglePasswordVisibility()"></i>
            </div>

            <!-- Link to faculty_login.php -->
            <div style="text-align: center; margin-bottom: 15px;">
                <a href="faculty_login.php" style="text-decoration: none; color: #000000;">want to login as faculty</a>
            </div>

            <button type="submit" class="btn">Login</button>

            <?php if (isset($errorText)) : ?>
                <p style="color: red;"><?php echo $errorText; ?></p>
            <?php endif; ?>
        </form>

        <script>
             function togglePasswordVisibility() {
                var passwordInput = document.getElementById('password');
                var icon = document.querySelector('.bx.bxs-lock-alt');

                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    icon.classList.remove('bxs-lock-alt');
                    icon.classList.add('bxs-lock-open-alt');
                } else {
                    passwordInput.type = 'password';
                    icon.classList.remove('bxs-lock-open-alt');
                    icon.classList.add('bxs-lock-alt');
                }
            }
        </script>
    </div>
</body>

</html>
