<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/WTB_PHP/public/css/UserManage.css">
    <title>User List</title>
</head>
<body>
    <div class="user_admin">
        <h2>User List</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Birth</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php if (!empty($data['users'])): ?>
                <?php foreach ($data['users'] as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['user_id']); ?></td>
                        <td><?php echo htmlspecialchars($user['user_name']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo htmlspecialchars($user['role']); ?></td>
                        <td><?php echo htmlspecialchars($user['birth']); ?></td>
                        <td>
                            <div class="btn_action" style="display:flex;gap:10px;  align-items:center;justify-content:center; text-align:center;">
                                <form method="post" action="/WTB_PHP/Admin/deleteUser/<?php echo htmlspecialchars($user['user_id']); ?>" 
                                    onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    <button type="submit" class="btn_delete">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                   
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No users found.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>