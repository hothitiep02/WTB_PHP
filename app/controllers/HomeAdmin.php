<?php
class HomeAdmin  extends Controller
{
    public $MovieModel;

    public function __construct()
    {
        $this->MovieModel = $this->model('MovieModel');
    }

    public function show() {
        $movies = $this->MovieModel->getAllMovies();
        $this->view('master', [
            'Page' => 'manageMovie',
            'movies' => $movies
        ]);
    }

        public function updateMovie()
    {
        if (!isset($_POST['movie_id'])) {
            echo "Product ID is missing.";
            exit();
        }

        $movieId = $_POST['movie_id'];
        $movieName = $_POST['title'] ?? '';
        $description = $_POST['description'];
        $movieUrl = $_POST['movie_url'] ?? '';
        $typeMovie = $_POST['type_id'] ?? '';
        $poster = $_POST['poster'] ?? ''; 

        $result = $this->MovieModel->updateMovie($movieId, $movieName, $description, $movieUrl, $typeMovie, $poster);

        if ($result) {
            echo "success";
        } else {
            echo "Error updating Movie.";
        }
    }
    
    public function deleteMovie() {
        if (!isset($_POST['movie_id'])) {
            echo "Movie ID is missing.";
            exit();
        }
        $movieId = $_POST['movie_id'];
        $result = $this->MovieModel->deleteMovie($movieId);

        if ($result) {
            echo "success";
        } else {
            echo "Error deleting movie.";
        }
    }

    public function addMovie(){
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $movieUrl = $_POST['movie_url'] ?? '';
        $typeId = $_POST['type_id'] ?? '';
        $poster = $_POST['poster'] ?? '';

        $result = $this->MovieModel->addMovie($title, $description, $movieUrl, $typeId, $poster);

        if ($result) {
            echo "success";
        } else {
            echo "Error adding movie.";
        }
    }
}
}
