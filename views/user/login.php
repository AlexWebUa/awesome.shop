<?php include_once ROOT . '/views/layouts/header.php'; ?>

<div class="container">
    <section class="user-login">
        <h2>Авторизация</h2>

        <form action="#" method="post">
            <label><input type="email" name="email" placeholder="E-mail" value="<?= $_POST['email'] ?? '' ?>"/></label>
            <label><input type="password" name="password" placeholder="Пароль"/></label>
            <input class="btn-block" type="submit" name="submit" value="Вход"/>
        </form>
    </section>

</div>

<?php include_once ROOT . '/views/layouts/footer.php'; ?>
