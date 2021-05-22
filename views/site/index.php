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
                <p>IsActive: <?= $product['isActive'] ?></p>
                <?php if ($product['discount'] != null) : ?>
                    <p>Discount: <?= $product['discount'] ?>%</p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </section>

    <?php
        if ($totalNumber > 10):
    ?>
        <ul class="pagination">
            <?php for ($i = 0; $i < ceil($totalNumber/10); $i++) : ?>
                <li><a href="/?offset=<?=$i*10?>"><?=$i+1?></a></li>
            <?php endfor; ?>
        </ul>
    <?php endif ?>
</main>

<?php include_once ROOT . '/views/layouts/footer.php'; ?>
