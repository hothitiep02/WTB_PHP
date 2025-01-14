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
            height: 250px;
            width: 100%;   
        }
        #pagination {
            margin-top: 20px;
        }
        .allNum_movie{
            display: flex;
            align-items: center;
            gap: 20px
        }
        .allNum_movie p{
            font-size: 24px;
        }
        .allNum_movie div{
            font-size: 18px;
            color:red;
        }
        .dasboard p{
            margin: 0px;
        }
        .largre{
            margin: 0px 50px;
        }
        #pagination button{
            border: none;
            padding: 8px 25px;
            border-radius: 15px;
            background-color:yellow;
            color: black;
            margin-bottom: 30px;    
        }
    </style>
</head>
<body>
    <div class="largre">
        <div class="container">
            <div class="allNum_movie">
                <p><b>Tổng số phim:</b> </p>
                <div><?php echo htmlspecialchars($data['movieNum']); ?></div>
            </div>
        </div>
        <div class="dasboard">
            <p><b>Biểu đồ lượt xem phim</b></p>
            <div id="myfirstchart"></div>
        </div>
        <div id="pagination">
            <button id="prevPage" disabled style="margin-right:20px;">Trước</button>
            <span id="pageInfo"></span>
            <button id="nextPage" style="margin: 0px 20px;">Sau</button>
        </div>
    </div>
    
    <script>
        const moviesPerPage = 5;
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

        renderChart();
    </script>
</body>
</html>