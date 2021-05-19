<?php include_once ROOT . '/views/layouts/header.php'; ?>

<main>
    <?php
    $allGood = true;
    foreach ($result as $value) {
        if ($value == false) $allGood = false;
    }

    if ($allGood) :
    ?>
    <h2>Product deleted</h2>
    <?php else :?>
    <h2>Error!</h2>
    <?php endif ?>
</main>

<?php include_once ROOT . '/views/layouts/footer.php'; ?>
