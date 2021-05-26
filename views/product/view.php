<?php include_once ROOT . '/views/layouts/header.php'; ?>
<?php
    if (!empty($product['tags'])) {
        $tags = '';
        for ($i = 0; $i < count($product['tags']); $i++) {
            $tags .= $i == count($product['tags']) - 1 ? '<span class="tag">#'.$product['tags'][$i]['title'].'</span>' : '<span class="tag">#'.$product['tags'][$i]['title'] . '</span>, ';
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
        <div class="title"><?= $product['title'] ?></div>

        <div class="gallery">
            <img src="/uploads/images/<?= $product['mainImg'] ?>" alt="" class="mainImg">
            <div class="images">
                <?php
                foreach ($product['images'] as $image) {
                    echo '<img src="/uploads/images/'. $image['url'] . '" alt="" class="mainImg">';
                }
                ?>
            </div>
        </div>

        <div class="description"><?= $product['description'] ?></div>
        <div class="quantity">Доступен в количестве: <?= $product['quantity'] ?> шт.</div>
        <div class="price">
            <div>Цена: <span class="price__regular">&#8372;&nbsp;<?= $product['price'] ?></span></div>
            <?php if ($product['discounts'] != null) : ?>
                <div>Скидка: <?= intval($product['discounts'][0]['discount']) ?>%</div>
                <div>Цена со скидкой: <span class="price__new">&#8372;&nbsp;<?= $product['price'] - (intval($product['price']) *  intval($product['discounts'][0]['discount']) / 100)?></span></div>
            <?php endif; ?>
        </div>
        <div class="features">
            <?php foreach ($product['features'] as $feature) : ?>
                <div class="feature">
                    <span class="feature__title"><?= $feature['title']?>: </span>
                    <span class="feature__value"><?= $feature['value']?></span>
                </div>
            <?php endforeach; ?>
        </div>
        <?php if (!empty($product['tags'])) : ?>
        <div class="tags">
            Тэги:<?= $tags ?>
        </div>
        <?php endif; ?>

    </section>

    <?php if ($_SESSION['userRole'] == '2') :?>
        <div class="control-buttons">
            <a href="/product/edit/<?= $product['id'] ?>">Редактировать</a>
            <a href="/product/delete/<?= $product['id'] ?>">Удалить</a>
            <a href="/product/features/<?= $product['id'] ?>">Изменить характеристики</a>
        </div>
    <?php endif; ?>
</div>

<?php include_once ROOT . '/views/layouts/footer.php'; ?>
