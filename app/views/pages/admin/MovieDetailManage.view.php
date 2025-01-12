<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Watch Movie</title>
    <link rel="stylesheet" href="/WTB_PHP/public/css/WatchMovie.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
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
                <form method="post" class= "form_icon">
                    <div class="heart_icon" id="heart_icon">
                        <button type="submit" name="favorite">
                            <i class="bi bi-heart-fill"></i>
                        </button>    
                    </div>
                    <div class="num_heart">
                        <p><?php echo count($data['likes']); ?></p>
                    </div>
                </form>   
                <div class="view" style="margin-left:20px; margin-left: 20px;display: flex;align-items: center;gap: 20px;font-size: 30px;">
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
                    <img src="https://vapa.vn/wp-content/uploads/2022/12/anh-dai-dien-dep-001.jpg" class="avarta" alt="">
                    <div class="content">
                        <form method="post" action="Admin/addComment">
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
                            <img class="ano_avarta" src="<?php echo !empty($comment['image']) ? htmlspecialchars($comment['image']) : 'uploads/default-avatar.png'; ?>" 
                            alt="Avatar">
                            <div class="show_content">
                                <div class="name_user">
                                    <p><b><?php echo htmlspecialchars($comment['user_name']); ?></b></p>
                                </div>
                                <div class="box_comment">
                                    <div class="cnt">
                                        <p><?php echo nl2br(htmlspecialchars($comment['content'])); ?></p>
                                    </div>
                                    <div>
                                        <form method="post" action="/WTB_PHP/Admin/deleteComment/<?php echo $comment['comment_id']; ?>/<?php echo $data['movieId']['movie_id']; ?>" 
                                                onsubmit="return confirm('Bạn có chắc muốn xóa bình luận này?');">
                                                <button type="submit" class="delete_comment">Delete</button>
                                        </form>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Chưa có bình luận nào.</p>
                <?php endif; ?>
        </div>
    </div>
</body>
</html>