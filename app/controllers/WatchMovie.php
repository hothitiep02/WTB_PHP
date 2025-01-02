<?php
class WatchMovie extends Controller
{
    public $MovieModel;
    public function __construct(){
        $this->MovieModel = $this->model('MovieModel');
    }
    public function show($movieId = null) {
        // Ensure the ID is valid before proceeding
        if ($movieId > 0) {
            $movie = $this->MovieModel->getMovieById($movieId);
            $this->view('master', [
                'Page' => 'watchMovie',
                'movieId' => $movie
            ]);
        } else {
            // Handle the case where the ID is invalid
            $this->view('master', [
                'Page' => 'error',
                'message' => 'Invalid movie ID.'
            ]);
        }
    }
}