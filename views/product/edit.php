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

<main>
    <h2>Edit product</h2>

    <?php var_dump($product); ?>

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

                <label>Title*: <input type="text" name="title" placeholder="" value="<?= $product['title'] ?? '' ?>" required></label>
                <label>Description*: <textarea name="description" cols="30" rows="10" required><?= $product['description'] ?? '' ?></textarea></label>
                <label>Metatitle: <input type="text" name="metatitle" placeholder="" value="<?= $product['metatitle'] ?? '' ?>"></label>
                <label>Active: <input type="checkbox" name="isActive" <?= $product['isActive'] ? 'checked' : '' ?> value="1"></label>
                <label>Quantity*: <input type="number" name="quantity" min="0" onkeypress="return event.charCode >= 48" required value="<?= $product['quantity'] ?? '' ?>"></label>
                <label>Price*: <input type="number" name="price" min="0" onkeypress="return event.charCode >= 48" required value="<?= $product['price'] ?? '' ?>"></label>
                <label>Main image: <input type="file" name="mainImg"></label>
                <label>Additional image(s): <input type="file" name="images[]" multiple></label>
                <label>Tags: <input type="text" name="tags" value="<?= $tags ?? '' ?>"></label>

                <label>
                    Category:
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

                <br>

                <br>
                DISCOUNT:

                <label>Discount size: <input type="number" name="discount" min="0" max="100" value="<?= $product['discounts'][0]['discount'] ?? '' ?>" onkeypress="return event.charCode >= 48"></label>
                <label>Start date: <input type="date" name="startDate" value="<?= $startDate ?? '' ?>"></label>
                <label>Finish date: <input type="date" name="finishDate" value="<?= $finishDate ?? '' ?>"></label>

                <input type="submit" name="submit" value="Submit">

                <br/><br/>

            </form>

            <a href="/product/features/<?= $product['id'] ?>">Edit features</a>
        </div>
    </div>
</main>

<?php include_once ROOT . '/views/layouts/footer.php'; ?>
