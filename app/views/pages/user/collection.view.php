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
    max-width: 1200px;
    margin: auto;
    padding: 20px;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px; 
    
}

.movie {
    background-color: #000;
    border-radius: 8px;
    padding: 10px;
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

.movie-title {
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
    font-size: 18px;
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