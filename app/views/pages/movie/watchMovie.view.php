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
<style>
    .watchMovie-container {
        margin-bottom: 20px;
    }

    .box_comment {
        display:flex;
        gap:10px;
        align-items: center;
    }

    .delete_comment {
        width:80px;
        padding: 5px;
        border-radius: 10px;
        border:none;
        background-color: red;
        transition: background-color 0.3s;
        cursor: pointer; 
    }

    .delete_comment:hover {
        background-color: yellow;
    }
</style>
<body>
    <div class="watchMovie-container">
        <div class="movie_banner">
            <iframe 
                src="<?php echo htmlspecialchars($data['movieId']['movie_url']); ?>" 
                frameborder="0" 
                width="100%" 
                height="600px" 
                allowfullscreen>
            </iframe>
        </div>
        <div class="watchMovie-head" style="display:flex; gap: 700px;">
            <div class="watchMovie-title">
                <h2><?php echo htmlspecialchars($data['movieId']['title']); ?></h2>
            </div>
            <div class="icon">
                <form method="post" class= "form_icon" action="movie/addLike">
                    <input type="hidden" name="movie_id" value="<?php echo htmlspecialchars($data['movieId']['movie_id']); ?>">
                    <div class="heart_icon" id="heart_icon">
                        <button type="submit" name="favorite">
                            <i class="bi bi-heart-fill" style="color: <?php echo $data['isLiked'] ? 'red' : 'inherit'; ?>;"></i>
                        </button>    
                    </div>
                </form>   
                    <div class="num_heart">
                        <p><?php echo count($data['likes']); ?></p>
                    </div>
                <form method="post" class="form_icon" action="user/addCollection">
                    <input type="hidden" name="movie_id" value="<?php echo htmlspecialchars($data['movieId']['movie_id']); ?>">
                    <div class="collection_icon" id="heart_icon">
                        <?php if ($data['isAdded']): ?>
                            <button type="submit" name="removeCollection" style="border: none; background: none;">
                                <i class="fa fa-check" style="font-size:48px;color:red"></i>
                            </button>
                        <?php else: ?>
                            <button type="submit" name="collection" style="border: none; background: none;">
                                <i class="fa fa-bookmark-o"></i>
                            </button>
                        <?php endif; ?>
                    </div>
                </form>
                <div class="view" style="margin-left:20px">
                    <i class="fa fa-eye"></i>
                    <div class="num_view">
                        <p><?php echo count($data['views']); ?></p>
                    </div>
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
                <h2><?php echo count($data['comments']); ?> Comments</h2>
                <div class="text_cmt">
                    <img src="<?php echo htmlspecialchars('/WTB_PHP/public/images/avatar/' . $_SESSION['image']); ?>" class="avarta" alt="">
                    <div class="content">
                        <form method="post" action="movie/addComment">
                            <input type="hidden" name="movie_id" value="<?php echo htmlspecialchars($data['movieId']['movie_id']); ?>">
                            <input type="text" name="comment_text" placeholder="Nhập bình luận">
                            <div class="button_cmt">
                                <button type="submit" name="comment">Comment</button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <?php if (!empty($data['comments'])): ?>
                    <?php foreach ($data['comments'] as $comment): ?>
                        <div class="show_cmt">
                            <img class="ano_avarta" src="<?php echo htmlspecialchars('/WTB_PHP/public/images/avatar/' . $comment['image']); ?>" 
                            alt="Avatar">
                            <div class="show_content">
                                <div class="name_user">
                                    <p><b><?php echo htmlspecialchars($comment['user_name']); ?></b></p>
                                </div>
                                <div class="box_comment">
                                    <div class="cnt">
                                        <p><?php echo nl2br(htmlspecialchars($comment['content'])); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Chưa có bình luận nào. Hãy là người bình luận đầu tiên.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('heart_icon').addEventListener('click', function() {
            var heartIcon = this.querySelector('i');
            heartIcon.style.color = heartIcon.style.color === 'red' ? 'inherit' : 'red';
            // Gửi yêu cầu AJAX để cập nhật trạng thái "liked" trên server
        });
        
    </script>
    <script src="../../public/asset/js/like.js"></script>
</body>
</html>