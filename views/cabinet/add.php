<?php include_once ROOT . '/views/layouts/header.php'; ?>

<main>
    <h2>Добавить товар</h2>

    <?php if (isset($errors) && is_array($errors)): ?>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li> - <?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <div>
        <div>
            <form action="#" method="post" enctype="multipart/form-data">

                <label>Название: <input type="text" name="name" placeholder="" value=""></label>

                <label>Код: <input type="text" name="code" placeholder="" value=""></label>

                <label>Цена: <input type="text" name="price" placeholder="" value=""></label>

                <label>Производитель: <input type="text" name="brand" placeholder="" value=""></label>

                <label>Картинка: <input type="file" name="image" placeholder="" value=""></label>


                <label>
                    Новинка:
                    <select name="is_new">
                        <option value="1" selected="selected">Да</option>
                        <option value="0">Нет</option>
                    </select>
                </label>

                <label>
                    Наличие:
                    <select name="is_available">
                        <option value="1" selected="selected">Есть</option>
                        <option value="0">Нет</option>
                    </select>
                </label>

                <input type="submit" name="submit" value="Сохранить">

                <br/><br/>

            </form>
        </div>
    </div>
</main>

<?php include_once ROOT . '/views/layouts/footer.php'; ?>
