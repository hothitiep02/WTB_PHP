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

    // Nếu bản ghi đã tồn tại, không thực hiện thêm
    if ($count > 0) {
        return false; // Có thể trả về một thông báo khác nếu cần
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
    // Các phương thức khác tương tác với cơ sở dữ liệu
}
?>