<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <base href="http://localhost/WTB_PHP/"> -->
    <link rel="stylesheet" href="../../../public/css/Home.css">
    <title>Movie List</title>
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
                        echo "<a class='watch-button' href='Movie/showById/" . htmlspecialchars($movie['movie_id']) . "'>▶ Watch movie</a>";
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
                        echo "<a href='Movie/showDetail/" . htmlspecialchars($movie['movie_id']) . "'><img src='" . htmlspecialchars($movie['poster']) . "' alt='" . htmlspecialchars($movie['title']) . "' /></a>";
                        echo "<div class='movie_title'><h3>" . htmlspecialchars($movie['title']) . "</h3></div>";
                        echo "<a class='watch-button' href='Movie/showById/" . htmlspecialchars($movie['movie_id']) . "'>▶ Watch movie</a>";
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
                        echo "<a href='Movie/showDetail/" . htmlspecialchars($movie['movie_id']) . "'><img src='" . htmlspecialchars($movie['poster']) . "' alt='" . htmlspecialchars($movie['title']) . "' /></a>";
                        echo "<div class='movie_title'><h3>" . htmlspecialchars($movie['title']) . "</h3></div>";
                        echo "<a class='watch-button' href='Movie/showById/" . htmlspecialchars($movie['movie_id']) . "'>▶ Watch movie</a>";
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
                        echo "<a href='Movie/showDetail/" . htmlspecialchars($movie['movie_id']) . "'><img src='" . htmlspecialchars($movie['poster']) . "' alt='" . htmlspecialchars($movie['title']) . "' /></a>";
                        echo "<div class='movie_title'><h3>" . htmlspecialchars($movie['title']) . "</h3></div>";
                        echo "<a class='watch-button' href='Movie/showById/" . htmlspecialchars($movie['movie_id']) . "'>▶ Watch movie</a>";
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


