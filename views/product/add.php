<?php include_once ROOT . '/views/layouts/header.php'; ?>

<div class="container">
    <section class="product-add">
        <form action="#" method="post" enctype="multipart/form-data">

            <label>Название*: <input type="text" name="title" placeholder="" value="<?= $_POST['title'] ?? '' ?>" required></label>
            <label class="flex-start">Описание*: <textarea name="description" cols="30" rows="10" required><?= $_POST['description'] ?? '' ?></textarea></label>
            <label>Метаописание: <input type="text" name="metatitle" placeholder="" value="<?= $_POST['metatitle'] ?? '' ?>"></label>
            <label>Доступен: <input type="checkbox" name="isActive" checked value="1"></label>
            <label>Количество*: <input type="number" name="quantity" min="0" onkeypress="return event.charCode >= 48" required value="<?= $_POST['quantity'] ?? '' ?>"></label>
            <label>Цена*: <input type="number" name="price" min="0" onkeypress="return event.charCode >= 48" required value="<?= $_POST['price'] ?? '' ?>"></label>
            <label>Главная картинка: <input type="file" name="mainImg"></label>
            <label>Дополнительные картинки: <input type="file" name="images[]" multiple></label>
            <label>Тэги: <input type="text" name="tags"></label>

            <label>
                Категория:
                <select name="categoryId">
                    <?php
                    $categories = Category::get();

                    foreach ($categories as $category) {
                        echo '<option value="'.$category['id'].'">'.$category['title'].'</option>';
                    }
                    ?>
                </select>
            </label>

            <br><br>
            БЛОК СКИДКИ:
            <label>Размер: <input type="number" name="discount" min="0" max="100" onkeypress="return event.charCode >= 48"></label>
            <label>Дата начала: <input type="date" name="startDate"></label>
            <label>Дата конца: <input type="date" name="finishDate"></label>

            <input class="btn-block" type="submit" name="submit" value="Добавить">
        </form>
    </section>
</div>

<?php include_once ROOT . '/views/layouts/footer.php'; ?>
