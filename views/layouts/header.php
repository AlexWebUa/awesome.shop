<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Awesome shop</title>
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css">
</head>
<body>

<header class="header">
    <div class="header__logo">
        <a href="/">Awesome.shop</a>
    </div>
    <div class="header__links">
        <a class="class" href="/cart/">
            Корзина
            <span id="cart-count">(0)</span>
        </a>
        <?php if (User::isGuest()): ?>
            <a class="login" href="/user/login/">Вход</a>
            <a class="register" href="/user/register/">Регистрация</a>
        <?php else: ?>
            <?php if ($_SESSION['userRole'] == '2') : ?>
                <a class="product-add" href="/product/add">Добавить продукт</a>
            <?php endif; ?>
            <a class="cabinet" href="/cabinet/"><?= $_SESSION['userEmail'] ?></a>
            <a class="logout" href="/user/logout/">Выход</a>
        <?php endif; ?>
    </div>
</header>
