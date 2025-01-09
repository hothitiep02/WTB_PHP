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
        public function showMovieDetailsAdmin($movieId = null) {
            if ($movieId > 0) {
                $movie = $this->MovieModel->getMovieById($movieId);
                $comment = $this->MovieModel->getCommentsByMovieId($movieId);
                $views = $this->MovieModel->getMovieViews($movieId);
                $likes = $this->MovieModel->getMovieLike($movieId); 
                $this->view('master', [
                    'Page' => 'Admin/mvDetailManage',
                    'movieId' => $movie,
                    'comments' => $comment,
                    'likes' => $likes,
                    'views' => $views
                ]);
            } else {
                $this->view('master', [
                    'Page' => 'error',
                    'message' => 'Invalid movie ID.'
                ]);
            }
        }

        public function deleteComment($commentId, $movieId) {
            if ($this->MovieModel->deleteComment($commentId, $movieId)) {
                header("Location: /WTB_PHP/HomeAdmin/showMovieDetailsAdmin/" . htmlspecialchars($movieId));
                exit();
            } else {
                echo "Lỗi khi xóa bình luận.";
            }
        }

        public function addComment() {
            if (!isset($_SESSION['user_id'])) {
                echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
                return;
            }
        
            $userId = (int)$_SESSION['user_id']; 
            $movieId = (int)$_POST['movie_id']; 
            if (!isset($_POST['comment_text']) || empty(trim($_POST['comment_text']))) {
                echo json_encode(['status' => 'error', 'message' => 'Comment cannot be empty']);
                return;
            }
        
            $content = trim($_POST['comment_text']); 
            $result = $this->MovieModel->addComment($movieId, $userId, $content);
        
            if ($result) {
                echo json_encode(['status' => 'success', 'message' => 'Comment added successfully']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to add comment']);
            }
        }
    
    }

?>

