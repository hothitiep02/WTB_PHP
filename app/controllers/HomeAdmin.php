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

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $movie_url = $_POST['movie_url'];
            $type_id = $_POST['type_id'];
            $poster = $_POST['poster'];
            $this->MovieModel->addMovie($title, $description, $movie_url, $type_id, $poster);
            header('Location: /movieController/index');
        }
    }

    public function updateMovie($movie_id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
            $title = $_POST['title'];
            $movie_url = $_POST['movie_url'];
            $poster = $_POST['poster'];
            $type_id = $_POST['type_id'];
            $updateSuccess = $this->MovieModel->updateMovie($movie_id, $title, $movie_url, $poster, $type_id);
            if ($updateSuccess) {
                header('Location: /HomeAdmin/show');
                exit;
            }
        }
        $movies = $this->MovieModel->getMovieById($movie_id);
        $this->view('master', [
            'Page' => 'manageMovie', 
            'movies' => $movies          
        ]);
    }
}
