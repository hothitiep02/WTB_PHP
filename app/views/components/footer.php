<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .container{
            display: grid;
            grid-template-columns: repeat(4,1fr);
            background-color: black;
            color: white;
        }
        .container *{
            margin: 10px;
        }
        img {
            width: 100px;
            height: 100px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div><img src="../../../public/asset/logo-wetube.png" alt=""></div>
        <div><b>Hỗ trợ và giúp đỡ</b>
            <div>Phản ánh ý kiến</div>
            <div>Câu hỏi thường gặp</div>
        </div>
        <div><b>Truy cập nhanh</b>
            <div>Trang chủ</div>
            <div>Giới thiệu</div>
            <div>Lĩnh vực hoạt động</div>
        </div>
        <div><b>Đăng ký nhận thông tin!</b>
            <div>
                Đừng bỏ lỡ bất kỳ cập nhật nào về những bộ phim hot nhất!
            </div>
        </div>
    </div>
</body>
</html>