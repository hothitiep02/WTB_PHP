<?php
class Admin  extends Controller
{
    public $MovieModel;
    public $UserModel;

    public function __construct()
    {
        $this->MovieModel = $this->model('MovieModel');
        $this->UserModel = $this->model('UserModel');
    }

    public function showMovieAdmin() {
        $movies = $this->MovieModel->getAllMovies();
        $this->view('master', [
            'Page' => 'admin/MovieManage',
            'movies' => $movies
        ]);
    }

    public function showUserAdmin() {
        $users = $this->UserModel->getUsers();
        if (!empty($users)) {
            $this->view('master', [
                'Page' => 'admin/UserManage',
                'users' => $users,
            ]);
        } else {
            $this->view('master', [
                'Page' => 'error',
                'message' => 'No users found in the database.'
            ]);
        }
    }
    
    public function show() {
        $this->showMovieAdmin(); // Mặc định hiển thị danh sách phim
    }

    public function deleteUser($userId) {
        if ($this->UserModel->deleteUser($userId)) {
            header("Location: /WTB_PHP/Admin/showUserAdmin");
            exit();
        } else {
            echo "Lỗi khi xóa bình luận.";
        }
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
            header("Location: /WTB_PHP/Admin/show/updateMovie/$movieId");
            exit();
        } else {
            $this->view('master', [
                'Page' => 'MovieManage',
                'error' => 'Error updating Movie.'
            ]);
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
            header("Location: /WTB_PHP/Admin/show/deleteMovie");
            exit();
        } else {
            $this->view('master', [
                'Page' => 'MovieManage',
                'error' => 'Error deleting movie.'
            ]);
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
                header("Location: /WTB_PHP/Admin/show/addMovie");
                exit();
            } else {
                $this->view('master', [
                    'Page' => 'MovieManage',
                    'error' => 'Error adding movie.'
                ]);
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
                'Page' => 'admin/MovieDetailManage',
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
            header("Location: /WTB_PHP/Admin/showMovieDetailsAdmin/" . htmlspecialchars($movieId));
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





    
