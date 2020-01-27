<?php include_once ROOT . '/views/layouts/header.php'; ?>

<main>
    <h2>Вход</h2>

    <?php if (isset($errors) && is_array($errors)): ?>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li> - <?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <div class="login-form">
        <form action="#" method="post">
            <input type="email" name="email" placeholder="E-mail" value="<?php echo $email; ?>"/>
            <input type="password" name="password" placeholder="Пароль"/>
            <input type="submit" name="submit" class="btn btn-default" value="Вход"/>
        </form>
    </div>

</main>

<?php include_once ROOT . '/views/layouts/footer.php'; ?>
