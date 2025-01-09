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
            // Chuyển hướng lại trang chi tiết phim sau khi xóa thành công
            header("Location: /WTB_PHP/HomeAdmin/showMovieDetailsAdmin/" . htmlspecialchars($movieId));
            exit();
        } else {
            echo "Lỗi khi xóa bình luận.";
        }
    }

    public function addComment() {
        // Kiểm tra sự tồn tại của user_id trong session
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
            return;
        }
    
        $userId = (int)$_SESSION['user_id']; 
        $movieId = (int)$_POST['movie_id']; 
    
        // Kiểm tra xem comment_text có tồn tại và không rỗng không
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
