<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
</head>
<style>
body {
    background-color: black;
}

.main-content {
    padding: 30px 50px;
}

.add-btn {
    background-color: #d9534f;
    color: white;
    border: none;
    padding: 5px 10px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
}

.table {
    table-layout: fixed;
    width: 100%;
    border: 2px solid black;
    border-collapse: collapse;
}

.table th, .table td {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    text-align: center;    
    vertical-align: middle;
    padding: 10px;
}

#movieTable th:nth-child(5), #movieTable td:nth-child(5) {
    text-align: left;   
    vertical-align: top;  
    white-space: normal;  
    word-wrap: break-word; 
}

#movieTable th:nth-child(3), #movieTable td:nth-child(3) {
    white-space: normal;  
    word-wrap: break-word;
}

#movieTable th:nth-child(2), #movieTable td:nth-child(2) {
    width: 200px;
    white-space: normal;
    word-wrap: break-word;
}

#movieTable th:nth-child(6), #movieTable td:nth-child(6) {
    width: 130px;
    white-space: normal; 
    word-wrap: break-word;
}

#movieTable th:nth-child(1), #movieTable td:nth-child(1) {
    width: 40px;
}

#movieTable th:nth-child(2), #movieTable td:nth-child(2) {
    width: 200px;
}

#movieTable th:nth-child(3), #movieTable td:nth-child(3) {
    width: 250px;
}

#movieTable th:nth-child(4), #movieTable td:nth-child(4) {
    width: 200px;
}

#movieTable th:nth-child(5), #movieTable td:nth-child(5) {
    width: 300px;
}

#movieTable th:nth-child(6), #movieTable td:nth-child(6) {
    width: 130px;
}
.btn_ud button {
    display: block;
    margin-bottom: 10px;
    width: 100px;
}

.img-thumbnail {
    height: 100px;
}

.text-center {
    color: white;
}

.btn-form button, input, a{
    display: flex;
    flex-direction: column;
    margin-bottom: 8px;
    width: 80px;
    margin-left: 30px;
    align-items: center;
}

.form_update div{
    display: flex;
    flex-direction: column;
    align-items: center;
}

.create-movie-container {
    background-color: #111;
    padding: 40px;
    border-radius: 10px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
    width: 700px;
    text-align: center;
    position: absolute;
    top: 200px;
    left: 200px;
    
}

.create-movie-container img {
    width: 50px;
    margin-bottom: 20px;
}

.create-movie-container h1 {
    font-size: 30px;
    margin-bottom: 20px;
    color:white;
}

.create-movie-container input, textarea {
    width: 600px;
    padding: 20px;
    margin: 20px 0;
    border-radius: 5px;
    border: none;
    font-size: 18px;
    
}

.create-movie-container input[type="text"], 
.create-movie-container input[type="url"] {
    background-color:white;
    color: black;
}

.create-movie-container button {
    width: 100px;
    padding: 10px;
    background-color: #ffd700;
    color: #000;
    border: none;
    border-radius: 5px;
    font-size: 22px;
    cursor: pointer;
}

.create-movie-container button:hover {
    background-color: #ffcc00;
}
.head{
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 30px;
    /* flex-direction: column; */
    display: flex;
}
#description{
    margin-top: 0px;
}

.main-content{
    position: relative;
}
#closeUpdateForm{
    background-color: gray;
    margin-left: 15px;
}
</style>
<body>
    <div class="main-content">
        <div id="movieManagement" class="hidden">
            <h1 class="text-center">Movie management</h1>
            <button id="createMovieBtn" class="add-btn btn my-3" data-bs-toggle="modal" data-bs-target="#addMovieModal">Add</button>
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
                                                <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#updateMovieModal' data-id='{$movie['movie_id']}' data-title='{$movie['title']}' data-url='{$movie['movie_url']}' data-poster='{$movie['poster']}' data-type='{$movie['type_id']}'>Update</button>
                                                <button class='btn btn-danger'>Delete</button>
                                                <a href='movie-detail.php?movie_id={$movie['movie_id']}' class='btn btn-danger'>Detail</a>
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
<script>
    var updateMovieModal = document.getElementById('updateMovieModal');
    updateMovieModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget; // Nút "Update"
        var movieId = button.getAttribute('data-id');
        var title = button.getAttribute('data-title');
        var description= button.getAttribute('data-description');
        var movieUrl = button.getAttribute('data-url');
        var poster = button.getAttribute('data-poster');
        var typeId = button.getAttribute('data-type');


        var modalTitle = updateMovieModal.querySelector('.modal-title');
        var movieIdInput = updateMovieModal.querySelector('#movie_id');
        var titleInput = updateMovieModal.querySelector('#title');
        var descriptionInput = updateMovieModal.querySelector('#description');
        var urlInput = updateMovieModal.querySelector('#movie_url');
        var posterInput = updateMovieModal.querySelector('#poster');
        var typeSelect = updateMovieModal.querySelector('#type_id');

        modalTitle.textContent = 'Update Movie - ' + title;
        movieIdInput.value = movieId;
        titleInput.value = title;
        descriptionInput.value=description;
        urlInput.value = movieUrl;
        posterInput.value = poster;
        typeSelect.value = typeId;
    });

</script>

</body>
</html>
