<?php
class User extends Controller
{
    private $userModel;

    public function __construct() {
        $this->userModel = $this->model('UserModel');
    }
    public function show() {
        $this->view('master', [
            'Page' => 'user/profile',
            'movieList' => 'Movie List in here'
        ]);
    }

    public function profile() {
        $userId = $_SESSION['user_id'];
        $user = $this->userModel->getUserById($userId);


        $this->view('master', [
            'Page' => 'user/profile',
            'userInfo' => $user
        ]);
    }

public function register() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'register') {
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $password = $_POST['password']; // Mã hóa mật khẩu
        $defaultImage = 'logo.png'; // Ảnh mặc định

        // Lưu thông tin người dùng vào cơ sở dữ liệu
        $this->userModel->createUser($fullname, $email, $password, $defaultImage);

        // Chuyển hướng người dùng đến trang đăng nhập hoặc trang khác
        header('Location: login');
        exit();
    }

    // Render trang đăng ký nếu không phải là yêu cầu POST
    $this->view('master', [
        'Page' => 'user/register'
    ]);
}

public function update() {
    $userId = $_SESSION['user_id'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['user_name'];
        $email = $_POST['email'];
        $birth = $_POST['birth'];
        $image = null; // Khởi tạo biến hình ảnh

        // Kiểm tra dữ liệu từ input
        if (isset($_FILES['image'])) {
            var_dump($_FILES['image']); // Kiểm tra dữ liệu file
        }

        // Xử lý upload hình ảnh
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'C:/xampp/htdocs/WTB_PHP/public/images/avatar/';
            $image = time() . '_' . basename($_FILES['image']['name']);
            $uploadFilePath = $uploadDir . $image;

            if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadFilePath)) {
                echo "Error uploading image.";
                return;
            }
        } else {
            // Nếu không có hình ảnh mới, giữ lại hình ảnh cũ
            $currentUser = $this->userModel->getUserById($userId);
            $image = $currentUser['image']; // Giữ lại hình ảnh cũ
        }

        // Cập nhật thông tin người dùng
        if ($this->userModel->updateUser($userId, $name, $email, $image, $birth)) {
            // Cập nhật lại thông tin người dùng trong session
            $_SESSION['image'] = $image; // Lưu lại ảnh mới vào session nếu có
            header('Location: profile');
            exit();
        } else {
            error_log("Error updating user.");
            echo "Error updating user.";
        }
    }

    // Lấy thông tin người dùng để chỉnh sửa
    $user = $this->userModel->getUserById($userId);
    $this->view('master', [
        'Page' => 'user/profile',
        'user' => $user
    ]);
}

    public function delete($userId) {
        if ($this->userModel->deleteUser($userId)) {
            // Redirect to user list or show success message
            header('Location: /user/show');
        } else {
            // Handle error
            echo "Error deleting user.";
        }
    }

public function login() {
    $errorMessage = ''; // Khởi tạo biến thông báo lỗi

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = $this->userModel->authenticateUser($email, $password);
        if ($user) {
            // Set session or redirect
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['image'] = $user['image'];
            
            // Sử dụng phép so sánh == thay vì =
            if ($user['role'] == 'viewer') {
                header('Location: ' . dirname($_SERVER['PHP_SELF']) . '/home');
            } else {
                header('Location: ' . dirname($_SERVER['PHP_SELF']) . '/Admin');
            }
            exit(); // Dừng script sau khi redirect
        } else {
            // Gán thông báo lỗi nếu thông tin đăng nhập không hợp lệ
            $errorMessage = "Invalid email or password.";
        }
    } else {
        $errorMessage = 'Invalid request method.';
    }

    // Render login form với thông báo lỗi (nếu có)
    $this->view('master', [
        'Page' => 'user/login',
        'errorMessage' => $errorMessage // Truyền thông báo lỗi sang view
    ]);
}
    public function logout() {
        // Hủy phiên người dùng
        session_start(); // Bắt đầu phiên nếu chưa bắt đầu
        session_unset(); // Xóa tất cả các biến phiên
        session_destroy(); // Hủy phiên

        // Chuyển hướng người dùng về trang đăng nhập hoặc trang chủ
        header('Location: login'); // Hoặc 'home' tùy theo yêu cầu
        exit(); // Kết thúc script sau khi chuyển hướng
    }
        public function addCollection() {
            if (!isset($_SESSION['user_id'])) {
                echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
                return;
            }

            $userId = (int)$_SESSION['user_id']; // Lấy userId từ session
            $movieId = (int)$_POST['movie_id']; // Lấy movieId từ POST

            $result = $this->userModel->addCollection($movieId, $userId);

            if ($result) {
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Something went wrong']);
            }
    }
    public function showCollection(){
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
            return;
        }
        $userId = $_SESSION['user_id'];
        $collection = $this->userModel->getCollection($userId);
        $this->view('master', [
            'Page' => 'user/collection',
            'collection' => $collection,

        ]);
    }
        public function showHistory(){
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
            return;
        }
        $userId = $_SESSION['user_id'];
        $history = $this->userModel->getHistoryByUserId($userId);
        $this->view('master', [
            'Page' => 'user/history',
            'history' => $history,

        ]);
    }
}
?>