<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="/WTB_PHP/public/css/Login.css">
</head>

<body>
    <div class="parent"> <!-- Sửa lỗi ở đây -->
        <div class="container">
            <h1>Login</h1>
            <?php if (!empty($errorMessage)): ?> <!-- Đảm bảo sử dụng đúng tên biến -->
                <div class="error-message"><?php echo htmlspecialchars($errorMessage); ?></div>
            <?php endif; ?>
            <form method="post" class="form-login" action="">
                <input type="hidden" name="action" value="login">
                <label for="user-email">Email</label>
                <input type="email" name="email" id="email" placeholder="Input your email here" required>

                <label for="user-password">Password</label>
                <input type="password" name="password" id="password" placeholder="Input your password here" required>

                <input class="login" type="submit" value="Login">
            </form>
            <a href="#" class="forgot-pw">Forgot Password?</a>
            <p>Already have an account? <a href="user/register"><b>Register</b></a></p>
        </div>
    </div>
</body>

</html>