

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            font-family: Arial, sans-serif;
            margin: 0;
            color: white;
        }

        .nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px;
            background-color: black;
            width: 100%;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
        }

        .nav>* {
            margin: 0 30px;
            padding: 15px;
            font-size: 18px;
            transition: background-color 0.3s, color 0.3s;
        }

        .nav>*:hover {
            background-color: #333;
            color: #f1f1f1;
            border-radius: 5px;
        }

        .logo {
            font-size: 28px;
            font-weight: bold;
        }

        img {
            width: 70px;
            height: 70px;
        }

        .srch {
            display: flex;
            align-items: center;
            position: relative;
        }

        .srch input[type="text"] {
            width: 200px;
            padding: 10px;
            border: none;
            border-radius: 5px 0 0 5px;
            outline: none;
            background-color: white;
            color: black;
            font-size: 16px;
        }

        .srch button {
            padding: 15px;
            border: none;
            border-radius: 0 5px 5px 0;
            background-color: #555;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
            display: flex;
            align-items: center;
            font-size: 16px;
        }

        .srch button:hover {
            background-color: #777;
        }

        .srch i {
            margin-left: 5px;
        }

        .auth {
            display: flex;
            gap: 20px;
        }

        .auth div {
            cursor: pointer;
            font-size: 16px;
        }

        .user-icon {
            font-size: 24px;
        }
    </style>
</head>

<body>
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
    <?php if (isset($_SESSION['user_id'])): ?>
        <div id="user-icon" class="user-icon">
            <a href="user/profile"><i class="fa fa-user"></i></a>
        </div>
    <?php else: ?>
        <div id="login" class="auth-button">
            <a href="user/login/">Login</a>
        </div>
        <div id="signup" class="auth-button">
            <a href="user/register/">Sign up</a>
        </div>
    <?php endif; ?>
        </div>
    </div>
</body>

</html>