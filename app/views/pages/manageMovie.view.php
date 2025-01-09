

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/WTB_PHP/public/css/manageMovie.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
</head>

<body>
    <div class="main-content">
        <div id="movieManagement" class="hidden">
            <h1 class="text-center">Movie management</h1>
            <button id="createMovieBtn" class="add-btn btn my-3 add" data-bs-toggle="modal" data-bs-target="#addMovieModal">Add</button>
            <table id="movieTable" class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Movie URL</th>
                        <th>Poster</th>
                        <th>Create_at</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody id="movieTableBody">
                    <?php
                        if (!empty($data['movies']) && is_array($data['movies'])) {
                            foreach ($data['movies'] as $movie) {
                                echo "
                                    <tr>
                                        <td>{$movie['movie_id']}</td>
                                        <td>{$movie['title']}</td>
                                        <td>{$movie['movie_url']}</td>
                                        <td><img src='{$movie['poster']}' class='img-thumbnail' alt='Image of {$movie['title']}'></td>
                                        <td>{$movie['created_at']}</td>
                                        <td>
                                            <form action='./HomeAdmin/deleteMovie' method='POST' style='display:inline;' class='btn-form'>
                                                <input type='hidden' name='movie_id' value='{$movie['movie_id']}'>
                                                <!-- Modal Trigger -->
                                                <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#updateMovieModal' data-id='{$movie['movie_id']}' data-title='{$movie['title']}' data-description='{$movie['description']}' data-url='{$movie['movie_url']}' data-poster='{$movie['poster']}' data-type='{$movie['type_id']}'>Update</button>
                                                <button class='btn btn-danger'>Delete</button>
                                               <a href='HomeAdmin/showMovieDetailsAdmin/" . htmlspecialchars($movie["movie_id"]) . "' class='btn btn-secondary'>Detail</a>

                                            </form>
                                        </td>
                                    </tr>
                                ";
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center'>No movies found.</td></tr>";
                        }   
                    ?>
                </tbody>


            </table>
        </div>
    </div>
    

    <div class="modal fade" id="updateMovieModal" tabindex="-1" aria-labelledby="updateMovieModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateMovieModalLabel">Update Movie</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="updateMovieForm" method="POST" action="./HomeAdmin/updateMovie">
                        <input type="hidden" name="movie_id" id="movie_id">
                        <div class="mb-3">
                            <label for="title" class="form-label">Movie Title</label>
                            <input type="text" class="form-control" name="title" id="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" class="form-control" name="description" id="description" required>
                        </div>
                        <div class="mb-3">
                            <label for="movie_url" class="form-label">Movie URL</label>
                            <input type="text" class="form-control" name="movie_url" id="movie_url" required>
                        </div>
                        <div class="mb-3">
                            <label for="poster" class="form-label">Poster URL</label>
                            <input type="text" class="form-control" name="poster" id="poster" required>
                        </div>
                    
                        <div class="mb-3">
                            <label for="type_id" class="form-label">Genre</label>
                            <select class="form-select" name="type_id" id="type_id" required>
                                <option value="1">Tình cảm</option>
                                <option value="2">Hoạt hình</option>
                                <option value="3">Kinh dị</option>
                                <option value="4">Hài</option>
                                <option value="5">Khoa học viễn tưởng</option>
                                <option value="6">Âm nhạc</option>
                                <option value="7">võ thuật</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" name="update">Update Movie</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="addMovieModal" tabindex="-1" aria-labelledby="addMovieModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMovieModalLabel">Add Movie</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addMovieForm" method="POST" action="./HomeAdmin/addMovie">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" name="title" id="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" class="form-control" name="description" id="description" required>
                        </div>
                        <div class="mb-3">
                            <label for="movie_url" class="form-label">Movie Url</label>
                            <input type="text" class="form-control" name="movie_url" id="movie_url" required>
                        </div>
                        <div class="mb-3">
                            <label for="poster" class="form-label">Poster Url</label>
                            <input type="text" class="form-control" name="poster" id="poster" required>
                        </div>
                        <div class="mb-3">
                            <label for="type_id" class="form-label">Thể Loại</label>
                            <select class="form-select" name="type_id" id="type_id" required>
                                <option value="1">Tình cảm</option>
                                <option value="2">Hoạt hình</option>
                                <option value="3">Kinh dị</option>
                                <option value="4">Hài</option>
                                <option value="5">Khoa học viễn tưởng</option>
                                <option value="6">Âm nhạc</option>
                                <option value="7">Võ thuật</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" name="add">Add Movie</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="/WTB_PHP/public/js/manageMovie.js"></script>

</body>
</html>
