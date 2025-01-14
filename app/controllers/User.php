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
        $password = $_POST['password'];
        $defaultImage = 'Avata_default.jpg'; 
        $this->userModel->createUser($fullname, $email, $password, $defaultImage);
        header('Location: login');
        exit();
    }
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
        $image = null; 
        if (isset($_FILES['image'])) {
            var_dump($_FILES['image']);
        }

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'C:/xamppp/htdocs/WTB_PHP/public/images/avatar/';
            $image = time() . '_' . basename($_FILES['image']['name']);
            $uploadFilePath = $uploadDir . $image;

            if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadFilePath)) {
                echo "Error uploading image.";
                return;
            }
        } else {
            $currentUser = $this->userModel->getUserById($userId);
            $image = $currentUser['image']; 
        }
        if ($this->userModel->updateUser($userId, $name, $email, $image, $birth)) {
            $_SESSION['image'] = $image;
            header('Location: profile');
            exit();
        } else {
            error_log("Error updating user.");
            echo "Error updating user.";
        }
    }
    $user = $this->userModel->getUserById($userId);
    $this->view('master', [
        'Page' => 'user/profile',
        'user' => $user
    ]);
}

    public function delete($userId) {
        if ($this->userModel->deleteUser($userId)) {
            header('Location: /user/show');
        } else {
            echo "Error deleting user.";
        }
    }

public function login() {
    $errorMessage = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = $this->userModel->authenticateUser($email, $password);
        if ($user) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['image'] = $user['image'];
            if ($user['role'] == 'viewer') {
                header('Location: ' . dirname($_SERVER['PHP_SELF']) . '/home');
            } else {
                header('Location: ' . dirname($_SERVER['PHP_SELF']) . '/Admin');
            }
            exit(); 
        } else {
            $errorMessage = "Invalid email or password.";
        }
    } else {
        $errorMessage = 'Invalid request method.';
    }
    $this->view('master', [
        'Page' => 'user/login',
        'errorMessage' => $errorMessage
    ]);
}
    public function logout() {
        session_start();
        session_unset(); 
        session_destroy();
        header('Location: login'); 
        exit();
    }
        public function addCollection() {
            if (!isset($_SESSION['user_id'])) {
                echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
                return;
            }

            $userId = (int)$_SESSION['user_id']; 
            $movieId = (int)$_POST['movie_id'];

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