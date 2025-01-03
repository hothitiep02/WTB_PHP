<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
$isLoggedIn = isset($_SESSION['user_id']); // Kiểm tra chỉ cần user_id

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/WTB_PHP/public/css/Header.css">
</head>

<body>
    <div class="header-container">
    <div class="nav">
        <div class="logo"><img src="../../../public/asset/logo-wetube.png" alt=""></div>
        <div><a href="../index.php">Home</a></div>
        <div class="srch">
            <input type="text" placeholder="Search...">
            <button type="submit">
                <i class="fa fa-search"></i>
            </button>
        </div>
        <div><a href="../">Movies</a></div>
        <div class="auth">
            <?php if ($isLoggedIn): ?>
                <div id="user-icon" class="user-icon"><a href="../profile.php"><i class="fa fa-user"></i></a></div>
            <?php else: ?>
                <div id="login" class="auth-button"><a href="../auth/login.php">Login</a></div>
                <div id="signup" class="auth-button"><a href="../auth/register.php">Sign up</a></div>
            <?php endif; ?>
        </div>
    </div>
    </div>
</body>

</html>