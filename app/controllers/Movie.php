<?php
class Movie extends Controller
{
    public $MovieModel;
    public function __construct()
    {
        $this->MovieModel = $this->model('MovieModel');
    }
    public function show() {
        $genres = $this->MovieModel->getAllGenres();
        $allMovie = $this->MovieModel->getAllMovies();
        $this->view('master', [
            'Page' => 'movie/movies',
            'movieList' => $allMovie,
            'genres' => $genres
        ]);
    }
    public function showById($movieId = null) {
        // Chuyển đổi movieId sang kiểu int
        $movieId = (int)$movieId; // Sử dụng giá trị từ tham số truyền vào

        // Kiểm tra sự tồn tại của user_id trong session
        if (isset($_SESSION['user_id'])) {
            $userId = (int)$_SESSION['user_id'];
        } else {
            // Xử lý trường hợp không có user_id trong session
            $this->view('master', [
                'Page' => 'error',
                'message' => 'User ID is not set in session.'
            ]);
            return;
    }

    // Đảm bảo ID hợp lệ trước khi tiếp tục
    if ($movieId > 0) {
        $_SESSION['movieId'] = $movieId;  // Lưu vào session
        $movie = $this->MovieModel->getMovieById($movieId);

        if ($movie === null) {
            // Xử lý trường hợp không tìm thấy phim
            $this->view('master', [
                'Page' => 'error',
                'message' => 'Movie not found.'
            ]);
            return;
        }

            $this->MovieModel->addView($movieId);
            $views = $this->MovieModel->getMovieViews($movieId);
            $likes = $this->MovieModel->getMovieLike($movieId); // Không gọi addLike ở đây
            $history = $this->MovieModel->addHistory($movieId, $userId);
            $liked = $this->MovieModel->checkLike($userId, $movieId);
            $addedCollection = $this->MovieModel->checkCollection($userId, $movieId);
            $comment = $this->MovieModel->getCommentsByMovieId($movieId);
            $this->view('master', [
                'Page' => 'movie/watchMovie',
                'movieId' => $movie,
                'views' => $views,
                'likes' => $likes,
                'isLiked'=>$liked,
                'isAdded'=>$addedCollection,
                'comments' => $comment
            ]);
        } else {
            // Xử lý trường hợp ID không hợp lệ
            $this->view('master', [
                'Page' => 'error',
                'message' => 'Invalid movie ID.'
            ]);
        }
    }
    public function addLike() {
        // Kiểm tra sự tồn tại của user_id trong session
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
            return;
        }

        $userId = (int)$_SESSION['user_id']; 
        $movieId = (int)$_POST['movie_id']; 

        // Thêm hoặc xóa lượt thích
        $result = $this->MovieModel->addLike($userId, $movieId);

        if ($result) {
            echo 'success!!!';
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Something went wrong']);
        }
    }

    public function showDetail($movieId = null, $typeId = null) {
        if ($movieId && $typeId) {
            $movie = $this->MovieModel->getMovieById($movieId);
            $relateMovies = $this->MovieModel->getRelatedMovies($movieId, $typeId);
            $detailView = $this->MovieModel->getMovieViews($movieId);
            $this->view('master', [
                'Page' => 'movie/detail',
                'movieId' => $movie,
                'relateMovie' =>  $relateMovies,
                'detView' => $detailView,
            ]);
        } else {
            $this->view('master', [
                'Page' => 'error',
                'message' => 'Movie ID or Type ID is invalid.'
            ]);
        }
    }
public function addComment() {
    // Kiểm tra sự tồn tại của user_id trong session
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
        return;
    }

    $userId = (int)$_SESSION['user_id']; // Lấy userId từ session
    $movieId = (int)$_POST['movie_id']; // Lấy movieId từ POST

    // Kiểm tra xem comment_text có tồn tại và không rỗng không
    if (!isset($_POST['comment_text']) || empty(trim($_POST['comment_text']))) {
        echo json_encode(['status' => 'error', 'message' => 'Comment cannot be empty']);
        return;
    }

    $content = trim($_POST['comment_text']); // Lấy nội dung bình luận từ POST

    // Thêm bình luận
    $result = $this->MovieModel->addComment($movieId, $userId, $content);

    if ($result) {
        echo json_encode(['status' => 'success', 'message' => 'Comment added successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add comment']);
    }
}
    public function filterByGenre() {
        $genres = $this->MovieModel->getAllGenres();
        if (isset($_POST['genre'])) {
            $genreId = (int)$_POST['genre']; // Lấy genre_id từ POST
            $movies = $this->MovieModel->filterMoviesByGenre($genreId);
            
            $this->view('master', [
                'Page' => 'movie/movies',
                'movieList' => $movies,
                'genres' => $genres

            ]);
        } else {
            // Nếu không có genre được chọn, có thể hiển thị tất cả phim
            $this->show();
        }
    }
    public function search() {
        $genres = $this->MovieModel->getAllGenres();

        if (isset($_POST['search_term'])) {
            $searchTerm = $_POST['search_term'];
            $movies = $this->MovieModel->searchMoviesByName($searchTerm);
            
            $this->view('master', [
                'Page' => 'movie/movies',
                'movieList' => $movies,
                'genres' => $genres

            ]);
        } else {
            $this->show(); // Hiện thị tất cả nếu không có tìm kiếm
        }
    }
}
?>

