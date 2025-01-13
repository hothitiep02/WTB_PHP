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

    public function getCollection($userId) {
        $sql = "SELECT c.collection_id, m.movie_id, m.title, m.poster
                FROM collections c 
                JOIN movies m ON c.movie_id = m.movie_id 
                WHERE c.user_id = ?";

        $stmt = $this->db->conn->prepare($sql);
        if ($stmt === false) {
            throw new Exception('Prepare failed: ' . $this->db->conn->error);
        }

        $stmt->bind_param("i", $userId);

        if (!$stmt->execute()) {
            throw new Exception('Execute failed: ' . $stmt->error);
        }

        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
public function addCollection($movieId, $userId) {
    $checkQuery = "SELECT COUNT(*) FROM Collections WHERE movie_id = ? AND user_id = ?";
    $checkStmt = $this->db->conn->prepare($checkQuery);

    if ($checkStmt === false) {
        return false;
    }

    $checkStmt->bind_param("ii", $movieId, $userId);
    $checkStmt->execute();
    $checkStmt->bind_result($count);
    $checkStmt->fetch();
    $checkStmt->close();
    if ($count > 0) {
        $deleteQuery = "DELETE FROM Collections WHERE movie_id = ? AND user_id = ?";
        $deleteStmt = $this->db->conn->prepare($deleteQuery);

        if ($deleteStmt === false) {
            return false;
        }

        $deleteStmt->bind_param("ii", $movieId, $userId);
        $result = $deleteStmt->execute();
        $deleteStmt->close();

        return $result;
    }

    $query = "INSERT INTO Collections (movie_id, user_id) VALUES (?, ?)";
    $stmt = $this->db->conn->prepare($query);

    if ($stmt === false) {
        return false;
    }

    $stmt->bind_param("ii", $movieId, $userId);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}
    public function createUser($name, $email, $password, $image) {
        $query = "INSERT INTO users (user_name, email, password, image) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->conn->prepare($query);
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt->bind_param("ssss", $name, $email, $hashedPassword, $image);
        return $stmt->execute();
    }

public function updateUser($userId, $name, $email, $image, $birth) {
    $sql = "UPDATE users SET user_name = ?, email = ?, image = ?, birth = ? WHERE user_id = ?";
    
    $stmt = $this->db->conn->prepare($sql);
    if ($stmt === false) {
        error_log("MySQL prepare error: " . $this->db->conn->error);
        return false;
    }
    $stmt->bind_param('ssssi', $name, $email, $image, $birth, $userId);
    if ($stmt->execute()) {
        return true;
    } else {
        error_log("Database error: " . $stmt->error);
        return false;
    }
}

    public function deleteUser($userId) {
        $stmt =  $this->db->conn->prepare("DELETE FROM comment WHERE user_id = ?");
        $stmt->bind_param("i", $userId );
        $stmt->execute();
        $query = "DELETE FROM users WHERE user_id = ?";
        $stmt = $this->db->conn->prepare($query);
    
        if (!$stmt) {
            die("Prepare failed: " . $this->db->conn->error);
        }
    
        $stmt->bind_param("i", $userId);
    
        if (!$stmt->execute()) {
            die("Execute failed: " . $stmt->error);
        }
    
        return $stmt->affected_rows > 0;
    }

    public function authenticateUser($email, $password) {
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->db->conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        
        if ($user && password_verify($password, $user['password'])) {
            return $user; 
        }
        return false; 
    }

    public function getHistoryByUserId($userId) {
        $query = "SELECT h.history_id, h.movie_id, h.watched_at, m.title, m.poster
                  FROM history h 
                  JOIN movies m ON h.movie_id = m.movie_id 
                  WHERE h.user_id = ?";
        $stmt = $this->db->conn->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        $history = [];
        while ($row = $result->fetch_assoc()) {
            $history[] = $row;
        }
        $stmt->close();

        return $history;
    }
    public function getUserInfo($userId) {
        $query = "SELECT image FROM Users WHERE id = ?";
        $stmt = $this->db->conn->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->bind_result($image);
        $stmt->fetch();
        $stmt->close();
        return $image;
    }
}
?>