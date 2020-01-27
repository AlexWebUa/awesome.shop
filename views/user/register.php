<?php include_once ROOT . '/views/layouts/header.php'; ?>

<main>
    <h2>Регистрация</h2>

    <?php if ($result): ?>
        <p>Вы зарегистрированы!</p>
    <?php else: ?>
        <?php if (isset($errors) && is_array($errors)): ?>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li> - <?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <div class="register-form">
            <form action="#" method="post">
                <input type="text" name="name" placeholder="Имя" value="<?php echo $name; ?>"/>
                <input type="email" name="email" placeholder="E-mail" value="<?php echo $email; ?>"/>
                <input type="password" name="password" placeholder="Пароль"/>
                <input type="submit" name="submit" class="btn btn-default" value="Регистрация"/>
            </form>
        </div>

    <?php endif; ?>
</main>

<?php include_once ROOT . '/views/layouts/footer.php'; ?>
