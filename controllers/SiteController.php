<?php

class SiteController
{

    public function actionIndex($offset)
    {
        $offset = $_GET['offset'] ?? 0;
        $latestProducts = Product::getLatest($offset);
        $totalNumber = Product::getTotalNumber();

        require_once(ROOT . '/views/site/index.php');

        return true;
    }
}
