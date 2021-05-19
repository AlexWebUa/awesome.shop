<?php include_once ROOT . '/views/layouts/header.php'; ?>

<main>
    <?= var_dump($product) ?>

    <a href="/product/delete/<?= $product['id'] ?>">Delete</a>
    <br>
    <a href="/product/features/<?= $product['id'] ?>">Edit features</a>
</main>

<?php include_once ROOT . '/views/layouts/footer.php'; ?>
