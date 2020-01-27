<?php include_once ROOT . '/views/layouts/header.php'; ?>

<main>
    <h2>Каталог товаров</h2>
    <section class="products">

        <?php foreach ($latestProducts as $product): ?>
            <div class="product">
                <img src="/uploads/images/<?= $product['image'] ?>" alt="<?= $product['image'] ?>"
                     class="product-image">
                <h3>
                    <a href="<?= '/product/' . $product['id'] ?>" class="product-name"><?= $product['name']; ?></a>
                </h3>
                <p class="product-price"><?= $product['price']; ?>$</p>
                <p class="product-short-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsam,
                    repudiandae.</p>
                <button class="to-cart">
                    <a href="/cart/add/<?= $product['id']; ?>">В корзину</a>
                </button>
                <?php if ($product['is_new']): ?>
                    <img src="/assets/images/new.png" alt="" class="new">
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

    </section>
</main>

<?php include_once ROOT . '/views/layouts/footer.php'; ?>
