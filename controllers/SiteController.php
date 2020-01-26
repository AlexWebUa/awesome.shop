<?php

include_once ROOT . '/models/Product.php';

class SiteController
{

    public function actionIndex()
    {
        $latestProducts = Product::getLatestProducts();

        require_once(ROOT . '/views/site/index.php');

        return true;
    }
}
