
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/WTB_PHP/public/css/Profile.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Profile Container</title>
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
    <a href="javascript:void(0);" class="arrow" id="toggleActivity">
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
                <i class="fa-solid fa-bookmark"></i>
                <span>Collection</span>
            </a>
        </li>
    </ul>
</div>
        <div class="sidebar_item" id="sidebar_Account">
            <a href="user/showCollection">
                <i class="fa fa-cog" style="font-size:24px"></i>
                <span>Account Setting</span>
            </a>
        </div>
        <div class="sidebar_item" id="sidebar_Account">
            <a href="user/showHistory">
                <i class="fa fa-cog" style="font-size:24px"></i>
                <span>Account Setting</span>
            </a>
        </div>

        <div>
            <a href="User/Logout">Log out</a>
        </div>
    </div>
    <div id="profile_info">
        <h2><b>Your Profile</b></h2>
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
                    <p><strong>Birth:</strong> <?php echo isset($data['userInfo']['birth']) ? htmlspecialchars($data['userInfo']['birth']) : 'N/A'; ?></p>
                </div>
                <button id="editButton" class="btn btn-primary" onclick="toggleEditForm()">Edit Profile</button>
            </div>
        </div>

        <!-- Form Update Profile (hidden by default) -->
        <form id="editForm" action="" method="POST" enctype="multipart/form-data" style="display: none;">
    <div class="img_upload">
        <img id="img-user" src="<?php echo htmlspecialchars($data['userInfo']['image']); ?>" alt="User Avatar" class="image-user">
        <div class="camera-icon">
            <i class="fa fa-camera" style="font-size:28px"></i>
        </div>
        <input type="file" name="image" class="file-input" accept="image/*" onchange="updateImagePreview(event)">
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
        <button type="submit" id="Update_Profile"class="btn btn-success">Update Profile</button>
    </div>
    <span class="close-btn" onclick="closeEditForm()">&times;</span>
</form>

    </div>
</div>

<script>
    function closeEditForm() {
        var editForm = document.getElementById('editForm');
        var formInf = document.querySelector('.form_inf');
        editForm.style.display = 'none';
        formInf.style.display = 'block';
    }
    function updateImagePreview(event) {
        const fileInput = event.target;
        const imgPreview = document.getElementById('img-user');

        const reader = new FileReader();
        reader.onload = function(e) {
            imgPreview.src = e.target.result;
        };

        if (fileInput.files && fileInput.files[0]) {
            reader.readAsDataURL(fileInput.files[0]);
        }
    }
    function toggleEditForm() {
        var editForm = document.getElementById('editForm');
        var formInf = document.querySelector('.form_inf');
        if (formInf.style.display === 'none') {
            formInf.style.display = 'block'; 
            editForm.style.display = 'none';
        } else {
            formInf.style.display = 'none'; 
            editForm.style.display = 'block';
        }
    }
    document.getElementById('toggleActivity').addEventListener('click', function() {
    document.getElementById('sidebar_Activity').classList.toggle('open');
    });
</script>
</body>
</html>