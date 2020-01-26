<?php include_once ROOT . '/views/layouts/header.php'; ?>

<main>
    <section class="single-product">
        <img src="/assets/images/product-photo.png" alt="">
        <h2><?= $product['name']; ?></h2>
        <p class="product-price"><?= $product['price']; ?>$</p>
        <p class="product-code">Code: <?= $product['code'] ?></p>
        <p class="product-brand">Brand: <?= $product['brand'] ?></p>

        <p class="product-description"><?= $product['description'] ?></p>
        <button class="to-cart">Add to cart</button>
    </section>
    
</main>

<?php include_once ROOT . '/views/layouts/footer.php'; ?>
