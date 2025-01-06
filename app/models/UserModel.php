<?php
class UserModel extends Controller {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getUsers() {
        $query = "SELECT * FROM users";
        $result = mysqli_query($this->db->conn, $query);
        
        $users = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $users[] = $row;
        }
        return $users;
    }

    public function getUserById($userId) {
        $query = "SELECT * FROM users WHERE user_id = ?";
        $stmt = $this->db->conn->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    public function addCollection($userId,$movieId) {
        $query = "INSERT INTO collections (movie_id, user_id) VALUES ( ?, ?)";
        $stmt = $this->db->conn->prepare($query);
        $stmt->bind_param("ii", $userId,$movieId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    public function getCollection($userId){
        $query = "SELECT c.collection_id, m.title, m.poster FROM collections c JOIN movies m ON c.movie_id = m.movie_id WHERE c.user_id = ?";
        $stmt = $this->db->conn->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function createUser($name, $email, $password) {
        $query = "INSERT INTO users (user_name, email, password) VALUES (?, ?, ?)";
        $stmt = $this->db->conn->prepare($query);
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt->bind_param("sss", $name, $email, $hashedPassword);
        return $stmt->execute();
    }

    public function updateUser($userId, $name, $email) {
        $query = "UPDATE users SET name = ?, email = ? WHERE user_id = ?";
        $stmt = $this->db->conn->prepare($query);
        $stmt->bind_param("ssi", $name, $email, $userId);
        return $stmt->execute();
    }

    public function deleteUser($userId) {
        $query = "DELETE FROM users WHERE user_id = ?";
        $stmt = $this->db->conn->prepare($query);
        $stmt->bind_param("i", $userId);
        return $stmt->execute();
    }

    public function authenticateUser($email, $password) {
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->db->conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        
        if ($user && password_verify($password, $user['password'])) {
            return $user; // Đăng nhập thành công
        }
        return false; // Đăng nhập thất bại
    }

    // Các phương thức khác tương tác với cơ sở dữ liệu
}
?>