<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Тестовое задание</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
    <link href="/css/custom.css" rel="stylesheet">
</head>
<body>
<div class="main_wrapper">
    <header class="mt-3 mb-3">
        <nav class="nav bg-primary ">
            <a class="nav-link text-white" href="/">Главная</a>
            <a class="nav-link text-white" href="/login/">Авторизация</a>
        </nav>
    </header>
    <div class="main">
        <?= $body ?>
    </div>
    <footer class="text-center">
        <div class="copyrights">
            ©2021 Сергей Казачек (Komenedant)
        </div>
        <div class="contacts"><a href="../../index.php">shicotan@list.ru</a>
        </div>
    </footer>
</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
</body>
</html>