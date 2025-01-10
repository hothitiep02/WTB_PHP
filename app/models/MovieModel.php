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

    // Lấy phim theo thể loại (1: Romance, 2: Cartoon, 3: Horror)
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

     // Lấy phim liên quan theo type_id
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
    public function checkLike($userId, $movieId) {
        $query = "SELECT *
                FROM `like` 
                WHERE user_id = ? AND movie_id = ?";

        $stmt = mysqli_prepare($this->conn, $query); // Sử dụng $this->conn ở đây
        mysqli_stmt_bind_param($stmt, "ii", $userId, $movieId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        return mysqli_num_rows($result) > 0; // Trả về true nếu đã like, false nếu chưa
    }
        public function checkCollection($userId, $movieId) {
            $query = "SELECT *
                    FROM collections 
                    WHERE user_id = ? AND movie_id = ?";

            $stmt = mysqli_prepare($this->conn, $query); // Sử dụng $this->conn ở đây
            mysqli_stmt_bind_param($stmt, "ii", $userId, $movieId);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            return mysqli_num_rows($result) > 0; // Trả về true nếu đã like, false nếu chưa
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

     // Lấy comment theo movie_id
    public function getCommentsByMovieId($movieId)
    {
        $query = "SELECT c.comment_id, c.content, u.user_name, u.image FROM comment c
        INNER JOIN users u ON c.user_id = u.user_id WHERE movie_id = ?
        ORDER BY c.created_at DESC"; 
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

    public function deleteComment($commentId, $movieId) {
        $query = "DELETE FROM comment WHERE comment_id = ? AND movie_id = ?";
        $stmt = $this->conn->prepare($query);
    
        if ($stmt === false) {
            die('MySQL prepare error: ' . $this->conn->error); // Thêm kiểm tra lỗi SQL
        }
        $stmt->bind_param("ii", $commentId, $movieId);
        if ($stmt->execute()) {
            return true; // Trả về true nếu xóa thành công
        } else {
            // In ra lỗi nếu không xóa được
            die("Error executing delete: " . $stmt->error);
        }
    }
    public function getAllGenres() {
        $query = "SELECT type_id, type_name FROM type";
        $result = mysqli_query($this->conn, $query);
        
        $genres = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $genres[] = $row;
        }
        
        return $genres; // Trả về danh sách thể loại phim
    }
    public function filterMoviesByGenre($genreId) {
        $query = "SELECT * FROM movies WHERE type_id = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        
        mysqli_stmt_bind_param($stmt, "i", $genreId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        $movies = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $movies[] = $row;
        }
        
        return $movies; // Trả về danh sách phim theo thể loại
    }
    public function searchMoviesByName($name) {
        $query = "SELECT * FROM movies WHERE title LIKE ?";
        $stmt = mysqli_prepare($this->conn, $query);
        
        $searchTerm = "%" . $name . "%"; // Thêm dấu % để tìm kiếm
        mysqli_stmt_bind_param($stmt, "s", $searchTerm);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        $movies = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $movies[] = $row;
        }
        
        return $movies; // Trả về danh sách phim tìm được
    }
     }
?>
