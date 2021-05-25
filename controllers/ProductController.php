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
            $errors = false;

            $options = [
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'metatitle' => $_POST['metatitle'] ?? null,
                'isActive' => $_POST['isActive'] ?? '0',
                'quantity' => $_POST['quantity'],
                'images' => $_POST['images'] ?? null,
                'tags' => $_POST['tags'] ?? null,
                'categoryId' => $_POST['categoryId'],
                'features' => $_POST['features'] ?? null,
                'discount' => $_POST['discount'] ?? null,
                'startDate' => $_POST['startDate'] ?? null,
                'finishDate' => $_POST['finishDate'] ?? null
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

            if ($_POST['discount'] != null && $_POST['startDate'] != null && $_POST['finishDate'] != null) {
                if ($_POST['startDate'] > $_POST['finishDate']) {
                    $errors[] = 'Начало должно быть раньше конца';
                } else {
                    $options['startDate'] = date("Y-m-d H:i:s",strtotime($_POST['startDate']));
                    $options['finishDate'] = date("Y-m-d H:i:s",strtotime($_POST['finishDate']));
                }
            }

            if (
                !isset($options['title']) || empty($options['title']) ||
                !isset($options['description']) || empty($options['description']) ||
                !isset($options['quantity']) || empty($options['quantity'])
            ) {
                $errors[] = 'Заполните все поля';
            }

            if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png") {
                $errors[] = 'Можно загружать только файлы с расширением ".jpg", ".jpeg", ".png"';
            }

            if ($_FILES['mainImg']['size'] > 500000) {
                $errors[] = 'Размер файла не должен превышать 5Мб.';
            }

            if ($errors == false) {

                $id = Product::add($options);

                if ($id) {
                    if (is_uploaded_file($_FILES["mainImg"]["tmp_name"])) {
                        $fullPath = $_SERVER['DOCUMENT_ROOT'] . "/uploads/images/{$imageName}";
                        if (!file_exists($fullPath))
                            move_uploaded_file($_FILES["mainImg"]["tmp_name"], $fullPath);
                    }

                    if ($_FILES['images'] != null) {
                        for ($i = 0; $i < count($_FILES['images']['name']); $i++) {
                            $fullPath = $_SERVER['DOCUMENT_ROOT'] . "/uploads/images/{$_FILES['images']['name'][$i]}";
                            if (!file_exists($fullPath))
                                move_uploaded_file($_FILES['images']['tmp_name'][$i], $fullPath);
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

    public function actionEdit($productId) {
        $product = Product::getById($productId);

        if (isset($_POST['submit'])) {
            $errors = false;

            $options = [
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'metatitle' => $_POST['metatitle'] ?? '',
                'isActive' => $_POST['isActive'] ?? '0',
                'quantity' => $_POST['quantity'],
                'tags' => $_POST['tags'] ?? null,
                'categoryId' => $_POST['categoryId']
            ];

            if (isset($_FILES['mainImg']) && $_FILES['mainImg']['error'] != 4) {
                $imageName = $_FILES['mainImg']['name'];
                $imageFileType = pathinfo($imageName, PATHINFO_EXTENSION);

                $options['mainImg'] = $imageName;
            } else {
                $options['mainImg'] = 'product-photo.png';
            }

            /*if (isset($_FILES['images']) && $_FILES['images']['error'][0] != 4) {
                for ($i = 0; $i < count($_FILES['images']['name']); $i++) {
                    $imageName = $_FILES['images']['name'][$i];
                    $options['images'][] = ['url' => $imageName];
                }
            }*/

            /*if ($_POST['tags'] != null) {
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
            }*/

            /*if ($_POST['discount'] != null && $_POST['startDate'] != null && $_POST['finishDate'] != null) {
                if ($_POST['startDate'] > $_POST['finishDate']) {
                    $errors[] = 'Начало должно быть раньше конца';
                } else {
                    $options['discount'] = $_POST['discount'];
                    $options['startDate'] = date("Y-m-d H:i:s",strtotime($_POST['startDate']));
                    $options['finishDate'] = date("Y-m-d H:i:s",strtotime($_POST['finishDate']));
                }
            }*/

            if ($errors == false) {
                $success = Product::update($productId, $options);

                if (is_uploaded_file($_FILES["mainImg"]["tmp_name"])) {
                    $fullPath = $_SERVER['DOCUMENT_ROOT'] . "/uploads/images/{$imageName}";
                    if (!file_exists($fullPath))
                        move_uploaded_file($_FILES["mainImg"]["tmp_name"], $fullPath);
                }

                /*if ($_FILES['images'] != null) {
                    for ($i = 0; $i < count($_FILES['images']['name']); $i++) {
                        $fullPath = $_SERVER['DOCUMENT_ROOT'] . "/uploads/images/{$_FILES['images']['name'][$i]}";
                        if (!file_exists($fullPath))
                            move_uploaded_file($_FILES['images']['tmp_name'][$i], $fullPath);
                    }
                }*/

                if ($success) header("Location: /product/" . $productId);
            }
        }


        require_once(ROOT . '/views/product/edit.php');
        return true;
    }

    public function actionDelete($productId)
    {
        $result = Product::delete($productId);

        require_once(ROOT . '/views/product/delete.php');

        return true;
    }

}
