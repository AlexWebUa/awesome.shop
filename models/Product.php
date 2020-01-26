<?php


class Product
{

    const SHOW_BY_DEFAULT = 10;

    /**
     * Returns an array of products
     * @param int $count
     * @return array
     */
    public static function getLatestProducts($count = self::SHOW_BY_DEFAULT)
    {
        $count = intval($count);
        $db = Db::getConnection();
        $productsList = array();

        $result = $db->query('SELECT * FROM products '
            . 'WHERE is_available = "1"'
            . 'ORDER BY id DESC '
            . 'LIMIT ' . $count);

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
    }

}

// TODO: getImage() [, getShortDescription(), getPrice()]
