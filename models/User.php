<?php


class User
{
    /**
     * Adds user into db
     * @param $name
     * @param $email
     * @param $password
     * @return bool
     */
    public static function register($options)
    {

        $db = Db::getConnection();
        $userId = intval($db->query('SELECT MAX(id) FROM user')->fetchColumn()) + 1;

        $data = [
            'firstName' => $options['firstName'],
            'lastName' => $options['lastName'],
            'email' => $options['email'],
            'passwordHash' => $options['passwordHash']
        ];
        $sql = 'INSERT INTO user (firstName, lastName, email, passwordHash, roleId) '
            . 'VALUES (:firstName, :lastName, :email, :passwordHash, 1)';
        $result = $db->prepare($sql);
        return $result->execute($data) ? $userId : false;
    }

    /**
     * Check if password has >6 chars
     * @param $password
     * @return bool
     */
    public static function checkPassword($password)
    {
        if (strlen($password) >= 6) {
            return true;
        }
        return false;
    }

    /**
     * Check validity of email
     * @param $email
     * @return bool
     */
    public static function checkEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }

    /**
     * Check if email already in db
     * @param $email
     * @return bool
     */
    public static function checkEmailExists($email)
    {

        $db = Db::getConnection();

        $sql = 'SELECT COUNT(*) FROM user WHERE email = "' . $email . '"';

        $result = $db->prepare($sql);
        $result->execute();

        if ($result->fetchColumn())
            return true;
        return false;
    }

    /**
     * Checks if user with specified email and password exists in db
     * @param $email
     * @param $password
     * @return bool
     */
    public static function checkUserData($options)
    {
        $db = Db::getConnection();

        $sql = 'SELECT * FROM user WHERE email = :email AND passwordHash = :passwordHash';

        $result = $db->prepare($sql);
        $result->execute($options);
        $user = $result->fetch();
        if ($user) {
            return $user['id'];
        }

        return false;
    }

    /**
     * Add user id in session
     * @param $userId
     */
    public static function auth($userId)
    {
        $_SESSION['userId'] = $userId;
        $_SESSION['userRole'] = self::getRole($userId);
        $_SESSION['userEmail'] = self::getEmail($userId);
    }

    public static function getRole($id)
    {
        $db = Db::getConnection();
        $sql = $db->query('SELECT roleId FROM user WHERE id = ' . $id);
        return $sql->fetchColumn();
    }

    public static function getEmail($id)
    {
        $db = Db::getConnection();
        $sql = $db->query('SELECT email FROM user WHERE id = ' . $id);
        return $sql->fetchColumn();
    }

    /**
     * Checks if user id is in session
     * @return mixed
     */
    public static function checkLogged()
    {
        if (isset($_SESSION['userId'])) {
            return $_SESSION['userId'];
        }

        header("Location: /user/login");

        return true;
    }

    /**
     * Returns user by id
     * @param $id
     * @return mixed
     */
    public static function get($id)
    {
        $db = Db::getConnection();
        $sql = 'SELECT user.*, role.title AS role FROM user LEFT JOIN role ON role.id = user.roleId WHERE user.id = :id';
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();

        return $result->fetch();
    }

    public static function getRolePermissions($roleId)
    {
        $db = Db::getConnection();
        $sql = 'SELECT permission.title, role_permission.* FROM role_permission LEFT JOIN permission ON permission.id = role_permission.permissionId WHERE role_permission.roleId = :roleId';
        $result = $db->prepare($sql);
        $result->bindParam(':roleId', $roleId, PDO::PARAM_INT);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();

        return $result->fetchAll();
    }

    /**
     * Checks if user id is not in session
     * @return bool
     */
    public static function isGuest()
    {
        if (isset($_SESSION['userId'])) {
            return false;
        }
        return true;
    }

}
