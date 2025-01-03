<?php
class Movie extends Controller
{
    public $MovieModel;
    public function __construct()
    {
        $this->MovieModel = $this->model('MovieModel');
    }
    public function show() {
        $this->view('master', [
            'Page' => 'movie',
            'movieList' => 'Movie List in here'
        ]);
    }
    public function showById($movieId = null) {
        // Ensure the ID is valid before proceeding
        echo $movieId;
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
    public function showDetail($movieId = null, $typeId = null) {

        if ($movieId && $typeId) {
            $movie = $this->MovieModel->getMovieById($movieId);
            $relateMovies = $this->MovieModel->getRelatedMovies($movieId, $typeId);
            $this->view('master', [
                'Page' => 'detail',
                'movieId' => $movie,
                'relateMovie' =>  $relateMovies
            ]);
        } else {
            // Trả về lỗi khi tham số không hợp lệ
            $this->view('master', [
                'Page' => 'error',
                'message' => 'Movie ID or Type ID is invalid.'
            ]);
        }
    }
    
}
?>
