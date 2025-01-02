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

    // Các phương thức khác tương tác với cơ sở dữ liệu
}
?>