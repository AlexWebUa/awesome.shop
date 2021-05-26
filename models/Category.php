<?php


class Category
{
    public static function get()
    {
        $db = Db::getConnection();

        $result = $db->query('SELECT * FROM category');
        $result->setFetchMode(PDO::FETCH_ASSOC);

        return $result->fetchAll();
    }

    public static function getParentCategories(&$categoryArray)
    {
        if ($categoryArray['parentId'] == null) {
            return $categoryArray;
        } else {
            $categoryArray['parent'] = Category::getById($categoryArray['parentId']);
            self::getParentCategories($categoryArray['parent']);
        }

        return $categoryArray;
    }

    public static function getById($id)
    {
        $id = intval($id);

        if ($id) {
            $db = Db::getConnection();

            $product = $db->query(
                'SELECT * FROM category WHERE id =' . $id
            );
            $product->setFetchMode(PDO::FETCH_ASSOC);

            return $product->fetch();
        }

        return false;
    }
}