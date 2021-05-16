<?php

class CabinetController
{

    /**
     * Checks if user logged and shows cabinet
     * @return bool
     */
    public function actionIndex()
    {
        $userId = User::checkLogged();

        $user = User::getUserById($userId);
        $productsList = Product::getProductsList();

        require_once(ROOT . '/views/cabinet/index.php');

        return true;
    }

    /**
     * Updates information about product with specified id
     * @param $id
     * @return bool
     */
    public function actionUpdate($id)
    {
        $product = Product::getById($id);

        if (isset($_POST['submit'])) {
            $options['name'] = $_POST['name'];
            $options['code'] = $_POST['code'];
            $options['price'] = $_POST['price'];
            $options['brand'] = $_POST['brand'];
            $options['description'] = $_POST['description'];
            $options['is_new'] = $_POST['is_new'];
            $options['is_available'] = $_POST['is_available'];

            if (isset($_FILES['image']) && ($_FILES['image']['name'] != '')) {
                $imageName = $_FILES['image']['name'];
                $options['image'] = $imageName;
            } else {
                $options['image'] = 'product-photo.png';
            }

            if (Product::updateProductById($id, $options)) {
                if (isset($imageName)) {
                    move_uploaded_file($imageName, $_SERVER['DOCUMENT_ROOT'] . "/uploads/images/");
                }
            }

            header("Location: /cabinet/");
        }

        require_once(ROOT . '/views/cabinet/update.php');
        return true;
    }

    /**
     * Deletes product with specified id from db
     * @param $id
     * @return bool
     */
    public function actionDelete($id)
    {

        if (isset($_POST['submit'])) {
            Product::deleteProductById($id);
            header("Location: /cabinet/");
        }

        require_once(ROOT . '/views/cabinet/delete.php');
        return true;
    }

}
