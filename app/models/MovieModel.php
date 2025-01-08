<?php
class MovieModel extends Database
{
    public function __construct()
    {
        parent::__construct();
    }

    // Lấy tất cả phim
    public function getAllMovies()
    {
        $query = "SELECT * FROM movies";
        $result = mysqli_query($this->conn, $query);

        if (!$result) {
            die("Lỗi truy vấn: " . mysqli_error($this->conn));
        }
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        return $data;
    }

    // Lấy thông tin phim theo ID
    public function getMovieById($id)
    {
        $query = "SELECT * FROM movies WHERE movie_id = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        } else {
            return null;
        }
    }

    // Lấy 3 phim mới nhất
    public function getLatestMovies()
    {
        $query = "SELECT * FROM movies ORDER BY created_at DESC LIMIT 3";
        $result = mysqli_query($this->conn, $query);

        if (!$result) {
            die("Lỗi truy vấn: " . mysqli_error($this->conn));
        }
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        return $data;
    }

    public function getMoviesByGenre($genre)
    {
        $query = "SELECT * FROM movies WHERE type_id = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $genre);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        return $data;
    }
     public function getRelatedMovies($movieId, $typeId)
     {
         $query = "SELECT * FROM movies WHERE type_id = ? AND movie_id != ?";
         $stmt = mysqli_prepare($this->conn, $query);
         mysqli_stmt_bind_param($stmt, "ii", $typeId, $movieId);
         mysqli_stmt_execute($stmt);
         $result = mysqli_stmt_get_result($stmt);
 
         $data = [];
         while ($row = mysqli_fetch_assoc($result)) {
             $data[] = $row;
         }
         return $data;
     }
public function addView($movieId) {
    $query = "INSERT INTO views (movie_id) VALUES (?)";
    $stmt = $this->conn->prepare($query);
    
    if ($stmt === false) {
        // Xử lý lỗi khi chuẩn bị câu lệnh
        return false; // Hoặc xử lý theo cách khác
    }
    
    $stmt->bind_param("i", $movieId);
    
    if ($stmt->execute()) {
        // Nếu việc thực thi thành công, có thể trả về true hoặc thông tin khác nếu cần
        return true; 
    } else {
        // Xử lý lỗi khi thực thi câu lệnh
        return false; // Hoặc xử lý theo cách khác
    }
}
     public function getMovieViews($movieId){
        $query = "SELECT * FROM views WHERE movie_id = ?";
         $stmt = mysqli_prepare($this->conn, $query);
         mysqli_stmt_bind_param($stmt, "i", $movieId);
         mysqli_stmt_execute($stmt);
         $result = mysqli_stmt_get_result($stmt);
         $data = [];
         while ($row = mysqli_fetch_assoc($result)) {
             $data[] = $row;
         }
         return $data;
     }
public function addLike($userId, $movieId) {
    // Kiểm tra xem lượt thích đã tồn tại chưa
    $checkQuery = "SELECT COUNT(*) FROM `like` WHERE movie_id = ? AND user_id = ?";
    $checkStmt = $this->conn->prepare($checkQuery);

    if ($checkStmt === false) {
        throw new Exception("Error preparing check query: " . mysqli_error($this->conn));
    }

    $checkStmt->bind_param("ii", $movieId, $userId);
    $checkStmt->execute();
    $checkStmt->bind_result($count);
    $checkStmt->fetch();
    $checkStmt->close();

    if ($count > 0) {
        // Nếu bản ghi đã tồn tại, xóa lượt thích
        $deleteQuery = "DELETE FROM `like` WHERE movie_id = ? AND user_id = ?";
        $deleteStmt = $this->conn->prepare($deleteQuery);

        if ($deleteStmt === false) {
            throw new Exception("Error preparing delete query: " . mysqli_error($this->conn));
        }

        $deleteStmt->bind_param("ii", $movieId, $userId);
        $deleteSuccess = $deleteStmt->execute();
        $deleteStmt->close();
        return $deleteSuccess; // Trả về true nếu xóa thành công
    }

    // Nếu chưa tồn tại, thực hiện thêm lượt thích
    $insertQuery = "INSERT INTO `like` (user_id, movie_id) VALUES (?, ?)";
    $insertStmt = $this->conn->prepare($insertQuery);

    if ($insertStmt === false) {
        throw new Exception("Error preparing insert query: " . mysqli_error($this->conn));
    }

    $insertStmt->bind_param("ii", $userId, $movieId);

    // Kiểm tra kết quả thực thi
    $insertSuccess = $insertStmt->execute();
    $insertStmt->close();
    return $insertSuccess; // Trả về true nếu thêm thành công
}
    public function getMovieLike($movieId){
        $query = "SELECT * FROM `like` WHERE movie_id = ?";
         $stmt = mysqli_prepare($this->conn, $query);
         mysqli_stmt_bind_param($stmt, "i", $movieId);
         mysqli_stmt_execute($stmt);
         $result = mysqli_stmt_get_result($stmt);
         $data = [];
         while ($row = mysqli_fetch_assoc($result)) {
             $data[] = $row;
         }
         return $data;
    }
    public function addHistory($movieId, $userId) {
    // Kiểm tra xem bản ghi đã tồn tại chưa
    $checkQuery = "SELECT COUNT(*) FROM history WHERE movie_id = ? AND user_id = ?";
    $checkStmt = $this->conn->prepare($checkQuery);

    if ($checkStmt === false) {
        return false; // Xử lý lỗi khi chuẩn bị câu lệnh
    }

    $checkStmt->bind_param("ii", $movieId, $userId);
    $checkStmt->execute();
    $checkStmt->bind_result($count);
    $checkStmt->fetch();
    $checkStmt->close();

    // Nếu bản ghi đã tồn tại, không thực hiện thêm và không làm gì hết
    if ($count > 0) {
        return; // Không làm gì cả và kết thúc hàm
    }

    // Nếu chưa tồn tại, thực hiện thêm
    $query = "INSERT INTO history (movie_id, user_id) VALUES (?, ?)";
    $stmt = $this->conn->prepare($query);
    
    if ($stmt === false) {
        return false; // Xử lý lỗi khi chuẩn bị câu lệnh
    }

    $stmt->bind_param("ii", $movieId, $userId);
    
    $result = $stmt->execute();
    $stmt->close(); // Đóng statement sau khi sử dụng

    return $result; // Trả về true nếu thêm thành công, false nếu không
}
    public function addComment($movieId, $userId, $content) {
        // Kiểm tra xem nội dung bình luận có hợp lệ không
        if (empty($content)) {
            return false; // Không cho phép bình luận rỗng
        }

        // Câu lệnh SQL để thêm bình luận
        $query = "INSERT INTO comment (movie_id, user_id, content) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        if ($stmt === false) {
            return false; // Xử lý lỗi khi chuẩn bị câu lệnh
        }

        // Ràng buộc tham số
        $stmt->bind_param("iis", $movieId, $userId, $content);
        
        // Thực thi câu lệnh
        $result = $stmt->execute();
        $stmt->close(); // Đóng statement sau khi sử dụng

        return $result; // Trả về true nếu thêm thành công, false nếu không
    }
     }
     
     }

     public function updateMovie($movie_id, $title, $movie_url, $poster, $type_id)
    {
        $query = "UPDATE movies SET title = ?, movie_url = ?, poster = ?, type_id = ? WHERE movie_id = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "ssssi", $title, $movie_url, $poster, $type_id, $movie_id);
        if (mysqli_stmt_execute($stmt)) {
            return true; 
        } else {
            die("Lỗi khi cập nhật phim: " . mysqli_error($this->conn));
        }
    }
 
     }
?>
