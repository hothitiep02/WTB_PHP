<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($movie['title']); ?> - Watch Movie</title>
    <link rel="stylesheet" href="../../public/asset/css/watch_movie.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
body{
    background-color: black;
    color: white;
}
.title{
    margin-left:100px;
}
.image img{
    width: 300px;
    height: 300px;
    object-fit: contain;
}
.describe{
    display: flex;
    margin-left: 50px;
}
.text{
    width: 600px;
}
.text_cmt{
    display: flex;
}
.avarta{
    width: 50px;
    height: 50px;
    border-radius: 50%;
}
.content input {
    margin-left: 30px;
    width: 700px;
    padding: 30px;
    text-align: center;
    border-radius: 20px;
    border:none;
}
.show_cmt{
    display: flex;
    margin-top: 30px;
}
.ano_avarta{
    width: 50px;
    height: 50px;
    border-radius: 50%;
}
.show_content{
    margin-left: 30px;

}
.name_user p{
    margin: 0px;
}
.button_cmt {
    display: flex;
    gap: 15px;
    margin-top: 10px;
    margin-left: 550px;
}
.button_cmt button{
    padding: 5px 15px;
    border-radius: 15px;
    border: none;
}
.post_cmt{
    background-color: #F9ED32;  
}
.comment{
    margin-left: 100px;
}
.form_icon{
    display: flex;
    gap: 20px;
    
}
.icon{
    display: flex;
    margin-top: 30px;
}
.icon p{
    margin: 0px;
}
.head{
    display: flex;
    gap: 700px;
    
}
.heart_icon button{
    background-color: black;
    color: white;
    border: none;
    font-size: 30px;
}
.collection_icon button{
    background-color: black;
    color: white;
    border: none;
    font-size: 30px;
}
.num_heart{
    font-size: 30px;   
}

.heart_icon.active button i {
    color: red; /* Đảm bảo là biểu tượng trái tim có màu đỏ khi active */
}

    </style>
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
            <div class="title">
                <h1><?php echo htmlspecialchars($data['movieId']['title']); ?></h1>
            </div>
            <div class="icon">
                <form method="post" class= "form_icon">
                    <div class="heart_icon" id="heart_icon">
                        <button type="submit" name="favorite">
                            <i class="bi bi-heart-fill"></i>
                        </button>    
                    </div>
                    <div class="num_heart"><p><?php echo $likeCount; ?></p>
                    </div>
                    <div class="collection_icon">
                        <button type="submit" name="collection"><i class="fa fa-bookmark-o"></i></button>
                    </div> 
                </form>   
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
                        <form method="post">
                            <input type="text" name="comment_text" placeholder="Nhập bình luận">
                            <div class="button_cmt">
                                <button type="button" class="cancel">Cancel</button>
                                <button type="submit" name="comment">Comment</button>
                            </div>
                        </form>
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
</body>
</html>