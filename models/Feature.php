<?php


class Feature
{
    public static function get()
    {
        $db = Db::getConnection();

        $result = $db->query('SELECT * FROM feature');
        $result->setFetchMode(PDO::FETCH_ASSOC);

        return $result->fetchAll();
    }

    public static function getByCategoryId($categoryId) {
        $db = Db::getConnection();

        $result = $db->query('SELECT * FROM feature WHERE categoryId = '.$categoryId);
        $result->setFetchMode(PDO::FETCH_ASSOC);

        return $result->fetchAll();
    }

    public static function getValueByProductId($featureId, $productId) {
        $db = Db::getConnection();

        $result = $db->query('SELECT value FROM product_feature WHERE featureId = '.$featureId.' AND productId = '.$productId);
        $result->setFetchMode(PDO::FETCH_ASSOC);

        return $result->fetchColumn();
    }
}