<!DOCTYPE html>
<html lang="en">
<head>
    <base href="/WTB_PHP/">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/WTB_PHP/public/css/Header.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
</head>
<body>
    <div class="header">
        <?php
            require_once './app/views/components/header.php';
        ?>
    </div>
    <div class="content">
        <?php
            require_once './app/views/pages/'.$data['Page'].'.view'.'.php';
        ?>
    </div>

    <div class="footer">
        <?php
            require_once './app/views/components/footer.php';
        ?>
    </div>
        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-1Z5bWn0Q3uHq0v3C5G6o74zQ6T1T4p1cl8k6D2jJ4hU5e9G5s2W0T5QwEBRz3A5R" crossorigin="anonymous"></script>
</body>
</html>