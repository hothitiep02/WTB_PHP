<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* Chỉ áp dụng cho phần phim */
.movie-container {
    max-width: 1200px;
    margin: auto;
    padding: 20px;
    display: grid;
    grid-template-columns: repeat(4, 1fr); /* Tạo 4 cột */
    gap: 20px; /* Khoảng cách giữa các div phim */
}

.movie {
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 10px;
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

.movie-title {
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
    <div class="movie-container">
                <?php
                if (is_array($data['collection']) && !empty($data['collection'])) {
                    foreach ($data['collection'] as $movie) {
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