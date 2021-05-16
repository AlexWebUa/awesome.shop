<?php


class Product
{

    const SHOW_BY_DEFAULT = 10;

    /**
     * Returns an array of latest products
     * @param int $count
     * @return array
     */
    public static function getLatest(int $count = self::SHOW_BY_DEFAULT)
    {
        $count = intval($count);
        $db = Db::getConnection();

        $result = $db->query('SELECT product.*, discount.discount, discount.startDate, discount.finishDate, discount.completedBeforeDeadline, active_products.isActive '
            . 'FROM product '
            . 'LEFT JOIN active_products ON product.id = active_products.productId '
            . 'LEFT JOIN discount ON product.id = discount.productId '
            . 'ORDER BY id DESC '
            . 'LIMIT ' . $count);
        //TODO: recent discounts

        $result->setFetchMode(PDO::FETCH_ASSOC);

        return $result->fetchAll();
    }

    /**
     * Returns product item by id
     * @param integer $id
     * @return mixed
     */
    public static function getById(int $id)
    {
        $id = intval($id);

        if ($id) {
            $db = Db::getConnection();

            /*** Product ***/
            $product = $db->query(
                'SELECT product.*, active_products.isActive, storage.quantity '
                . 'FROM product '
                . 'LEFT JOIN active_products ON product.id = active_products.productId ' // isActive
                . 'LEFT JOIN storage ON product.id = storage.productId ' // quantity
                . 'WHERE product.id = ' . $id
            );
            $product->setFetchMode(PDO::FETCH_ASSOC);
            $result = $product->fetch();


            /*** Categories ***/
            $product_category = $db->query(
                'SELECT categoryId FROM product_category where productId =' . $result['id']
            );
            $categoryId = $product_category->fetch()['categoryId'];
            $category = Category::getById($categoryId);
            $result['category'] = Category::getParentCategories($category);


            /*** Features ***/
            $features = $db->query(
                'SELECT feature.title, product_feature.value '
                . 'FROM product_feature '
                . 'LEFT JOIN feature ON product_feature.productId = ' . $id
                . ' WHERE feature.id = product_feature.featureId'
            );
            $features->setFetchMode(PDO::FETCH_ASSOC);
            $result['features'] = $features->fetchAll();


            /*** Tags ***/
            $tags = $db->query(
                'SELECT title FROM ( '
                . 'SELECT product_tag.*, tag.title '
                . 'FROM product_tag '
                . 'LEFT JOIN tag ON product_tag.tagId = tag.id '
                . 'WHERE product_tag.productId =' . $id
                . ') AS t1'
            );
            $tags->setFetchMode(PDO::FETCH_ASSOC);
            $result['tags'] = $tags->fetchAll();


            /*** Discounts ***/
            $result['discounts'] = Discount::getRecentDiscounts($id);


            /*** Images ***/
            $images = $db->query(
                'SELECT images.url FROM images WHERE images.productId =' . $id
            );
            $images->setFetchMode(PDO::FETCH_ASSOC);
            $result['images'] = $images->fetchAll();


            return $result;
        }

        return false;
    }


    /**
     * Add product in db
     * @param $options
     * @return int|string
     */
    public static function add($options)
    {
        $db = Db::getConnection();
        $productId = intval($db->query('SELECT MAX(id) FROM product')->fetchColumn()) + 1;

        /*** Product ***/
        $productData = [
            'title' => $options['title'],
            'description' => $options['description'],
            'metatitle' => $options['metatitle'],
            'mainImg' => $options['mainImg'],
        ];
        $productSql = 'INSERT INTO product (title, description, metatitle, mainImg) VALUES (:title, :description, :metatitle, :mainImg)';
        $productInsert = $db->prepare($productSql)->execute($productData);

        /*** Active products ***/
        $active_productsSql = 'INSERT INTO active_products (productId, isActive) VALUES (' . $productId . ', ' . $options['isActive'] . ')';
        $active_productsInsert = $db->prepare($active_productsSql)->execute();

        /*** Storage ***/
        $storageSql = 'INSERT INTO storage (productId, quantity) VALUES (' . $productId . ', ' . $options['quantity'] . ')';
        $storageInsert = $db->prepare($storageSql)->execute();

        /*** Images ***/
        if (!empty($options['images'])) {
            $imagesSql = $db->prepare('INSERT INTO images (productId, url) VALUES (?,?)');
            foreach ($options['images'] as $image) {
                $imagesSql->execute([$productId, $image['url']]);
            }
        }

        /*** Tags ***/
        if (!empty($options['tags'])) {
            $product_tagSql = $db->prepare('INSERT INTO product_tag (productId, tagId) VALUES (?,?)');
            foreach ($options['tags'] as $tag) {
                $product_tagSql->execute([$productId, $tag['id']]);
            }
        }

        /*** Category ***/
        $product_categorySql = 'INSERT INTO product_category (productId, categoryId) VALUES (' . $productId . ', ' . $options['categoryId'] . ')';
        $product_categoryInsert = $db->prepare($product_categorySql)->execute();

        /*** Features ***/
        if (!empty($options['features'])) {
            $product_featureSql = $db->prepare('INSERT INTO product_feature (productId, featureId, value) VALUES (?, ?, ?)');
            foreach ($options['features'] as $feature) {
                $product_featureSql->execute([$productId, $feature['id'], $feature['value']]);
            }
        }

        if (
            $productInsert &&
            $active_productsInsert &&
            $storageInsert &&
            $product_categoryInsert
        ) {
            return $productId;
        }

        return 0;
    }

    /*public static function update($id, $options)
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
    }*/

    /*public static function delete($id)
    {
        $db = Db::getConnection();

        $sql = 'DELETE FROM products WHERE id = :id';

        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        return $result->execute();
    }*/

}
