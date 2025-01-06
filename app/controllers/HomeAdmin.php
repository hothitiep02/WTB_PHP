<?php
class HomeAdmin  extends Controller
{
    public $MovieModel;

    public function __construct()
    {
        $this->MovieModel = $this->model('MovieModel');
    }

// public function show() {
//     $movies = $this->MovieModel->getAllMovies();

//     // Truyền dữ liệu bằng cách sử dụng extract
//     extract([
//         'movies' => $movies
//     ]);

//     // Include file view
//     require 'C:/xamppp/htdocs/WTB_PHP/app/views/pages/manageMovie.view.php';
// }

public function show() {
    $movies = $this->MovieModel->getAllMovies();
    $this->view('master', [
        'Page' => 'manageMovie',
        'movies' => $movies
    ]);
}

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $movie_url = $_POST['movie_url'];
            $type_id = $_POST['type_id'];
            $poster = $_POST['poster'];

            // Call the model method to add the movie
            $this->MovieModel->addMovie($title, $description, $movie_url, $type_id, $poster);

            // Redirect to the movie management page after adding
            header('Location: /movieController/index');
        }
    }

    // Update an existing movie
    public function update($movie_id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $movie_url = $_POST['movie_url'];
            $type_id = $_POST['type_id'];
            $poster = $_POST['poster'];

            // Call the model method to update the movie
            $this->MovieModel->updateMovie($movie_id, $title, $description, $movie_url, $type_id, $poster);

            // Redirect to the movie management page after updating
            header('Location: /movieController/index');
        }

        // Get the movie details by ID to show in the update form
        $movie = $this->MovieModel->getMovieById($movie_id);

        // Load the update view and pass the movie data to it
        $this->view('master', [
            'Page' => 'update_movie',
            'movie' => $movie
        ]);
    }

    // Delete a movie
    public function delete($movie_id)
    {
        // Call the model method to delete the movie
        $this->MovieModel->deleteMovie($movie_id);

        // Redirect to the movie management page after deleting
        header('Location: /movieController/index');
    }
}
