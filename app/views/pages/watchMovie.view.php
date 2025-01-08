<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($movie['title']); ?> - Watch Movie</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/WTB_PHP/public/css/WatchMovie.css">
</head>
<body>
    <div class="container">
        <div class="movie_banner">
            <iframe 
                src="<?php echo htmlspecialchars($data['movieId']['movie_url']); ?>" 
                frameborder="0" 
                width="100%" 
                height="600px" 
                allowfullscreen>
            </iframe>
        </div>
        <div class="head">
            <h1><?php echo isset($data['movieId']['title']) ? htmlspecialchars($data['movieId']['title']) : 'Unknown Title'; ?></h1>

            <div class="icon">
                <div class="heart_icon" id="heart_icon">
                    <form action="movie/addLike" method="POST" id="likeForm">
                        <input type="hidden" name="movie_id" value="<?php echo htmlspecialchars($data['movieId']['movie_id']); ?>">
                        <button type="submit" style="background: none; border: none; cursor: pointer;">
                            <i class="bi bi-heart-fill"></i>
                        </button>
                    </form>
                </div>
                <div class="num_heart">
                    <?php

                        echo count($data['likes']);
                    ?>
                </div>
                <div class="collection_icon">
                    <form action="user/addCollection" method="POST" id="addCollection">
                        <input type="hidden" name="movie_id" value="<?php echo htmlspecialchars($data['movieId']['movie_id']); ?>">
                        <button type="submit" style="background: none; border: none; cursor: pointer;">
                            <i class="fa fa-bookmark-o"></i>
                        </button>
                    </form>
                </div> 
            </div>
        </div>
        
        <div class="describe">
            <div class="image">
                <img src="<?php echo htmlspecialchars($data['movieId']['poster']); ?>">
            </div>
            <div class="text">
                <?php echo nl2br(htmlspecialchars($data['movieId']['description'])); ?>
            </div>
        </div>
        
        <div class="comment">
            <div class="num_cmt">
                <h2>2 Comments</h2>
                <div class="text_cmt">
                    <img src="https://vapa.vn/wp-content/uploads/2022/12/anh-dai-dien-dep-001.jpg" class="avarta" alt="">
                    <div class="content">
                        <form method="post" action="movie/addComment">
                            <input type="hidden" name="movie_id" value="<?php echo htmlspecialchars($data['movieId']['movie_id']); ?>">
                            <input type="text" name="comment_text" placeholder="Nhập bình luận">
                            <div class="button_cmt">
                                <button type="submit" name="comment">Comment</button>
                            </div>
                        </form>
                    <div class="view">
                        <?php
                            // Kiểm tra xem $data['views'] có tồn tại và là mảng không
                            if (isset($data['views']) && is_array($data['views'])) {
                                echo count($data['views']);
                            } else {
                                echo "0"; // Hoặc hiển thị thông điệp khác nếu không có lượt xem
                            }
                        ?>
                    </div>
                    </div>
                </div>
                
                <div class="show_cmt">
                    <img class="ano_avarta" src="https://chiemtaimobile.vn/images/companies/1/%E1%BA%A2nh%20Blog/avatar-facebook-dep/top-36-anh-dai-dien-dep-cho-nu/anh-dai-dien-dep-cho-nu-che-mat-anime.jpg?1708401649581" alt="">
                    <div class="show_content">
                        <div class="name_user">
                            <p><b>Hồ Thị Tiếp</b></p>
                        </div>
                        <p>Phim này hay quá. Tôi thích nội dung của phim!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../../public/asset/js/like.js"></script>

<!-- <script>
    document.getElementById('addCollection').onsubmit = function(event) {
        event.preventDefault(); // Ngăn chặn hành vi mặc định của biểu mẫu

        var formData = new FormData(this);

        fetch(this.action, {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            alert(data); // Hiển thị thông báo alert
        })
        .catch(error => {
            console.error('Error:', error);
        });
    };
</script> -->
</div>


</body>
</html>