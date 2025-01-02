<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie List</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #121212;
            color: white;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px 0;
        }

        /* Section Headers */
        h2 {
            font-size: 20px;
            margin-bottom: 10px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        h2 a {
            font-size: 14px;
            text-decoration: none;
            color: #ff0000;
            font-weight: bold;
        }

        h2 a:hover {
            color: #ff4c4c;
        }

        /* Trending Section (Top) */
        .new-release {
            margin-bottom: 30px;
        }

        .new-release .release {
            display: flex;
            gap: 20px; /* Khoảng cách giữa các thẻ phim */
            justify-content: flex-start; /* Căn trái cho các thẻ */
            flex-wrap: wrap; /* Nếu không đủ chỗ thì thẻ sẽ xuống dòng */
            padding-bottom: 10px;
        }

        .new-release .movie {
            flex: 0 0 auto;
            width: 350px; /* Đã tăng chiều rộng từ 260px lên 350px */
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            background-color: #1c1c1c;
            transition: transform 0.3s ease;
            display: flex;
            flex-direction: column; /* Đảm bảo nội dung nằm dọc */
            /* padding: 10px;  */
        }

        .new-release .movie:hover {
            transform: scale(1.05);
        }

        .new-release .movie img {
            width: 100%;
            height: 200px; /* Điều chỉnh chiều cao để ảnh không bị che khuất */
            object-fit: cover;
            display: block;
            border-radius: 8px;
        }

        .new-release .play-button {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 40px;
            color: white;
            background: rgba(0, 0, 0, 0.6);
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s ease;
        }

        .new-release .movie:hover .play-button {
            background: rgba(255, 0, 0, 0.8);
        }

        .new-release .movie h3 {
            margin: 10px 0 5px;
            font-size: 18px; /* Làm tên phim dễ đọc hơn */
            color: white;
            text-align: center;
            line-height: 1.3; 
        }

        .new-release .movie .genres {
            display: flex;
            justify-content: center;
            gap: 5px;
            flex-wrap: wrap;
            margin-bottom: 10px;
        }

        .new-release .movie .genre-tag {
            background-color: #ff0000;
            color: white;
            font-size: 12px;
            padding: 3px 8px;
            border-radius: 4px;
        }

        /* General Sections (Movies, etc.) */
        .section div {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); /* Điều chỉnh kích thước thẻ */
            gap: 20px; /* Khoảng cách giữa các thẻ */
        }

        .section .movie {
            background-color: #1c1c1c;
            border-radius: 8px;
            overflow: hidden;
            transition: transform 0.3s ease;
            display: flex;
            flex-direction: column;
            /* padding: 10px; */
        }

        .section .movie:hover {
            transform: scale(1.05);
        }

        .section .movie img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            display: block;
            /* border-radius: 8px; */
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .movie_title {
            height: 60px;
            text-align: center;
            margin-top: -10px;
        }

        .movie_title h3 {
            font-size: 16px;
            color: white;
            padding: 4px;
        }

        .section .watch-button {
            display: block;
            margin: 10px auto;
            padding: 8px 16px;
            background-color: red;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .section .watch-button:hover {
            background-color: #ff4c4c;
        }

        /* View All Links */
        .section h2 {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .section h2 a {
            font-size: 14px;
            text-decoration: none;
            color: #ff0000;
            font-weight: bold;
        }

        .section h2 a:hover {
            color: #ff4c4c;
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="section new-release">
            <h2>New Release - Movies</h2>
            <div class="release">
                <?php
                if (is_array($data['latestMovie']) && !empty($data['latestMovie'])) {
                    foreach ($data['latestMovie'] as $movie) {
                        echo "<div class='movie'>";
                        echo "<img src='" . htmlspecialchars($movie['poster']) . "' alt='" . htmlspecialchars($movie['title']) . "' />";
                        echo "<div class='play-button'>▶</div>";
                        echo "<div class='movie_title'>";
                        echo "<h3>" . htmlspecialchars($movie['title']) . "</h3>";
                        echo "</div>";
                        echo "<div class='genres'>";
                        foreach (explode(',', $movie['type_id']) as $genre) {
                            echo "<span class='genre-tag'>" . htmlspecialchars($genre) . "</span>";
                        }
                        echo "</div>";
                        echo "<a class='watch-button' href='watchMovie/show/" . htmlspecialchars($movie['movie_id']) . "'>▶ Watch movie</a>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>No new releases available.</p>"; // Message if no latest movies
                }
                ?>
            </div>
        </div>

        <div class="section">
            <h2>Romance</h2>
            <div class="romance">
                <?php
                if (!empty($data['romanceMovie'])) {
                    foreach ($data['romanceMovie'] as $movie) {
                        echo "<div class='movie'>";
                        echo "<a href='detail/show/" . htmlspecialchars($movie['movie_id']) . "'><img src='" . htmlspecialchars($movie['poster']) . "' alt='" . htmlspecialchars($movie['title']) . "' /></a>";
                        echo "<div class='movie_title'><h3>" . htmlspecialchars($movie['title']) . "</h3></div>";
                        echo "<a class='watch-button' href='watchMovie/show/" . htmlspecialchars($movie['movie_id']) . "'>▶ Watch movie</a>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>No romance movies available.</p>";
                }
                ?>
            </div>
        </div>

        <!-- Cartoon Section -->
        <div class="section">
            <h2>Cartoon</h2>
            <div class="cartoon">
                <?php
                if (!empty($data['cartoonMovie'])) {
                    foreach ($data['cartoonMovie'] as $movie) {
                        echo "<div class='movie'>";
                        echo "<a href='detail/" . htmlspecialchars($movie['movie_id']) . "'><img src='" . htmlspecialchars($movie['poster']) . "' alt='" . htmlspecialchars($movie['title']) . "' /></a>";
                        echo "<div class='movie_title'><h3>" . htmlspecialchars($movie['title']) . "</h3></div>";
                        echo "<a class='watch-button' href='watchMovie/show/" . htmlspecialchars($movie['movie_id']) . "'>▶ Watch movie</a>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>No cartoon movies available.</p>";
                }
                ?>
            </div>
        </div>

        <!-- Horror Section -->
        <div class="section">
            <h2>Horror</h2>
            <div class="horror">
                <?php
                if (!empty($data['horrorMovie'])) {
                    foreach ($data['horrorMovie'] as $movie) {
                        echo "<div class='movie'>";
                        echo "<a href='detail/show" . htmlspecialchars($movie['movie_id']) . "'><img src='" . htmlspecialchars($movie['poster']) . "' alt='" . htmlspecialchars($movie['title']) . "' /></a>";
                        echo "<div class='movie_title'><h3>" . htmlspecialchars($movie['title']) . "</h3></div>";
                        echo "<a class='watch-button' href='WatchMovie/show/" . htmlspecialchars($movie['movie_id']) . "'>▶ Watch movie</a>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>No horror movies available.</p>";
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>


