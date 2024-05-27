<?php
include 'koneksi.php';
session_start();
error_reporting(0);

if (isset($_SESSION['username'])) {
    header("Location: index.php");
}

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM akun WHERE username='$username' AND password='$password'";
    $result = mysqli_query($koneksi, $sql);
    if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $row['username'];
        header("Location: index.php");
    } else {
        echo "<script>alert('Woops! Username atau password Anda salah.')</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Padang Jaya</title>
    <link rel="stylesheet" href="style.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: #e83e8c;
        } 

        .container {
            height: auto;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #FFE0E9;
            border-radius: 15px;
            box-shadow: 0 10px 15px #510219;

        } 

        .login {
            width: 400px; 
        }

        form {
            width: 250px;
            margin: 60px auto;
        }

        h4 {
            margin: 20px;
            text-align: center;
            font-weight: bolder;
            text-transform: uppercase;
        }

        hr {
            border-top: 4px solid #B9375E;
        }

        p {
            text-align: center;
            margin: 10px;
        }

        .right img {
            width: 400px auto;
            height: 100% auto;
        }

        form label {
            display: block;
            font-size: 16px;
            font-weight: 600;
            padding: 5px;
        }

        input {
            width: 100%;
            margin: 2px;
            border: none;
            outline: none;
            padding: 8px;
            border-radius: 5px;
            border: 1px solid gray;
        } 

        button {
            border: none;
            outline: none;
            padding: 8px;
            width: 252px;
            color: #FFE0E9;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login">
            <form method="post">
                <div class="login-form-head">
                    <h4>LOGIN</h4>
                    <hr>
                    <p>Selamat Datang Di ToSkin</p>
                    <p>Masukan Akun Anda</p>
                </div> 
                <div class="login-form-body">
                    <div class="form-gp">
                        <label for="username">Username</label>
                        <input type="text" placeholder="Username" name="username" required>
                        <i class="ti-email"></i>
                        <div class="text-danger"></div>
                    </div>
                    <div class="form-gp">
                        <label for="password">Password</label>
                        <input type="password" placeholder="Password" name="password" value="" required>
                        <i class="ti-lock"></i>
                        <div class="text-danger"></div>
                    </div>
                    <div class="submit-btn-area">
                    <button style="background-color: #e83e8c" type="submit" name="submit">Login</button>
                        <div class="login-other row mt-4"></div>
                    </div>
                </div>
            </form>
        </div>
        <div class="right">
            <img src="padang jaya.png" alt="Padang Jaya Logo">
        </div>
    </div>
</body>
</html>