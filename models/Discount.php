<?php


class Discount
{
    public static function getByProductId($productId)
    {
        $productId = intval($productId);

        if ($productId) {
            $db = Db::getConnection();

            $discounts = $db->query(
                'SELECT * FROM discount WHERE discount.productId =' . $productId
            );
            $discounts->setFetchMode(PDO::FETCH_ASSOC);

            return $discounts->fetchAll();
        }

        return false;
    }

    public static function getRecentDiscounts($productId)
    {
        $productId = intval($productId);

        if ($productId) {
            $db = Db::getConnection();

            $discounts = $db->query(
                'SELECT * FROM discount '
                . 'WHERE discount.productId =' . $productId
                . ' AND CURRENT_TIMESTAMP < discount.finishDate AND completedBeforeDeadline = 0'
            );
            $discounts->setFetchMode(PDO::FETCH_ASSOC);

            return $discounts->fetchAll();
        }

        return false;
    }
}