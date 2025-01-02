<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.lineicons.com/4.0/lineicons.css" />
    <link rel="stylesheet" href="../../../public/asset/register.css">
</head>
<body>
    <div class="container">
        <div class="signup-form">   
            <!-- Chỉnh sửa action để trỏ tới controller -->
            <form action="./auth-process.php" method="POST">
                <input type="hidden" name="action" value="register">
                <h2>Create your Free Account</h2>
                <div class="form">
                    <p>Full Name</p>
                    <input type="text" id="fullname" name="fullname" placeholder="Enter your Full Name here" required>
                </div>
                <div class="form">
                    <p>Email</p>
                    <input type="email" id="email" name="email" placeholder="Enter your Email here" required>
                </div>
                <div class="form">
                    <p>Password</p>
                    <input type="password" id="password" name="password" placeholder="Enter your Password here" required>
                </div>
                <button type="submit">Create Account</button>
            </form>
            <p class="login">Already have an account? <a href="login.php">Log in</a></p>
        </div>
    </div>
</body>
</html>