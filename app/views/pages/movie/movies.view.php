<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
<style>
    /* Đảm bảo tất cả mã CSS được bao bọc trong một lớp cụ thể */
.movie-page {
    font-family: Arial, sans-serif;
    background-color: black; /* Màu nền nhẹ */
}

/* Định dạng form giống như navigation */
/* Định dạng form giống như navigation */
.movie-page form {
    background-color: black; /* Màu nền tối giống nav */
    border-radius: 0; /* Không bo góc */
    padding: 10px 20px; /* Padding để tạo khoảng cách */
    max-width: 1000px; /* Chiều rộng tối đa cho form */
    display: flex; /* Sử dụng flexbox */
    align-items: center; /* Căn giữa dọc */
    justify-content: center; /* Căn giữa ngang */
    flex-wrap: wrap; /* Cho phép các phần tử xuống dòng */
}

/* Định dạng các label trong form */
.movie-page label {
    color: white; /* Màu chữ trắng */
    margin: 0 10px; /* Khoảng cách giữa các label */
    text-align: center; /* Căn giữa chữ trong label */
    flex: 0 1 auto; /* Cho phép label tự do căn chỉnh */
}

/* Định dạng button */
.movie-page button {
    padding: 10px 15px;
    background-color: red; /* Màu nút */
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-left: 20px; /* Khoảng cách với các label */
}
.movie-page h3 {
    color: white; /* Màu chữ trắng để tương phản với nền */
    margin: 0; /* Không có khoảng cách */
    margin-right: 20px; /* Khoảng cách với các phần tử khác */
}

.movie-page button:hover {
    background-color: red; /* Màu nền khi hover */
}

/* Định dạng container phim */
.movie-page .movie-container {
    max-width: 1200px;
    margin: auto;
    padding: 20px;
}

/* Định dạng danh sách phim */
.movie-page .section {
    margin-bottom: 40px;
}

.movie-page .release {
    display: flex;
    flex-wrap: wrap; /* Cho phép các phần tử xuống dòng */
    justify-content: space-between; /* Căn giữa các cột */
}

/* Định dạng từng phim */
.movie-page .movie {
    background-color: black;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 10px;
    margin: 10px;
    width: calc(25% - 20px); /* Đặt chiều rộng cho mỗi div phim */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s;
    position: relative; /* Để định vị play-button */
}

.movie-page .movie:hover {
    transform: scale(1.05); /* Hiệu ứng phóng to khi hover */
}

.movie-page .movie img {
    width: 100%;
    border-radius: 4px;
    height: 200px; /* Chiều cao cho hình ảnh */
    object-fit: cover; /* Đảm bảo hình ảnh không bị méo */
}

/* Định dạng nút play */
.movie-page .play-button {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 30px;
    color: white;
    background-color: rgba(0, 0, 0, 0.7);
    border-radius: 50%;
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}

/* Định dạng tiêu đề phim */
.movie-page .movie_title {
    text-align: center;
    margin: 10px 0;
}

/* Định dạng nút xem phim */
.movie-page .watch-button {
    display: inline-block;
    padding: 8px 16px;
    margin: 5px 0;
    background-color: red;
    color: white;
    text-decoration: none;
    border-radius: 4px;
    text-align: center;
}

.movie-page .watch-button:hover {
    background-color: red; /* Màu nền khi hover */
}

/* Responsive Design */
@media (max-width: 768px) {
    .movie-page .movie {
        width: calc(50% - 20px); /* Thay đổi chiều rộng cho màn hình nhỏ */
    }
}

@media (max-width: 480px) {
    .movie-page .movie {
        width: 100%; /* Chiều rộng 100% cho màn hình rất nhỏ */
    }
}
</style>
</head>
<body>
    <div class="movie-page">
        <form action="Movie/filterByGenre" method="POST">
            <h3>Select Genre:</h3>
            <?php
            foreach ($data['genres'] as $genre) {
                echo "<label>";
                echo "<input type='radio' name='genre' value='" . htmlspecialchars($genre['type_id']) . "'>";
                echo htmlspecialchars($genre['type_name']);
                echo "</label><br>";
            }
            ?>
            <button type="submit">Filter</button>
        </form>
        <div class="movie-container">
            <div class="section">
                <h2>Movies</h2>
                <div class="release">
                    <?php
                    if (is_array($data['movieList']) && !empty($data['movieList'])) {
                        foreach ($data['movieList'] as $movie) {
                            echo "<div class='movie'>";
                            echo "<img src='" . htmlspecialchars($movie['poster']) . "' alt='" . htmlspecialchars($movie['title']) . "' />";
                            echo "<div class='play-button'>▶</div>";
                            echo "<div class='movie_title'>";
                            echo "<h3>" . htmlspecialchars($movie['title']) . "</h3>";
                            echo "</div>";
                            echo "<a class='watch-button' href='Movie/showById/" . htmlspecialchars($movie['movie_id']) . "'>▶ Watch movie</a>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>No movie available.</p>"; // Message if no latest movies
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>