<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Dashboard</title>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <style>
        #myfirstchart {
            height: 250px; /* Chiều cao của biểu đồ */
            width: 100%;   /* Chiều rộng của biểu đồ */
        }
        #pagination {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div>
            <p>Tổng số phim: </p>
            <div><?php echo htmlspecialchars($data['movieNum']); ?></div>
        </div>
    </div>
    <div>
        <p>Biểu đồ lượt xem phim</p>
        <div id="myfirstchart"></div>
    </div>
    <div id="pagination">
        <button id="prevPage" disabled>Trước</button>
        <span id="pageInfo"></span>
        <button id="nextPage">Sau</button>
    </div>
    
    <script>
        const moviesPerPage = 5; // Số phim hiển thị mỗi trang
        let currentPage = 0;
        const movieViewsData = [
            <?php foreach ($data['movieViews'] as $mv): ?>
                { title: '<?php echo htmlspecialchars($mv['movie']['title']); ?>', value: <?php echo htmlspecialchars($mv['views']); ?> },
            <?php endforeach; ?>
        ];

        function renderChart() {
            const start = currentPage * moviesPerPage;
            const end = Math.min(start + moviesPerPage, movieViewsData.length);
            const currentMovies = movieViewsData.slice(start, end);

            // Xóa nội dung cũ của biểu đồ
            $('#myfirstchart').empty();

            if (currentMovies.length > 0) {
                new Morris.Bar({
                    element: 'myfirstchart',
                    data: currentMovies,
                    xkey: 'title',
                    ykeys: ['value'],
                    labels: ['Số lượt xem']
                });
            } else {
                console.log("Không có dữ liệu để vẽ biểu đồ.");
            }

            updatePagination();
        }

        function updatePagination() {
            document.getElementById('pageInfo').innerText = `Trang ${currentPage + 1} / ${Math.ceil(movieViewsData.length / moviesPerPage)}`;
            document.getElementById('prevPage').disabled = currentPage === 0;
            document.getElementById('nextPage').disabled = (currentPage + 1) * moviesPerPage >= movieViewsData.length;
        }

        document.getElementById('prevPage').addEventListener('click', () => {
            if (currentPage > 0) {
                currentPage--;
                renderChart();
            }
        });

        document.getElementById('nextPage').addEventListener('click', () => {
            if ((currentPage + 1) * moviesPerPage < movieViewsData.length) {
                currentPage++;
                renderChart();
            }
        });

        renderChart(); // Vẽ biểu đồ lần đầu
    </script>
</body>
</html>