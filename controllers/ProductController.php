<?php

class ProductController
{

    public function actionView($productId)
    {
        $product = Product::getById($productId);

        require_once(ROOT . '/views/product/view.php');

        return true;
    }

    /**
     * Adds product in db
     * @return bool
     */
    public function actionAdd()
    {
        if (isset($_POST['submit'])) {
            $options = [
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'metatitle' => $_POST['metatitle'] ?? null,
                'isActive' => $_POST['isActive'] ?? '0',
                'quantity' => $_POST['quantity'],
                'images' => $_POST['images'] ?? null,
                'tags' => $_POST['tags'] ?? null,
                'categoryId' => $_POST['categoryId'],
                'features' => $_POST['features'] ?? null
            ];

            if (isset($_FILES['mainImg']) && $_FILES['mainImg']['error'] != 4) {
                $imageName = $_FILES['mainImg']['name'];
                $imageFileType = pathinfo($imageName, PATHINFO_EXTENSION);

                $options['mainImg'] = $imageName;
            } else {
                $options['mainImg'] = 'product-photo.png';
                $imageFileType = 'png';
            }

            if ($_FILES['images'] != null) {
                for ($i = 0; $i < count($_FILES['images']['name']); $i++) {
                    $imageName = $_FILES['images']['name'][$i];
                    $options['images'][] = ['url' => $imageName];
                }
            }

            if ($_POST['tags'] != null) {
                $tags = explode(' ', $_POST['tags']);
                $existingTags = Tag::get();
                $newTags = [];

                foreach ($tags as $tag) {
                    $isExist = false;

                    foreach ($existingTags as $existingTag) {
                        if ($tag == $existingTag['title']) {
                            $isExist = true;
                        }
                    }

                    if (!$isExist) {
                        $newTags[] = $tag;
                    }
                }

                Tag::add($newTags);

                $tagIds = Tag::getByTitlesArray($tags);

                $options['tags'] = $tagIds;
            }

            $errors = false;
            if (
                !isset($options['title']) || empty($options['title']) ||
                !isset($options['description']) || empty($options['description']) ||
                !isset($options['quantity']) || empty($options['quantity']) ||
                !isset($options['categoryId']) || empty($options['categoryId'])
            ) {
                $errors[] = 'Заполните все поля';
            }

            if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png") {
                $errors[] = 'Можно загружать только файлы с расширением ".jpg", ".jpeg", ".png"';
            }

            if ($_FILES['mainImg']['size'] > 500000) {
                $errors[] = 'Размер файла не должен превышать 5Мб.';
            }

            //$errors = true;
            if ($errors == false) {

                $id = Product::add($options);

                if ($id) {
                    if (is_uploaded_file($_FILES["mainImg"]["tmp_name"])) {
                        move_uploaded_file($_FILES["mainImg"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . "/uploads/images/{$imageName}");
                    }

                    if ($_FILES['images'] != null) {
                        for ($i = 0; $i < count($_FILES['images']['name']); $i++) {
                            move_uploaded_file($_FILES['images']['tmp_name'][$i], $_SERVER['DOCUMENT_ROOT'] . "/uploads/images/{$_FILES['images']['name'][$i]}");
                        }
                    }
                }

                header("Location: /product/" . $id);
            }
        }

        require_once(ROOT . '/views/product/add.php');
        return true;
    }

    public function actionAddFeatures($productId)
    {
        $product = Product::getById($productId);
        $categoryFeatures = Feature::getByCategoryId($product['category']['id']);
        $newFeatures = [];
        $existingFeatures = [];

        foreach ($categoryFeatures as &$categoryFeature) {
            $categoryFeature['value'] = Feature::getValueByProductId(intval($categoryFeature['id']), intval($productId));
        }

        if (isset($_POST['submit'])) {
            $postedData = $_POST;

            foreach ($postedData as $key => $value) {
                if ($key != 'submit') {
                    $exists = false;

                    foreach ($categoryFeatures as $categoryFeature) {
                        if (in_array($key, $categoryFeature) && $categoryFeature['value'] != null) $exists = true;
                    }
                    if ($exists) {
                        $existingFeatures[] = ['featureId' => $key, 'value' => $value];
                    } else {
                        $newFeatures[] = ['featureId' => $key, 'value' => $value];
                    }
                }
            }

            var_dump($existingFeatures, $newFeatures);

            if (!empty($existingFeatures)) Product::updateFeatures($productId, $existingFeatures);
            if (!empty($newFeatures)) Product::addFeatures($productId, $newFeatures);

            header("Location: /product/" . $productId);
        }


        require_once(ROOT . '/views/product/addFeatures.php');
        return true;
    }

    public function actionDelete($productId)
    {
        $result = Product::delete($productId);

        require_once(ROOT . '/views/product/delete.php');

        return true;
    }

}
