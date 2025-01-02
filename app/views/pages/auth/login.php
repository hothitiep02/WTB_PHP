<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
    background-color: black;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    margin: 0;
    font-family: Arial, sans-serif;
}

.container {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 90%;
    max-width: 400px;
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    margin: 100px auto;
}

h1 {
    margin-bottom: 20px;
    color: black;
}

.form-login {
    display: flex;
    flex-direction: column;
    width: 100%;
}

label {
    margin-top: 20px;
    text-align: left;
    color: black;
}

input[type="email"],
input[type="password"] {
    background-color: azure;
    /* Consistent background color */
    width: 100%;
    /* Full width for all input fields */
    padding: 10px;
    /* Consistent padding */
    margin-top: 10px;
    /* Spacing above each input */
    border: 1px solid #ccc;
    /* Consistent border */
    border-radius: 20px;
    /* Same border radius for all */
    font-size: 16px;
    /* Consistent font size */
    box-sizing: border-box;
    /* Include padding in width */
}

input[type="submit"] {
    background-color: yellow;
    color: black;
    padding: 10px 15px;
    width: 100%;
    /* Full width for consistency */
    border: none;
    border-radius: 20px;
    /* Match border radius of input fields */
    cursor: pointer;
    margin-top: 30px;
    font-size: 16px;
}

input[type="submit"]:hover {
    background-color: rgb(188, 188, 0);
}

.error-message {
    color: red;
    /* Make error messages stand out */
    margin-bottom: 10px;
}

p {
    margin-top: 20px;
    color: black;
    /* Ensure text is visible */
}

p a {
    text-decoration: none;
    color: yellow;
}

.forgot-pw {
    margin-top: 5px;
    color: black;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}
    </style>
</head>

<body>
    <div class="container">
        <h1>Login</h1>
        <?php if (!empty($error)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="post" class="form-login" action="./auth-process.php">
            <input type="hidden" name="action" value="login">
            <label for="user-email">Email</label>
            <input type="email" name="email" id="email" placeholder="Input your email here" required>

            <label for="user-password">Password</label>
            <input type="password" name="password" id="password" placeholder="Input your password here" required>

            <input type="submit" value="Login">
        </form>
        <a href="#" class="forgot-pw">Forgot Password?</a>
        <p>Already have an account? <a href="register.php"><b>Register</b></a></p></div>
</body>

</html>