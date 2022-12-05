<?php
require('functions.php');

if(isset($_POST["register"])) {
    if(registrasi($_POST) > 0 ) {
        echo "<script>alert('User Baru Berhasil Dibuat!'); 
        </script>";
    } else {
        echo mysqli_error($conn);
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Registrasi</title>
    <style>
        label {
            display: block;
        }
    </style>
</head>
<body>
    <h1>Halaman Registrasi</h1>

    <!-- login -->
    <a href="login.php">Login</a><br><br>
    <form action="" method="POST">
        <ul>
            <li>
                <label for="username">Username:</label>
                <input type="text" name="username" id="username">
            </li><br>
            <li>
                <label for="password">Password:</label>
                <input type="password" name="password" id="password">
            </li><br>
            <li>
                <label for="password2">Konfirmasi Password:</label>
                <input type="password" name="password2" id="password2">
            </li><br>
            <li>
                <button type="submit" name="register">Daftar!</button>
            </li>
    </form>
    
</body>
</html>