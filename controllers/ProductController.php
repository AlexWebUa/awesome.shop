<?php

class ProductController
{

    public function actionView($productId)
    {
        $product = Product::getById($productId);

        require_once(ROOT . '/views/product/view.php');

        return true;
    }

}
