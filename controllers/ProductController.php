<?php


class ProductController
{

    public function actionView($productId)
    {

        require_once(ROOT . '/views/product/view.php');

        return true;
    }

}
