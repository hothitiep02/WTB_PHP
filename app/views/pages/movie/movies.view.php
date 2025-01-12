<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
<style>
.movie-page {
    font-family: Arial, sans-serif;
    background-color:rgba(0, 0, 0, 0.84);
    display: flex;
}

.movie-page form {
    background-color: #343a40;
    padding: 10px 20px;
    display: flex;
    flex-direction: column;
    gap: 15px;
}
.movie-page h3 {
    color: yellow;
    margin: 0; 
    margin-right: 20px; 
    font-size:20px;
}
.movie-page h4 {
    color: white;
    margin: 0; 
    margin-right: 20px; 
    font-size:20px;
    height: 80px;
    display: flex;
    justify-content: center;
    align-items: center;
}
.movie-page label {
    color: yellow; 
    margin-right: 20px;
    display: flex;
    gap: 10px;
    font-size: 18px;
    
}
.movie-page button {
    padding: 10px 15px;
    background-color: #007bff; 
    color: white;
    font-size: 20px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
}
.movie-page button:hover {
    background-color: #0056b3;
}
.movie-page .movie-container {
    max-width: 1150px;
    margin: auto;
    padding: 20px;
}
.movie-page .section {
    margin-bottom: 40px;
}
.movie-page .release {
    display: flex;
    flex-wrap: wrap;
}
.movie-page .movie {
    background-color: black;
    border-radius: 8px;
    padding: 10px;
    margin-top: 20px;
    margin: 10px;
    width: 250px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s;
    position: relative;
}

.movie-page .movie:hover {
    transform: scale(1.05);
}

.movie-page .movie img {
    width: 100%;
    border-radius: 4px;
    height: 200px; 
    object-fit: cover; 
}

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

.movie-page .movie_title {
    text-align: center;
    margin: 10px 0;
}

.movie-page .watch-button {
    display: inline-block;
    padding: 8px 16px;
    background-color: red;
    color: white;
    text-decoration: none;
    border-radius: 4px;
    text-align: center;
    font-size: 16px;
    margin-left: 40px;
}

.movie-page .watch-button:hover {
    background-color: #0056b3;
}

@media (max-width: 768px) {
    .movie-page .movie {
        width: calc(50% - 20px); 
    }
}

@media (max-width: 480px) {
    .movie-page .movie {
        width: 100%; 
    }
}
h2 {
    font-size: 35px;
    color: white;
}

</style>
</head>
<body>
    <div class="movie-page">
        <form action="Movie/filterByGenre" method="POST" class="filter">
            <h3>Select Genre:</h3>
            <?php
            foreach ($data['genres'] as $genre) {
                echo "<label>";
                echo "<input type='radio' name='genre' value='" . htmlspecialchars($genre['type_id']) . "'>";
                echo htmlspecialchars($genre['type_name']);
                echo "</label>";
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
                            echo "<h4>" . htmlspecialchars($movie['title']) . "</h4>";
                            echo "</div>";
                            echo "<a class='watch-button' href='Movie/showById/" . htmlspecialchars($movie['movie_id']) . "'>▶ Watch movie</a>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>No movie available.</p>"; 
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>