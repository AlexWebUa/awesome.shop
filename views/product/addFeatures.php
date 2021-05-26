<?php include_once ROOT . '/views/layouts/header.php'; ?>

<div class="container">
    <section class="features-add">
        <h2><?= $product['title'] ?></h2>
        <form action="#" method="post">
            <?php foreach ($product['features'] as $feature) : ?>
                <label><?= $feature['title']?>: <input type="text" name="<?= $feature['id']?>" value="<?= $feature['value']?>"></label> <br>
            <?php endforeach;?>
            <input class="btn-block" type="submit" name="submit" value="Отправить">
        </form>
    </section>
</div>

<?php include_once ROOT . '/views/layouts/footer.php'; ?>
