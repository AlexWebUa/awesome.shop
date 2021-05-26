<?php include_once ROOT . '/views/layouts/header.php'; ?>

<div class="container">
    <section class="user-register">
        <h2>Регистрация</h2>

        <?php if ($result): ?>
            <p>Вы зарегистрированы!</p>
        <?php else: ?>
            <div class="register-form">
                <form action="#" method="post">
                    <label><input required type="text" name="firstName" placeholder="Имя" value="<?= $_POST['firstName'] ?? '' ?>"/></label>
                    <label><input required type="text" name="lastName" placeholder="Фамилия" value="<?= $_POST['lastName'] ?? '' ?>"/></label>
                    <label><input required type="email" name="email" placeholder="E-mail" value="<?= $_POST['email'] ?? '' ?>"/></label>
                    <label><input required type="password" name="password" placeholder="Пароль"/></label>
                    <input type="submit" name="submit" class="btn-block" value="Регистрация"/>
                </form>
            </div>
        <?php endif; ?>
    </section>
</div>

<?php include_once ROOT . '/views/layouts/footer.php'; ?>
