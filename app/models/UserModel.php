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
        // Câu lệnh SQL
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
        
        // Trả về tất cả các kết quả dưới dạng mảng
        return $result->fetch_all(MYSQLI_ASSOC);
    }
public function addCollection($movieId, $userId) {
    // Kiểm tra xem bản ghi đã tồn tại chưa
    $checkQuery = "SELECT COUNT(*) FROM Collections WHERE movie_id = ? AND user_id = ?";
    $checkStmt = $this->db->conn->prepare($checkQuery);

    if ($checkStmt === false) {
        return false; // Xử lý lỗi khi chuẩn bị câu lệnh
    }

    $checkStmt->bind_param("ii", $movieId, $userId);
    $checkStmt->execute();
    $checkStmt->bind_result($count);
    $checkStmt->fetch();
    $checkStmt->close();

    // Nếu bản ghi đã tồn tại, thực hiện xóa
    if ($count > 0) {
        $deleteQuery = "DELETE FROM Collections WHERE movie_id = ? AND user_id = ?";
        $deleteStmt = $this->db->conn->prepare($deleteQuery);

        if ($deleteStmt === false) {
            return false; // Xử lý lỗi khi chuẩn bị câu lệnh
        }

        $deleteStmt->bind_param("ii", $movieId, $userId);
        $result = $deleteStmt->execute();
        $deleteStmt->close();

        return $result; // Trả về true nếu xóa thành công, false nếu không
    }

    // Nếu chưa tồn tại, thực hiện thêm
    $query = "INSERT INTO Collections (movie_id, user_id) VALUES (?, ?)";
    $stmt = $this->db->conn->prepare($query);

    if ($stmt === false) {
        return false; // Xử lý lỗi khi chuẩn bị câu lệnh
    }

    $stmt->bind_param("ii", $movieId, $userId);
    
    // Thực hiện câu lệnh INSERT và trả về kết quả
    $result = $stmt->execute();
    $stmt->close(); // Đóng statement sau khi sử dụng

    return $result; // Trả về true nếu thêm thành công, false nếu không
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
    
    // Kiểm tra xem câu lệnh chuẩn bị có thành công không
    if ($stmt === false) {
        error_log("MySQL prepare error: " . $this->db->conn->error);
        return false;
    }

    // Liên kết các tham số
    $stmt->bind_param('ssssi', $name, $email, $image, $birth, $userId); // 'ssssi' là kiểu dữ liệu tương ứng

    // Thực hiện câu lệnh
    if ($stmt->execute()) {
        return true;
    } else {
        // Ghi lại lỗi để kiểm tra
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
    
        return $stmt->affected_rows > 0; // Trả về true nếu xóa thành công
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

        return $history; // Trả về mảng lịch sử
    }
    public function getUserInfo($userId) {
        $query = "SELECT image FROM Users WHERE id = ?";
        $stmt = $this->db->conn->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->bind_result($image);
        $stmt->fetch();
        $stmt->close();
        return $image; // Trả về đường dẫn ảnh
    }
}
?>