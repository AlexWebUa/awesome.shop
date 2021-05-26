<?php


class Product
{

    const SHOW_BY_DEFAULT = 8;

    public static function getLatest(int $offset = 0, int $count = self::SHOW_BY_DEFAULT)
    {
        $count = intval($count);
        $db = Db::getConnection();

        $result = $db->query('SELECT product.id, product.title, product.description, product.mainImg, discount.discount, active_products.isActive, product_price.price '
            . 'FROM product '
            . 'LEFT JOIN active_products ON product.id = active_products.productId '
            . 'LEFT JOIN discount '
            . 'ON product.id = discount.productId '
            . 'AND discount.completedBeforeDeadline = "0" '
            . 'AND CURRENT_TIMESTAMP > startDate '
            . 'AND CURRENT_TIMESTAMP < finishDate '
            . 'LEFT JOIN product_price ON product.id = product_price.productId '
            . 'ORDER BY id DESC '
            . 'LIMIT ' . $count . ' '
            . 'OFFSET ' . $offset);

        $result->setFetchMode(PDO::FETCH_ASSOC);

        return $result->fetchAll();
    }

    public static function getById(int $id)
    {
        $id = intval($id);

        if ($id) {
            $db = Db::getConnection();

            /*** Product ***/
            $product = $db->query(
                'SELECT product.*, active_products.isActive, storage.quantity, product_price.price '
                . 'FROM product '
                . 'LEFT JOIN active_products ON product.id = active_products.productId ' // isActive
                . 'LEFT JOIN storage ON product.id = storage.productId ' // quantity
                . 'LEFT JOIN product_price ON product.id = product_price.productId '
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
                'SELECT feature.*, product_feature.value '
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

    public static function getTotalNumber()
    {
        $db = Db::getConnection();

        $totalNumber = $db->query('SELECT COUNT(*) FROM product');

        return $totalNumber->fetchColumn();
    }

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
            'price' => $options['price']
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

        /*** Discount ***/
        if (!empty($options['discount'])) {
            $discountSql = 'INSERT INTO discount (productId, discount, startDate, finishDate) VALUES (' . $productId . ', :discount, :startDate, :finishDate)';
            $discountInsert = $db->prepare($discountSql);
            $discountInsert->bindParam(':discount', $options['discount']);
            $discountInsert->bindParam(':startDate', $options['startDate']);
            $discountInsert->bindParam(':finishDate', $options['finishDate']);
            $discountInsert->execute();
        }

        /*** Price ***/
        $product_priceSql = 'INSERT INTO product_price (productId, price) VALUES (' . $productId . ', ' . $options['price'] . ')';
        $product_priceInsert = $db->prepare($product_priceSql)->execute();

        if (
            $productInsert &&
            $active_productsInsert &&
            $storageInsert &&
            $product_categoryInsert &&
            $product_priceInsert
        ) {
            return $productId;
        }

        return 0;
    }

    public static function addFeatures($id, $features)
    {
        $db = Db::getConnection();

        $sql = $db->prepare('INSERT INTO product_feature (productId, featureId, value) VALUES (' . $id . ', :featureId, :value)');

        foreach ($features as $feature) {
            $sql->bindParam(':featureId', $feature['featureId']);
            $sql->bindParam(':value', $feature['value']);
            $sql->execute();
        }
    }

    public static function updateFeatures($id, $features)
    {
        $db = Db::getConnection();

        $sql = $db->prepare('UPDATE product_feature SET value = :value WHERE productId = ' . $id . ' AND featureId = :featureId');

        foreach ($features as $feature) {
            $sql->bindParam(':featureId', $feature['featureId']);
            $sql->bindParam(':value', $feature['value']);
            $sql->execute();
        }
    }

    public static function update($id, $options)
    {
        $db = Db::getConnection();

        /*** Product ***/
        $productData = [
            'id' => $id,
            'title' => $options['title'],
            'description' => $options['description'],
            'metatitle' => $options['metatitle'],
            'mainImg' => $options['mainImg']
        ];
        $productSql = 'UPDATE product SET '
            . 'title = :title, '
            . 'description = :description, '
            . 'metatitle = :metatitle, '
            . 'mainImg = :mainImg '
            . 'WHERE id = :id';
        $productInsert = $db->prepare($productSql)->execute($productData);

        /*** Active products ***/
        $active_productsSql = 'UPDATE active_products SET isActive = ' . $options['isActive'] . ' WHERE productId = ' . $id;
        $active_productsInsert = $db->prepare($active_productsSql)->execute();

        /*** Storage ***/
        $storageSql = 'UPDATE storage SET quantity = ' . $options['quantity'] . ' WHERE productId = ' . $id;
        $storageInsert = $db->prepare($storageSql)->execute();

        /*** Images ***/
        if (!empty($options['images'])) {
            $sql = 'DELETE FROM images WHERE productId = ' . $id;
            $db->prepare($sql)->execute();

            $imagesSql = $db->prepare('INSERT INTO images (productId, url) VALUES (?,?)');
            foreach ($options['images'] as $image) {
                $imagesSql->execute([$id, $image['url']]);
            }
        }

        /*** Tags ***/
        /*if (!empty($options['tags'])) {
            $product_tagSql = $db->prepare('INSERT INTO product_tag (productId, tagId) VALUES (?,?)');
            foreach ($options['tags'] as $tag) {
                $product_tagSql->execute([$productId, $tag['id']]);
            }
        }*/

        /*** Category ***/
        $product_categorySql = 'UPDATE product_category SET categoryId = ' . $options['categoryId'] . ' WHERE productId = ' . $id;
        $product_categoryInsert = $db->prepare($product_categorySql)->execute();

        /*** Discount ***/
        /*if (!empty($options['discount'])) {
            $discountSql = 'INSERT INTO discount (productId, discount, startDate, finishDate) VALUES (' . $productId . ', :discount, :startDate, :finishDate)';
            $discountInsert = $db->prepare($discountSql);
            $discountInsert->bindParam(':discount', $options['discount']);
            $discountInsert->bindParam(':startDate', $options['startDate']);
            $discountInsert->bindParam(':finishDate', $options['finishDate']);
            $discountInsert->execute();
        }*/

        /*** Price ***/
        $product_priceSql = 'UPDATE product_price SET price = ' . $options['price'] . ' WHERE productId = ' . $id;
        $product_priceInsert = $db->prepare($product_priceSql)->execute();

        if (
            $productInsert &&
            $active_productsInsert &&
            $storageInsert &&
            $product_categoryInsert &&
            $product_priceInsert
        ) {
            return 1;
        }

        return 0;
    }

    public static function getBreadcrumbs($data)
    {
        if (!isset($data['parent'])) return '<a href="/category/' . $data['id'] . '">' . $data['title'] . '</a>';

        $result = self::getBreadcrumbs($data['parent']) . ' > <a href="/category/' . $data['id'] . '">' . $data['title'] . '</a>';
        return $result;
    }

    public static function delete($id)
    {
        $db = Db::getConnection();

        /*** Active products ***/
        $sql = 'DELETE FROM active_products WHERE productId = ' . $id;
        $result[] = $db->prepare($sql)->execute();

        /*** Storage ***/
        $sql = 'DELETE FROM storage WHERE productId = ' . $id;
        $result[] = $db->prepare($sql)->execute();

        /*** Images ***/
        $sql = 'DELETE FROM images WHERE productId = ' . $id;
        $result[] = $db->prepare($sql)->execute();

        /*** Product category ***/
        $sql = 'DELETE FROM product_category WHERE productId = ' . $id;
        $result[] = $db->prepare($sql)->execute();

        /*** Product feature ***/
        $sql = 'DELETE FROM product_feature WHERE productId = ' . $id;
        $result[] = $db->prepare($sql)->execute();

        /*** Product tag ***/
        $sql = 'DELETE FROM product_tag WHERE productId = ' . $id;
        $result[] = $db->prepare($sql)->execute();

        /*** Price ***/
        $sql = 'DELETE FROM product_price WHERE productId = ' . $id;
        $result[] = $db->prepare($sql)->execute();

        /*** Product ***/
        $sql = 'DELETE FROM product WHERE id = ' . $id;
        $result[] = $db->prepare($sql)->execute();

        return $result;
    }

}
