<!DOCTYPE html>
<html lang="en">
<head>
    <base href="/WTB_PHP/">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
</body>
</html>