<?php include_once ROOT . '/views/layouts/header.php'; ?>

<?php var_dump($errors ?? '') ?>

<main>
    <h2>Регистрация</h2>

    <?php if ($result): ?>
        <p>Вы зарегистрированы!</p>
    <?php else: ?>
        <div class="register-form">
            <form action="#" method="post">
                <input required type="text" name="firstName" placeholder="Имя" value="<?= $_POST['firstName'] ?? '' ?>"/>
                <input required type="text" name="lastName" placeholder="Фамилия" value="<?= $_POST['lastName'] ?? '' ?>"/>
                <input required type="email" name="email" placeholder="E-mail" value="<?= $_POST['email'] ?? '' ?>"/>
                <input required type="password" name="password" placeholder="Пароль"/>
                <input type="submit" name="submit" class="btn btn-default" value="Регистрация"/>
            </form>
        </div>

    <?php endif; ?>
</main>

<?php include_once ROOT . '/views/layouts/footer.php'; ?>
