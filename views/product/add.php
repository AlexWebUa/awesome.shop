<?php include_once ROOT . '/views/layouts/header.php'; ?>

<main>
    <h2>Add product</h2>

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

                <label>Title: <input type="text" name="title" placeholder="" value="<?= $_POST['title'] ?? '' ?>" required></label>
                <label>Description: <textarea name="description" cols="30" rows="10" required><?= $_POST['description'] ?? '' ?></textarea></label>
                <label>Metatitle: <input type="text" name="metatitle" placeholder="" value="<?= $_POST['metatitle'] ?? '' ?>"></label>
                <label>Active: <input type="checkbox" name="isActive" checked value="1"></label>
                <label>Quantity: <input name="quantity" type="number" min="0" onkeypress="return event.charCode >= 48" required value="<?= $_POST['quantity'] ?? '' ?>"></label>

                <!--TODO: features-->

                <label>Main image: <input type="file" name="mainImg"></label>
                <label>Additional image(s): <input type="file" name="images[]" multiple></label>
                <label>Tags: <input type="text" name="tags"></label>

                <label>
                    Category:
                    <select name="categoryId">
                        <?php
                        $categories = Category::get();

                        foreach ($categories as $category) {
                            echo '<option value="'.$category['id'].'">'.$category['title'].'</option>';
                        }
                        ?>
                    </select>
                </label>

                <input type="submit" name="submit" value="Submit">

                <br/><br/>

            </form>
        </div>
    </div>
</main>

<?php include_once ROOT . '/views/layouts/footer.php'; ?>
