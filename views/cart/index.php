<?php include_once ROOT . '/views/layouts/header.php'; ?>

<main>
    <h2>Корзина</h2>
    <?php if ($productsInCart): ?>
        <table class="cart-table">
            <tr>
                <th>Код товара</th>
                <th>Название</th>
                <th>Стомость, $</th>
                <th>Количество, шт</th>
            </tr>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo $product['code']; ?></td>
                    <td>
                        <a href="/product/<?php echo $product['id']; ?>">
                            <?php echo $product['name']; ?>
                        </a>
                    </td>
                    <td><?php echo $product['price']; ?></td>
                    <td><?php echo $productsInCart[$product['id']]; ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="3">Общая стоимость:</td>
                <td><?php echo $totalPrice; ?></td>
            </tr>

        </table>
    <?php else: ?>
        <p>Корзина пуста</p>
    <?php endif; ?>
</main>

<?php include_once ROOT . '/views/layouts/footer.php'; ?>
