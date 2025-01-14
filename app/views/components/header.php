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
            <div class="logo"><img src="/WTB_PHP/public/images/Logo WTB.jpg" alt=""></div>
            <div>
                <a href="home" style="font-size:26px;">Home</a>
            </div>
            <div class="btn_search">
                <form action="Movie/search" method="POST" class="srch">
                    <div>
                        <input type="text" name="search_term" placeholder="Search by movie name..." required>
                    </div>
                    <div>
                        <button type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
            <div><a href="movie" id="movies">Movies</a></div>
            <div class="auth">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <div id="user-icon" class="user-icon">
                        <a href="user/profile">
                            <img src="<?php echo htmlspecialchars('/WTB_PHP/public/images/avatar/' . $_SESSION['image']); ?>" 
                                class="avarta" 
                                alt="" 
                                style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                        </a>
                    </div>
                    <?php if ($_SESSION['role'] === 'admin'): ?>
                        <div class="admin-links">
                            <div>
                                <a href="admin/MovieManage">Movies Management</a>
                            </div>
                            <div>
                                <a href="admin/ShowUserAdmin">Users Management</a>
                            </div>
                            <div>
                                <a href="admin/Dashboard">DashBoard</a>
                            </div>
                        </div>
                    <?php endif; ?>
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
    </div>
</body>
</html>