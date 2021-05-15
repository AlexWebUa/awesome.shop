<?php

class SiteController
{

    public function actionIndex()
    {
        $latestProducts = Product::getLatest();

        require_once(ROOT . '/views/site/index.php');

        return true;
    }
}
