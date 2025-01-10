<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="path/to/your/styles.css"> <!-- Đảm bảo đường dẫn đúng -->
    <style>
        /* Chỉ áp dụng cho phần lịch sử phim */
.history-container {
    max-width: 1200px;
    margin: auto;
    padding: 20px;
    display: flex; /* Sử dụng Flexbox */
    flex-wrap: wrap; /* Cho phép các phần tử xuống dòng */
    justify-content: space-between; /* Căn giữa các cột */
    color: white;
}

.movie {
    background-color: black;
    border: 1px solid black;
    border-radius: 8px;
    padding: 10px;
    margin: 10px 0; /* Giữ khoảng cách trên và dưới */
    width: calc(25% - 20px); /* Đặt chiều rộng cho mỗi div phim để tạo 4 cột */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s;
    display: flex;
    flex-direction: column; /* Để nội dung nằm theo chiều dọc */
    height: 400px; /* Chiều cao cố định cho div phim */
}

.movie:hover {
    transform: scale(1.05);
}

.movie img {
    width: 100%;
    border-radius: 4px;
    height: 200px; /* Chiều cao cho hình ảnh */
    object-fit: cover; /* Đảm bảo hình ảnh không bị méo */
}

.movie_title {
    text-align: center;
    margin: 10px 0;
    flex-grow: 1; /* Đẩy nút Watch movie xuống dưới */
}

.watch-button {
    display: inline-block;
    padding: 8px 16px;
    margin: 5px 0;
    background-color: red;
    color: white;
    text-decoration: none;
    border-radius: 4px;
    text-align: center;
}

.watch-button:hover {
    background-color: red;
}
    </style>
</head>
<body>
    <div class="history-container">
        <?php
        if (is_array($data['history']) && !empty($data['history'])) {
            foreach ($data['history'] as $movie) {
                echo "<div class='movie'>";
                echo "<img src='" . htmlspecialchars($movie['poster']) . "' alt='" . htmlspecialchars($movie['title']) . "' />";
                echo "<div class='movie_title'>";
                echo "<h3>" . htmlspecialchars($movie['title']) . "</h3>";
                echo "</div>";
                echo "<a class='watch-button' href='Movie/showById/" . htmlspecialchars($movie['movie_id']) . "'>▶ Watch movie</a>";
                echo "</div>";
            }
        } else {
            echo "<p>No movie added!!.</p>"; // Message if no latest movies
        }
        ?>
    </div>
</body>
</html>