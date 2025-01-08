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
