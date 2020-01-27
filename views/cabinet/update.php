<?php include_once ROOT . '/views/layouts/header.php'; ?>

<main>
    <h2>Редактировать товар</h2>
    <div>
        <div>
            <form action="#" method="post" enctype="multipart/form-data">

                <label>Название: <input type="text" name="name" placeholder="" value="<?= $product['name'] ?>"></label>

                <label>Код: <input type="text" name="code" placeholder="" value="<?= $product['code'] ?>"></label>

                <label>Цена: <input type="text" name="price" placeholder="" value="<?= $product['price'] ?>"></label>

                <label>Производитель: <input type="text" name="brand" placeholder=""
                                             value="<?= $product['brand'] ?>"></label>

                <label>Картинка:
                    <img src="/uploads/images/<?= $product['image'] ?>" width="200" alt=""/>
                    <input type="file" name="image" placeholder="" value="<?= $product['image']; ?>">
                </label>

                <label>Описание: <textarea name="description" id="" cols="30"
                                           rows="10"><?= $product['description']; ?></textarea></label>

                <label>
                    Новинка:
                    <select name="is_new">
                        <option value="1" <?php if ($product['is_new'] == '1') echo 'selected="selected"'; ?>>Да
                        </option>
                        <option value="0" <?php if ($product['is_new'] == '0') echo 'selected="selected"'; ?>>Нет
                        </option>
                    </select>
                </label>

                <label>
                    Наличие:
                    <select name="is_available">
                        <option value="1" <?php if ($product['is_available'] == '1') echo 'selected="selected"'; ?>>
                            Есть
                        </option>
                        <option value="0" <?php if ($product['is_available'] == '0') echo 'selected="selected"'; ?>>
                            Нет
                        </option>
                    </select>
                </label>

                <input type="submit" name="submit" value="Сохранить">

            </form>
        </div>
    </div>

</main>

<?php include_once ROOT . '/views/layouts/footer.php'; ?>
