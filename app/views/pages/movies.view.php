<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách phim</title>
</head>
<body>
    <h1>Danh sách phim</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Tên phim</th>
            <th>Thể loại</th>
            <th>Năm phát hành</th>
        </tr>
        <?php if (!empty($data['movieList'])): ?>
            <?php foreach ($data['movieList'] as $movie): ?>
            <tr>
                <td><?php echo htmlspecialchars($movie['movie_id']); ?></td>
                <td><?php echo htmlspecialchars($movie['title']); ?></td>
                <td><?php echo htmlspecialchars($movie['poster']); ?></td>
                <td><?php echo htmlspecialchars($movie['description']); ?></td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">Không có dữ liệu để hiển thị.</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>