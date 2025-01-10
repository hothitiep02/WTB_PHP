<?php
class Home extends Controller
{
    // Đang làm về cái phần lấy giá của sản phẩmphẩm
    public $ProductModel;

    public function __construct()
    {
        $this->ProductModel = $this->model('MovieModel');
    }
    // Hàm này luôn được khởi chạy đầu tiền khi tạo một đối tượng
    public function show() {

        $latestMovies = $this->ProductModel->getLatestMovies();
        $romanceMovie = $this->ProductModel->getMoviesByGenre(1);
        $cartoonMovie = $this->ProductModel->getMoviesByGenre(2);
        $horrorMovie = $this->ProductModel->getMoviesByGenre(3);

        // Chuyển dữ liệu vừa mới lấy được từ Model
        $this->view('master', [
            // Dữ liệu mà mình muốn truyền vào Page của mình
            // Luôn luôn truyền trang mà mình mong muốn sẽ hiển thị ở đây
            'Page' => 'movie/home',
            'latestMovie' => $latestMovies,
            'romanceMovie' => $romanceMovie,
            'cartoonMovie' => $cartoonMovie,
            'horrorMovie' =>  $horrorMovie,
        ]);
        
    }

}
?>
