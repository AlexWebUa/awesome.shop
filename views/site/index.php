<?php include_once ROOT . '/views/layouts/header.php'; ?>

<main>
    <h2>Каталог товаров</h2>
    <section class="products">
        <?php foreach ($latestProducts as $product): ?>
            <div class="product">
                <img src="/uploads/images/<?= $product['mainImg'] ?>" alt="<?= $product['mainImg'] ?>"
                     class="product-image">
                <h3>
                    <a href="<?= '/product/' . $product['id'] ?>" class="product-name"><?= $product['title']; ?></a>
                </h3>
                <p>Description: <?= $product['description'] ?></p>
                <?php if (!empty($product['metatitle'])) :?>
                <p>Metatitle: <?= $product['metatitle'] ?></p>
                <?php endif; ?>
                <p>Created at: <?= $product['createdAt'] ?></p>
                <p>Updated at:<?= $product['updatedAt'] ?></p>
                <p>Discount: <?= $product['discount'] ?>%</p>
                <?= var_dump($product) ?>
            </div>
        <?php endforeach; ?>

    </section>
</main>

<?php include_once ROOT . '/views/layouts/footer.php'; ?>
