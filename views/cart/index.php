<?php include_once ROOT . '/views/layouts/header.php'; ?>

<main>
    <h2>Корзина</h2>
    <?php if ($productsInCart): ?>
        <p>Вы выбрали такие товары:</p>
        <table class="table-bordered table-striped table">
            <tr>
                <th>Код товара</th>
                <th>Название</th>
                <th>Стомость, $</th>
                <th>Количество, шт</th>
                <th>Удалить</th>
            </tr>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo $product['code'];?></td>
                    <td>
                        <a href="/product/<?php echo $product['id'];?>">
                            <?php echo $product['name'];?>
                        </a>
                    </td>
                    <td><?php echo $product['price'];?></td>
                    <td><?php echo $productsInCart[$product['id']];?></td>
                    <td>
                        <a class="checkout" href="/cart/delete/<?php echo $product['id'];?>">
                            <span>X</span>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="4">Общая стоимость, грн:</td>
                <td><?php echo $totalPrice;?></td>
            </tr>
        </table>
        <p>
            <a href="/cart/clear">Удалить всё</a>
        </p>
    <?php else: ?>
        <p>Корзина пуста</p>
        <a href="/">Вернуться к покупкам</a>
    <?php endif; ?>
</main>

<?php include_once ROOT . '/views/layouts/footer.php'; ?>
