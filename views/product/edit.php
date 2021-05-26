<?php include_once ROOT . '/views/layouts/header.php';

if (!empty($product['discounts'])) {
    $startDate = date("Y-m-d",strtotime($product['discounts'][0]['startDate']));
    $finishDate = date("Y-m-d",strtotime($product['discounts'][0]['finishDate']));
}

if (!empty($product['tags'])) {
    $tags = '';
    for ($i = 0; $i < count($product['tags']); $i++) {
        $tags .= $i == count($product['tags']) - 1 ? $product['tags'][$i]['title'] : $product['tags'][$i]['title'] . ' ';
    }
}

?>

<div class="container">
    <section class="product-edit">
        <form action="#" method="post" enctype="multipart/form-data">

            <label>Название*: <input type="text" name="title" placeholder="" value="<?= $product['title'] ?? '' ?>" required></label>
            <label class="flex-start">Описание*: <textarea name="description" cols="30" rows="10" required><?= $product['description'] ?? '' ?></textarea></label>
            <label>Метаописание: <input type="text" name="metatitle" placeholder="" value="<?= $product['metatitle'] ?? '' ?>"></label>
            <label>Доступен: <input type="checkbox" name="isActive" <?= $product['isActive'] ? 'checked' : '' ?> value="1"></label>
            <label>Количество*: <input type="number" name="quantity" min="0" onkeypress="return event.charCode >= 48" required value="<?= $product['quantity'] ?? '' ?>"></label>
            <label>Цена*: <input type="number" name="price" min="0" onkeypress="return event.charCode >= 48" required value="<?= $product['price'] ?? '' ?>"></label>
            <label>Главная картинка: <input type="file" name="mainImg"></label>
            <label>Дополнительные картинки: <input type="file" name="images[]" multiple></label>
            <label>Тэги: <input type="text" name="tags" value="<?= $tags ?? '' ?>"></label>

            <label>
                Категория:
                <select name="categoryId">
                    <?php
                        $categories = Category::get();

                        foreach ($categories as $category) {
                            $selected = $product['category']['id'] == $category['id'] ? 'selected': '';
                            echo '<option value="'.$category['id'].'" '. $selected .' >'.$category['title'].'</option>';
                        }
                    ?>
                </select>
            </label>

            <br><br>
            БЛОК СКИДКИ:
            <label>Размер: <input type="number" name="discount" min="0" max="100" value="<?= $product['discounts'][0]['discount'] ?? '' ?>" onkeypress="return event.charCode >= 48"></label>
            <label>Дата начала: <input type="date" name="startDate" value="<?= $startDate ?? '' ?>"></label>
            <label>Дата конца: <input type="date" name="finishDate" value="<?= $finishDate ?? '' ?>"></label>

            <input class="btn-block" type="submit" name="submit" value="Подтвердить">
        </form>

        <a class="btn-block" href="/product/features/<?= $product['id'] ?>">Изменить характеристики</a>
    </section>
</div>

<?php include_once ROOT . '/views/layouts/footer.php'; ?>
