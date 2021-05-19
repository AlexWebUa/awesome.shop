<?php


class Tag
{
    public static function get()
    {
        $db = Db::getConnection();

        $result = $db->query('SELECT * FROM tag');
        $result->setFetchMode(PDO::FETCH_ASSOC);

        return $result->fetchAll();
    }

    public static function add($tags)
    {
        $db = Db::getConnection();

        try {
            $result = $db->prepare('INSERT INTO tag (title) VALUES (:title)');
            foreach ($tags as $tag) {
                $result->bindParam(':title', $tag);
                $result->execute();
            }
        } catch (Exception $e) {
            return $e;
        }

        return $result;
    }

    public static function getByTitlesArray($titles) {
        $db = Db::getConnection();

        $sql = 'SELECT id FROM tag WHERE title IN (\''. implode("', '", $titles) .'\')';
        $result = $db->query($sql);

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getByTitle($title)
    {
        $db = Db::getConnection();

        $result = $db->query('SELECT * FROM tag WHERE title = ' . $title);

        return $result->fetchColumn();
    }
}