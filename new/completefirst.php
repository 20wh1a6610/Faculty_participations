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
            background-image:linear-gradient(rgba(121, 183, 210, 0.352), rgba(121, 183, 210, 0.447)), url('img3.jpeg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: "Poppins", sans-serif;
        }

        .login-box {
            width: 420px;
            background: rgb(56,74,72,0.594);
            padding: 20px;
            color: #000000;
            border-radius: 20px;
            border: 2px solid  rgb(54,74,72,0.984);
            text-align: center;
        }

        .login-box button {
            width: 100%;
            height: 45px;
            margin-bottom: 10px;
            background: rgb(20,122,110);
            border: 2px solid rgb(54,74,72,0.984);
            border-radius: 40px;
            box-shadow: 0 0 10px rgba(0, 0, 0, .1);
            cursor: pointer;
            font-size: 16px;
            color: whitesmoke;
            display: inline-block;
            transition: background 0.3s ease-in-out;
        }

        .login-box button:hover {
            background:rgb(17,92,83);
        }

        .btn-admin,
        .btn-faculty {
            width: 100%;
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
        }

        .btn-admin:hover,
        .btn-faculty:hover {
            background: #374347;
        }
    </style>
    <title>Login Form</title>
</head>

<body>
    <div class="login-box">
        <!-- Button to Login as Admin -->
        <button class="btn-admin" onclick="loginAsAdmin()"><b>Login as Admin</b></button>

        <!-- Button to Login as Faculty -->
        <button class="btn-faculty" onclick="loginAsFaculty()"><b>Login as Faculty</b></button>
    </div>

    <script>
        function loginAsAdmin() {
            // Redirect to index.php for admin
            window.location.href = 'index.php';
        }

        function loginAsFaculty() {
            // Show the faculty login form (you can implement this part)
            window.location.href = 'faculty_login.php';
        }
    </script>
</body>

</html>
