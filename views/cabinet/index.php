<?php include_once ROOT . '/views/layouts/header.php'; ?>
<?php
$permissions = User::getRolePermissions($user['roleId']);
?>

<div class="container">
    <section class="user">
        <?php if ($user['firstName'] != null) : ?>
            <div class="info-item">Имя: <?= $user['firstName'] ?></div>
        <?php endif; ?>

        <?php if ($user['lastName'] != null) : ?>
        <div class="info-item">Фамилия: <?= $user['lastName'] ?></div>
        <?php endif; ?>

        <div class="info-item">Email: <?= $user['email'] ?></div>

        <div class="info-item">Роль: <?= $user['role'] ?></div>

        <?php if ($permissions != null) : ?>
            <div class="info-item">Разрешения:
                <?php
                $permissions_str = '';
                for ($i = 0; $i < count($permissions); $i++) {
                    $permissions_str .= $i == count($permissions) - 1 ? $permissions[$i]['title'] : $permissions[$i]['title'] . ', ';
                }
                echo $permissions_str;
                ?>
            </div>
        <?php endif; ?>

    </section>
</div>

<?php include_once ROOT . '/views/layouts/footer.php'; ?>
