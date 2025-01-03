<?php
    class Database {
        public $conn;
        public $servername = "localhost";
        public $username = "root";
        public $password = "Hiep@1609";
        public $dbname = "wetube";

        function __construct() {
            
            // Kết nối đến cơ sở dữ liệu
            $this->conn = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname);

            // Kiểm tra kết nối
            if (!$this->conn) {
                die("Kết nối thất bại: " . mysqli_connect_error());
            }

            // Thiết lập mã hóa ký tự
            mysqli_set_charset($this->conn, 'utf8');
            // echo "Kết nối thành công!";
        }

        // Phương thức để ngắt kết nối
        function close() {
            if ($this->conn) {
                mysqli_close($this->conn);
            }
        }
    }

    // Tạo đối tượng Database để kiểm tra kết nối
    // $db = new Database();
?>