



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
            background-image: linear-gradient(rgba(121, 183, 210, 0.352), rgba(121, 183, 210, 0.447)),
                url('img3.jpeg');
            background-size: 100% 100%;
            background-repeat: no-repeat;
            display: flex;
            justify-content: center;
            align-items: flex-end;
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
            border: 2px solid #721e4dda;
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
            background: #2db4e6d3;
            border: 2px solid #721e4dda;
            border-radius: 40px;
            box-shadow: 0 0 10px rgba(0, 0, 0, .1);
            cursor: pointer;
            font-size: 16px;
            color: #000000;
            display: inline-block;
            transition: background 0.3s ease-in-out;
            
        }

        .btn:hover {
            background: #374347;
        }

        /* Add styles for the two buttons */
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

        .wrapper {
    /* Existing styles */

    /* Add new styles */
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 50vh;
}

.buttons-container {
    display: flex;
    justify-content: space-between;
    width: 60%; /* Adjust the width as needed */
    margin-bottom: 20px;
}

body {
  background-image: url('https://images.shiksha.com/mediadata/images/1650960174phpCqxuRI.jpeg');
  background-size: cover; /* Adjust the size to cover the entire background */
  background-position: center; /* Center the background image */
  background-repeat: no-repeat; /* Do not repeat the background image */
}


/* Other existing styles remain unchanged */
    </style>
    <title>Login Form</title>
</head>


<body>
    <!-- Add buttons for Admin and Faculty -->
    <div class="wrapper">
        <button class="btn-admin" onclick="showAdminLogin()"><b>Login as Admin</b></button>
        <button class="btn-faculty" onclick="showFacultyLogin()"><b>Login as Faculty</b></button>

        <!-- Admin Login Form -->
        <form action="index.php" id="adminLoginForm" style="display: none;">
        </form>

        <!-- Faculty Login Form -->
        <form action="" onsubmit="return validateForm('faculty')" id="facultyLoginForm" style="display: none;">
            <h1>Faculty Login</h1>
            <div class="inputbox">
                <input type="text" placeholder="Username" required id="facultyUsername">
                <i class="bx bxs-user"></i>
            </div>
            <div class="inputbox">
                <input type="password" placeholder="Password" required id="facultyPassword">
                <i class="bx bxs-lock-alt" onclick="togglePasswordVisibility('facultyPassword')"></i>
            </div>
            <div class="remember-forgot">
                <label><input type="checkbox"> Remember me</label>
                <a href="#">Forgot password?</a>
            </div>
            <button type="submit" class="btn">Login</button>
            <p id="facultyErrorText" style="color: red;"></p>
        </form>

        <script>
            function showAdminLogin() {
                document.getElementById('adminLoginForm').style.display = 'block';
                document.getElementById('facultyLoginForm').style.display = 'none';
            }

            function showFacultyLogin() {
                document.getElementById('facultyLoginForm').style.display = 'block';
                document.getElementById('adminLoginForm').style.display = 'none';
            }

            function validateForm(userType) {
                var username, password, errorTextId;

                if (userType === 'admin') {
                    username = document.getElementById('adminUsername').value;
                    password = document.getElementById('adminPassword').value;
                    errorTextId = 'adminErrorText';

                } else if (userType === 'faculty') {
                    username = document.getElementById('facultyUsername').value;
                    password = document.getElementById('facultyPassword').value;
                    errorTextId = 'facultyErrorText';
                }

                // For simplicity, let's assume the correct username and password are "admin" for Admin and "faculty" for Faculty
                if (username === 'admin' && password === 'admin123') {
                    window.location.href = 'firstpage.html';
                    return false;
                } else {
                    document.getElementById('errorText').textContent = 'Invalid username or password. Please try again.';
                    return false;
                }
            }

            function togglePasswordVisibility(passwordId) {
                var passwordInput = document.getElementById(passwordId);
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
