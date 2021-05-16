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

<header>
    <div class="header-logo">
        <h1>
            <a href="/">Awesome.shop</a>
        </h1>
    </div>
    <ul class="user-block">
        <li>
            <a href="/product/add">
                Добавить продукт
            </a>
        </li>
        <li class="cart">
            <a href="/cart/">
                Корзина
                <span id="cart-count">(<?= Cart::countItems(); ?>)</span>
            </a>
        </li>
        <?php if (User::isGuest()): ?>
            <li class="login">
                <a href="/user/login/">Вход</a>
            </li>
            <li class="register">
                <a href="/user/register/">Регистрация</a>
            </li>
        <?php else: ?>
            <li class="cabinet">
                <a href="/cabinet/">Кабинет</a>
            </li>
            <li class="login">
                <a href="/user/logout/">Выход</a>
            </li>
        <?php endif; ?>
    </ul>
</header>
