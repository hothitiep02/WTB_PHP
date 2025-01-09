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
    
     }
?>
