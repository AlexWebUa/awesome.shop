<?php


class Product
{

    const SHOW_BY_DEFAULT = 10;

    /**
     * Splits data from the resulting array into an associative array
     * @param $result
     * @return array
     */
    public static function fetchResult($result)
    {
        $productsList = array();

        $i = 0;
        while ($row = $result->fetch()) {
            $productsList[$i]['id'] = $row['id'];
            $productsList[$i]['name'] = $row['name'];
            $productsList[$i]['code'] = $row['code'];
            $productsList[$i]['price'] = $row['price'];
            $productsList[$i]['brand'] = $row['brand'];
            $productsList[$i]['image'] = $row['image'];
            $productsList[$i]['description'] = $row['description'];
            $productsList[$i]['is_new'] = $row['is_new'];
            $i++;
        }

        return $productsList;
    }

    /**
     * Returns an array of products
     * @param int $count
     * @return array
     */
    public static function getLatestProducts($count = self::SHOW_BY_DEFAULT)
    {
        $count = intval($count);
        $db = Db::getConnection();

        $result = $db->query('SELECT * FROM products '
            . 'WHERE is_available = "1"'
            . 'ORDER BY id DESC '
            . 'LIMIT ' . $count);

        return self::fetchResult($result);
    }

    /**
     * Returns product item by id
     * @param integer $id
     * @return mixed
     */
    public static function getProductById($id)
    {
        $id = intval($id);

        if ($id) {
            $db = Db::getConnection();

            $result = $db->query('SELECT * FROM products WHERE id=' . $id);
            $result->setFetchMode(PDO::FETCH_ASSOC);

            return $result->fetch();
        }

        return false;
    }

    /**
     * Returns products info from db
     * @param $idsArray
     * @return array
     */
    public static function getProductsByIds($idsArray)
    {
        $products = array();

        $db = Db::getConnection();

        $idsString = implode(',', $idsArray);

        $sql = "SELECT * FROM products WHERE is_available='1' AND id IN ($idsString)";

        $result = $db->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);

        return self::fetchResult($result);
    }

    /**
     * Get all products from db
     * @return array
     */
    public static function getProductsList()
    {
        $db = Db::getConnection();

        $result = $db->query('SELECT * FROM products ORDER BY id ASC');

        return self::fetchResult($result);
    }

    /**
     * Add product in db
     * @param $options
     * @return int|string
     */
    public static function addProduct($options)
    {
        $db = Db::getConnection();

        $sql = 'INSERT INTO products '
            . '(name, code, price, brand, image, description, is_available, is_new)'
            . 'VALUES '
            . '(:name, :code, :price, :brand, :image, :description, :is_available, :is_new)';

        $result = $db->prepare($sql);
        $result->bindParam(':name', $options['name'], PDO::PARAM_STR);
        $result->bindParam(':code', $options['code'], PDO::PARAM_STR);
        $result->bindParam(':price', $options['price'], PDO::PARAM_STR);
        $result->bindParam(':brand', $options['brand'], PDO::PARAM_STR);
        $result->bindParam(':image', $options['image'], PDO::PARAM_STR);
        $result->bindParam(':description', $options['description'], PDO::PARAM_STR);
        $result->bindParam(':is_available', $options['is_available'], PDO::PARAM_INT);
        $result->bindParam(':is_new', $options['is_new'], PDO::PARAM_INT);
        if ($result->execute()) {
            return $db->lastInsertId();
        }
        return 0;
    }

    public static function updateProductById($id, $options)
    {
        $db = Db::getConnection();

        $sql = "UPDATE products
            SET 
                name = :name, 
                code = :code, 
                price = :price,  
                brand = :brand, 
                image = :image, 
                description = :description,
                is_new = :is_new, 
                is_available = :is_available
            WHERE id = :id";

        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':name', $options['name'], PDO::PARAM_STR);
        $result->bindParam(':code', $options['code'], PDO::PARAM_STR);
        $result->bindParam(':price', $options['price'], PDO::PARAM_STR);
        $result->bindParam(':brand', $options['brand'], PDO::PARAM_STR);
        $result->bindParam(':image', $options['image'], PDO::PARAM_STR);
        $result->bindParam(':description', $options['description'], PDO::PARAM_STR);
        $result->bindParam(':is_new', $options['is_new'], PDO::PARAM_INT);
        $result->bindParam(':is_available', $options['is_available'], PDO::PARAM_INT);
        return $result->execute();
    }

    public static function deleteProductById($id)
    {
        $db = Db::getConnection();

        $sql = 'DELETE FROM products WHERE id = :id';

        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        return $result->execute();
    }

}
