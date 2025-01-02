<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/css/Detail.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Detail Display</title>
</head>
    <!-- Ionicons -->
    <script src="https://unpkg.com/ionicons@5.5.2/dist/ionicons.js"></script>
<body>
    <div class="container mt-5">
        <div class="row mb-4">
            <div class="movie_card col-md-4">
                <div class="img_card">
                    <img src="<?= htmlspecialchars( $data['movieId']['poster']) ?>" class="img-fluid" alt="Movie Image">
                </div>
               <div class="btn_movie">
                    <a href="watchMovie/show/<?= $data['movieId']['movie_id'] ?>" class="btn_dpl btn btn-danger">
                        <div class="btn_icon">
                            <ion-icon name="caret-forward-outline" style="font-size: 20px;"></ion-icon>
                            <span>Watch movie</span>
                        </div>
                    </a>
               </div>
            </div>
            <div class="col-md-8">
                <h1 class="card-title"><?= htmlspecialchars( $data['movieId']['title']) ?></h1>
                <p><strong>Description:</strong></p>
                <p><?= htmlspecialchars($data['movieId']['description']) ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h2>Similar movies</h2>
            </div>
            <?php if (is_array($relatedMovies) && !empty($relatedMovies)): ?>
                <?php foreach ($relatedMovies as $similar_movie): ?>
                    <?php if ($similar_movie['movie_id'] != $movieId): // Loại trừ phim hiện tại ?>
                        <div class="col-md-3 mb-3">
                            <div class="card_detail card">
                                <img src="<?= htmlspecialchars($similar_movie['poster']) ?>" class="card-img-top" alt="<?= htmlspecialchars($similar_movie['title']) ?>">
                                <div class="card-body">
                                    <div class="card_item">
                                        <h5 class="card-title"><?= htmlspecialchars($similar_movie['title']) ?></h5>
                                    </div>
                                    <div class="btn_movie">
                                        <a href="watch_movie.php?movie_id=<?= $movie['movie_id'] ?>" class="btn_dpl btn btn-danger">
                                            <div class="btn_icon">
                                                <ion-icon name="caret-forward-outline" style="font-size: 20px;"></ion-icon>
                                                <span>Watch movie</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Không có phim tương tự nào.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-1Z5bWn0Q3uHq0v3C5G6o74zQ6T1T4p1cl8k6D2jJ4hU5e9G5s2W0T5QwEBRz3A5R" crossorigin="anonymous"></script>
</body>
</html>