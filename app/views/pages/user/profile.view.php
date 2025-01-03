
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="C:\xampp\htdocs\WeTube_php\public\asset\css\profile.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Profile Container</title>
        <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #0f0e0e;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            background-color: #181414;
            width: 100%;
            height: 100vh;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin: 20px;
        }

        @media (min-width: 1200px) {

            .container,
            .container-lg,
            .container-md,
            .container-sm,
            .container-xl {
                max-width: 1480px;
            }
        }

        .sidebar {
            width: 25%;
            background-color: #fff;
            margin-right: 20px;
            color: #120202;
            padding: 20px;
            border-radius: 8px;
        }

        span {
            font-size: 20px;
        }

        .sidebar a {
            color: #080000;
            text-decoration: none;
            display: block;
            margin: 10px 0;
        }

        .sidebar_item ul {
            list-style-type: none;
            display: none;
        }

        .sidebar_item.active ul {
            display: block;
        }

        #profile_info {
            background-color: #fff;
            width: 100%;
            padding: 20px;
            border-radius: 8px;

        }

        .content h2 {
            margin-bottom: 20px;
        }

        .upload {
            width: 200px;
            height: 200px;
            border: 2px dashed #ccc;
            border-radius: 50%;
            overflow: hidden;
            margin: 20px auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .img_upload img {
            width: 100%;
            height: auto;
            border-radius: 50%;
        }

        .camera-icon {
            position: absolute;
            top: 250px;
            right: 36%;
            background-color: rgba(255, 255, 255, 0.7);
            border-radius: 50%;
            padding: 5px;
            cursor: pointer;
        }

        .form_inf {
            margin-left: 20%;
            color: black;
        }

        .mb-3 {
            margin-bottom: 15px;
        }

        .mb-3 label {
            font-size: 20px;
            display: block;
            margin-bottom: 5px;
        }

        .mb-3 input {
            font-size: 20px;
            width: 75%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .btn-update {
            font-size: 20px;
            background-color: #eeea04;
            color: rgb(0, 0, 0);
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 66%;
        }

        .btn-update:hover {
            background-color: #218838;
        }

        p {
            font-size: 20px;
        }

    </style>
</head>
<body>

<div class="container">
    <div class="sidebar" style="width: 280px;">
        <div class="sidebar_item" id="sidebar_Home">
            <a href="/" class="">
                <i class="fa fa-home" style="font-size:24px"></i>
                <span class="">Home</span>
            </a>
        </div>
        <div class="sidebar_item" id="sidebar_Activity">
            <a href="javascript:void(0);" class="arrow">
                <i class="fa fa-snowflake-o" style="font-size:24px"></i>
                <span>Your activity</span>
                <span class="arrow">&#9660;</span>
            </a>
            <ul>
                <li>
                    <a href="#" class="item" id="item_History">
                        <i class="fa fa-history"></i>
                        <span>History</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="item" id="item_Like">
                        <i class="fa fa-thumbs-up"></i>
                        <span>Liked</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="sidebar_item" id="sidebar_Account">
            <a href="/" class="">
                <i class="fa fa-cog" style="font-size:24px"></i>
                <span>Account Setting</span>
            </a>
        </div>
    </div>
    <div id="profile_info">
        <h2>Your Profile</h2>
        <div id="userProfile">
            <div class="img_upload">
                <?php if (!empty($data['userInfo']['image'])): ?>
                    <img src="<?php echo htmlspecialchars($data['userInfo']['image']); ?>" alt="User Avatar" id="profileImage">
                <?php else: ?>
                    <p>No image available.</p>
                <?php endif; ?>
            </div>
            <hr>
            <div class="form_inf">
                <div class="mb-3">
                    <p><strong>User name:</strong> <?php echo htmlspecialchars($data['userInfo']['user_name']); ?></p>
                </div>
                <div class="mb-3">
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($data['userInfo']['email']); ?></p>
                </div>
                <div class="mb-3">
                    <p><strong>Birth:</strong> <?php echo isset($user['birth']) ? htmlspecialchars($data['userInfo']['birth']) : 'N/A'; ?></p>
                </div>
                <button id="editButton" class="btn btn-primary" onclick="toggleEditForm()">Edit Profile</button>
            </div>
        </div>

        <form id="editForm" action="" method="POST" enctype="multipart/form-data" style="display: none;">
            <div class="img_upload">
                <img id="img-user" src="<?php echo htmlspecialchars($user['image']); ?>" alt="User Avatar" class="image-user">
                <div class="camera-icon">
                    <i class="fa fa-camera" style="font-size:28px"></i>
                </div>
                <input type="file" name="image" class="file-input" accept="image/*" style="display: none;">
            </div>
            <hr>
            <div class="form_inf">
                <div class="mb-3">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="user_name" value="<?php echo htmlspecialchars($data['userInfo']['user_name']); ?>" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($data['userInfo']['email']); ?>" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="birth">Birth</label>
                    <input type="date" id="birth" name="birth" value="<?php echo isset($data['userInfo']['birth']) ? htmlspecialchars($data['userInfo']['birth']) : ''; ?>" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($data['userInfo']['password']); ?>" class="form-control" required>
                </div>
            </div> 
            <button type="submit" class="btn btn-success">Update Profile</button>
        </form> 
    </div>
</div>

<script>
function toggleEditForm() {
    var editForm = document.getElementById('editForm');
    editForm.style.display = editForm.style.display === 'none' ? 'block' : 'none';
}
</script>
</body>
</html>