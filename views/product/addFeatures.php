<?php include_once ROOT . '/views/layouts/header.php'; ?>

<main>
    <h2><?= $product['title'] ?></h2>
    <form action="#" method="post">
        <?php
        var_dump($product);
        foreach ($categoryFeatures as $categoryFeature) :
        ?>
            <label><?= $categoryFeature['title']?>: <input type="text" name="<?= $categoryFeature['id']?>" value="<?= $categoryFeature['value']?>"></label> <br>
        <?php endforeach;?>
        <input type="submit" name="submit" value="Submit">
    </form>
</main>

<?php include_once ROOT . '/views/layouts/footer.php'; ?>
