<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
body{
    background-color: rgba(0, 0, 0, 0.84);
}
.movie-container {
    max-width: 100%;
    margin: auto;
    padding: 20px 100px;
    display: flex;
    flex-wrap: wrap; 
    justify-content: space-between;
    color: white;
}

.movie {
    background-color: black;
    border: 1px solid black;
    border-radius: 8px;
    padding: 10px;
    margin: 10px 0;
    width: calc(25% - 20px);
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s;
    display: flex;
    flex-direction: column;
    height: 400px;
}

.movie:hover {
    transform: scale(1.05);
}

.movie img {
    width: 100%;
    border-radius: 4px;
    height: 200px; 
    object-fit: cover;
}

.movie_title {
    text-align: center;
    margin: 10px 0;
    flex-grow: 1;
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
    font-size: 16px;
    width: 170px;
    margin-left: 35px;
}

.watch-button:hover {
    background-color: red;
}
h2{
    margin-left: 100px;
    color:white;
}

</style>
</head>
<body>
    <h2>Collection</h2>
    <div class="movie-container">
                <?php
                if (is_array($data['collection']) && !empty($data['collection'])) {
                    foreach ($data['collection'] as $movie) {
                        echo "<div class='movie'>";
                        echo "<img src='" . htmlspecialchars($movie['poster']) . "' alt='" . htmlspecialchars($movie['title']) . "' />";
                        echo "<div class='movie_title' style='color: white;'>";
                        echo "<h3>" . htmlspecialchars($movie['title']) . "</h3>";
                        echo "</div>";
                        echo "<a class='watch-button' href='Movie/showById/" . htmlspecialchars($movie['movie_id']) . "'>▶ Watch movie</a>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>No movie added!!.</p>"; 
                }
                ?>
        </div>
</body>
</html>