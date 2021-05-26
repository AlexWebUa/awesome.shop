<?php include_once ROOT . '/views/layouts/header.php'; ?>

<div class="container">
    <section class="product-delete">
        <?php
        $allGood = true;
        foreach ($result as $value) {
            if ($value == false) $allGood = false;
        }

        if ($allGood) :
            ?>
            <h2>Продукт удалён</h2>
        <?php else :?>
            <h2>Ошибка удаления!</h2>
        <?php endif ?>
    </section>
</div>

<?php include_once ROOT . '/views/layouts/footer.php'; ?>
