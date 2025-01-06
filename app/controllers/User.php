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
        echo $userId;
        $user = $this->userModel->getUserById($userId);

        $this->view('master', [
            'Page' => 'user/profile',
            'userInfo' => $user
        ]);
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['fullname'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            if ($this->userModel->createUser($name, $email, $password)) {
                // Redirect to user list or show success message
                header('Location: user/login');
            } else {
                // Handle error
                echo "Error creating user.";
            }
        }

        // Render form view for creating user
        $this->view('master', [
            'Page' => 'user/register'
        ]);
    }

    public function update($userId) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];

            if ($this->userModel->updateUser($userId, $name, $email)) {
                // Redirect to user list or show success message
                header('Location: /home');
            } else {
                // Handle error
                echo "Error updating user.";
            }
        }

        // Get user info for editing
        $user = $this->userModel->getUserById($userId);
        $this->view('master', [
            'Page' => 'auth/profile',
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = $this->userModel->authenticateUser($email, $password);
            if ($user) {
                // Set session or redirect
                $_SESSION['user_id'] = $user['user_id'];
                header('Location: home');
            } else {
                // Handle login failure
                echo "Invalid credentials.";
            }
        }

        // Render login form
        $this->view('master', [
            'Page' => 'user/login'
        ]);
    }
}
?>