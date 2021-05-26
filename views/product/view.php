<?php include_once ROOT . '/views/layouts/header.php'; ?>
<?php
if (!empty($product['tags'])) {
    $tags = '';
    for ($i = 0; $i < count($product['tags']); $i++) {
        $tags .= $i == count($product['tags']) - 1 ? '<span class="tag">#' . $product['tags'][$i]['title'] . '</span>' : '<span class="tag">#' . $product['tags'][$i]['title'] . '</span>, ';
    }
}
?>
<div class="container">
    <section class="single-product">
        <div class="breadcrumbs">
            <?php
            echo Product::getBreadcrumbs($product['category']);
            ?>
        </div>
        <div class="info-item title"><?= $product['title'] ?></div>

        <div class="info-item gallery">
            <img src="/uploads/images/<?= $product['mainImg'] ?>" alt="" class="mainImg">
            <?php if ($product['images'] != null) : ?>
                <div class="images">
                    <?php
                    foreach ($product['images'] as $image) {
                        echo '<img src="/uploads/images/' . $image['url'] . '" alt="" class="mainImg">';
                    }
                    ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="info-item description"><?= $product['description'] ?></div>
        <div class="info-item quantity"><b>Доступен в количестве:</b> <?= $product['quantity'] ?> шт.</div>
        <div class="info-item price">
            <div><b>Цена:</b> <span class="price__regular">&#8372;&nbsp;<?= $product['price'] ?></span></div>
            <?php if ($product['discounts'] != null) : ?>
                <div><b>Скидка:</b> <?= intval($product['discounts'][0]['discount']) ?>%</div>
                <div><b>Цена со скидкой:</b> <span
                            class="price__new">&#8372;&nbsp;<?= $product['price'] - (intval($product['price']) * intval($product['discounts'][0]['discount']) / 100) ?></span>
                </div>
            <?php endif; ?>
        </div>

        <b>Характеристики: </b>
        <div class="info-item features">
            <?php foreach ($product['features'] as $feature) : ?>
                <div class="feature">
                    <span class="feature__title"><b><?= $feature['title'] ?>:</b> </span>
                    <span class="feature__value"><?= $feature['value'] ?></span>
                </div>
            <?php endforeach; ?>
        </div>
        <?php if (!empty($product['tags'])) : ?>
            <div class="info-item tags">
                <b>Тэги:</b> <?= $tags ?>
            </div>
        <?php endif; ?>

        <a href="#" class="btn-block">Добавить в корзину</a>
    </section>

    <?php if (isset($_SESSION['userRole']) && $_SESSION['userRole'] == '2') : ?>
        <div class="control-buttons">
            <a class="btn-block" href="/product/edit/<?= $product['id'] ?>">Редактировать</a>
            <a class="btn-block delete" href="/product/delete/<?= $product['id'] ?>">Удалить</a>
            <a class="btn-block" href="/product/features/<?= $product['id'] ?>">Изменить характеристики</a>
        </div>
    <?php endif; ?>
</div>

<?php include_once ROOT . '/views/layouts/footer.php'; ?>
