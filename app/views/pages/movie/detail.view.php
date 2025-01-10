<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!-- Bootstrap CSS -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="/WTB_PHP/public/css/Detail.css">
        <!-- Ionicons -->
        <script src="https://unpkg.com/ionicons@5.5.2/dist/ionicons.js"></script>
    <title>Detail Display</title>
</head>
<body> 
    <div class="detail-container" style="margin-top: -45px;">
        <div class="container mt-5">
            <div class="row mb-4">
                <div class="movie_card col-md-4">
                    <div class="img_card">
                        <img src="<?= htmlspecialchars( $data['movieId']['poster']) ?>" class="img-fluid" alt="Movie Image">
                    </div>
                <div class="btn_movie">
                        <a href="Movie/showById/<?= $data['movieId']['movie_id'] ?>" class="btn_dpl btn btn-danger">
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
                <?php if (is_array($data['relateMovie']) && !empty($data['relateMovie'])): ?>
                    <?php foreach ($data['relateMovie'] as $similarMovie): ?>
                        <?php if ($similarMovie['movie_id'] != $data['movieId']['movie_id']): ?>
                            <div class="col-md-3 mb-3">
                                <div class="card_detail card">
                                    <img src="<?= htmlspecialchars($similarMovie['poster']) ?>" class="card-img-top" alt="<?= htmlspecialchars($similarMovie['title']) ?>">
                                    <div class="card-body">
                                        <div class="card_item">
                                            <h5 class="card-title"><?= htmlspecialchars($similarMovie['title']) ?></h5>
                                        </div>
                                        <div class="btn_movie">
                                            <a href="Movie/showById/<?= htmlspecialchars($similarMovie['movie_id']) ?>" class="btn_dpl btn btn-danger">
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
                    <p>No similar movies found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
