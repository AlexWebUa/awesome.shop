<?php include_once ROOT . '/views/layouts/header.php'; ?>

<div class="container">
    <section class="products">
        <?php foreach ($latestProducts as $product): ?>
            <div class="product<?php if ($product['discount'] != null) echo ' discount';
            if (!$product['isActive']) echo ' disabled'; ?>">
                <a href="<?= '/product/' . $product['id'] ?>">
                    <img src="/uploads/images/<?= $product['mainImg'] ?>" alt="" class="product__img">
                </a>
                <div class="product__info">
                    <a href="<?= '/product/' . $product['id'] ?>" class="title"><?= $product['title']; ?></a>
                    <div class="description"><?= mb_strimwidth($product['description'], 0, 80, '...') ?></div>
                    <?php if ($product['discount'] != null) : ?>
                        <div class="discount">-<?= $product['discount'] ?>%</div>
                    <?php endif; ?>
                </div>
                <div class="price">
                    <?php if ($product['discount'] != null) : ?>
                        <span class="price__old">&#8372;&nbsp;<?= $product['price'] ?></span>
                        <span class="price__new">&#8372;&nbsp;<?= $product['price'] - (intval($product['price']) * intval($product['discount']) / 100) ?></span>
                    <?php else : ?>
                        <span class="price__regular">&#8372;&nbsp;<?= $product['price'] ?></span>
                    <?php endif; ?>
                </div>
                <a href="#" class="btn">В корзину</a>
            </div>
        <?php endforeach; ?>
    </section>

    <?php
    if ($totalNumber > 10):
        ?>
        <div class="pagination">
            <?php for ($i = 0; $i < ceil($totalNumber / 10); $i++) : ?>
                <a href="/?offset=<?= $i * 8 ?>"><?= $i + 1 ?></a>
            <?php endfor; ?>
        </div>
    <?php endif ?>
</div>

<?php include_once ROOT . '/views/layouts/footer.php'; ?>
