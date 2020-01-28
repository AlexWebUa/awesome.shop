<?php include_once ROOT . '/views/layouts/header.php'; ?>

<main>
    <h2>Кабинет пользователя <?= $user['name'] ?></h2>
    <section class="cabinet">
        <?php if ($user['is_admin'] == '1') : ?>
            <a href="/cabinet/add" class="add-product">Добавить товар</a>

            <h4>Список товаров</h4>

            <table>
                <tr>
                    <th>ID</th>
                    <th>Код</th>
                    <th>Название</th>
                    <th>Цена</th>
                    <th></th>
                    <th></th>
                </tr>
                <?php foreach ($productsList as $product): ?>
                    <tr>
                        <td><?php echo $product['id']; ?></td>
                        <td><?php echo $product['code']; ?></td>
                        <td><?php echo $product['name']; ?></td>
                        <td><?php echo $product['price']; ?></td>
                        <td><a href="/cabinet/update/<?php echo $product['id']; ?>">Редактировать</a></td>
                        <td><a href="/cabinet/delete/<?php echo $product['id']; ?>">Удалить</a></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </section>
</main>

<?php include_once ROOT . '/views/layouts/footer.php'; ?>
