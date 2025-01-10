<?php
class MovieModel extends Database
{
    public function __construct()
    {
        parent::__construct();
    }


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
        return false;
    }
    
    $stmt->bind_param("i", $movieId);
    
    if ($stmt->execute()) {
        return true; 
    } else {
        return false;
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
        $deleteQuery = "DELETE FROM `like` WHERE movie_id = ? AND user_id = ?";
        $deleteStmt = $this->conn->prepare($deleteQuery);

        if ($deleteStmt === false) {
            throw new Exception("Error preparing delete query: " . mysqli_error($this->conn));
        }

        $deleteStmt->bind_param("ii", $movieId, $userId);
        $deleteSuccess = $deleteStmt->execute();
        $deleteStmt->close();
        return $deleteSuccess;
    }
    $insertQuery = "INSERT INTO `like` (user_id, movie_id) VALUES (?, ?)";
    $insertStmt = $this->conn->prepare($insertQuery);

    if ($insertStmt === false) {
        throw new Exception("Error preparing insert query: " . mysqli_error($this->conn));
    }

    $insertStmt->bind_param("ii", $userId, $movieId);

    $insertSuccess = $insertStmt->execute();
    $insertStmt->close();
    return $insertSuccess;
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

        $stmt = mysqli_prepare($this->conn, $query); 
        mysqli_stmt_bind_param($stmt, "ii", $userId, $movieId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        return mysqli_num_rows($result) > 0; 
    }
        public function checkCollection($userId, $movieId) {
            $query = "SELECT *
                    FROM collections 
                    WHERE user_id = ? AND movie_id = ?";

            $stmt = mysqli_prepare($this->conn, $query); 
            mysqli_stmt_bind_param($stmt, "ii", $userId, $movieId);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            return mysqli_num_rows($result) > 0; 
        }
    public function addHistory($movieId, $userId) {
        $checkQuery = "SELECT COUNT(*) FROM history WHERE movie_id = ? AND user_id = ?";
        $checkStmt = $this->conn->prepare($checkQuery);
    
        if ($checkStmt === false) {
            return false; 
        }
    
        $checkStmt->bind_param("ii", $movieId, $userId);
        $checkStmt->execute();
        $checkStmt->bind_result($count);
        $checkStmt->fetch();
        $checkStmt->close();
        
        if ($count > 0) {
            return; 
        }
        $query = "INSERT INTO history (movie_id, user_id) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        
        if ($stmt === false) {
            return false; 
        }
        $stmt->bind_param("ii", $movieId, $userId);
        $result = $stmt->execute();
        $stmt->close();  
        return $result; 
    }
    
    public function addComment($movieId, $userId, $content) {
        if (empty($content)) {
            return false; 
        }
        $query = "INSERT INTO comment (movie_id, user_id, content) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        if ($stmt === false) {
            return false;
        }
        $stmt->bind_param("iis", $movieId, $userId, $content);
        $result = $stmt->execute();
        $stmt->close(); 
        return $result; 
    }
     
function updateMovie($movie_id, $title, $description, $movie_url, $type_id, $poster) {
        $typeCheckQuery = "SELECT COUNT(*) FROM type WHERE type_id = ?";
        $stmt = $this->conn->prepare($typeCheckQuery);
        $stmt->bind_param('i', $type_id);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();
        
        if ($count == 0) {
            die("Invalid type_id: $type_id");
        }
        $sql = "UPDATE movies SET 
                    title = ?, 
                    description = ?, 
                    movie_url = ?, 
                    type_id = ?, 
                    poster = ?, 
                    created_at = NOW() 
                WHERE movie_id = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            die("Prepare failed: " . $this->conn->error);
        }
    $stmt->bind_param('sssiss', $title, $description, $movie_url, $type_id, $poster, $movie_id);
        $result = $stmt->execute();
        $stmt->close();

        return $result; 
}


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
            die('MySQL prepare error: ' . $this->conn->error); 
        }
        $stmt->bind_param("ii", $commentId, $movieId);
        if ($stmt->execute()) {
            return true; 
        } else {

            die("Error executing delete: " . $stmt->error);
        }
    }
    
    //  }
    //     $stmt->close();
    //     return $result;
    // }

    public function deleteMovie($movie_id) {
        $stmt =  $this->conn->prepare("DELETE FROM comment WHERE movie_id = ?");
        $stmt->bind_param("i", $movie_id);
        $stmt->execute();
        $stmt =  $this->conn->prepare("DELETE FROM movies WHERE movie_id = ?");
        $stmt->bind_param("i", $movie_id); 
       
        if ($stmt === false) {
            die("Prepare failed: " . $this->conn->error);
        }
        $stmt->bind_param('i', $movie_id);
        $result = $stmt->execute();
        if (!$result) {
            die("Error executing query: " . $stmt->error);
        }
        $stmt->close();
        return $result;
    }

    public function addMovie($title, $description, $movie_url, $type_id, $poster){
    $typeCheckQuery = "SELECT COUNT(*) FROM type WHERE type_id = ?";
    $stmt = $this->conn->prepare($typeCheckQuery);
    $stmt->bind_param('i', $type_id);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count == 0) {
        die("Invalid type_id: $type_id");
    }
    $sql = "INSERT INTO movies (title, description, movie_url, type_id, poster, created_at) 
            VALUES (?, ?, ?, ?, ?, NOW())";
    $stmt = $this->conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $this->conn->error);
    }
    $stmt->bind_param('sssis', $title, $description, $movie_url, $type_id, $poster);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
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
