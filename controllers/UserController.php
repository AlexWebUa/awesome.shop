<?php


class UserController
{

    /**
     * Get values from form, checks them and register user if no errors
     * @return bool
     */
    public function actionRegister()
    {
        $name = '';
        $email = '';
        $password = '';
        $result = false;

        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            $errors = $this->checkData($name, $email, $password);

            if ($errors == false) {
                $result = User::register($name, $email, $password);
            }

        }

        require_once(ROOT . '/views/user/register.php');

        return true;
    }

    /**
     * Checks validity of form
     * @param $name
     * @param $email
     * @param $password
     * @return array|bool
     */
    private function checkData($name, $email, $password)
    {
        $errors = false;

        if (!User::checkName($name)) {
            $errors[] = 'Имя не должно быть короче 4-х символов';
        }

        if (!User::checkEmail($email)) {
            $errors[] = 'Неправильный email';
        }

        if (!User::checkPassword($password)) {
            $errors[] = 'Пароль не должен быть короче 6-ти символов';
        }

        if (User::checkEmailExists($email)) {
            $errors[] = 'Такой email уже используется';
        }

        return $errors;
    }

    /**
     * Checks validity of login form and redirects to cabinet if it's correct
     * @return bool
     */
    public function actionLogin()
    {
        $email = '';
        $password = '';

        if (isset($_POST['submit'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $errors = false;

            if (!User::checkEmail($email)) {
                $errors[] = 'Неправильный email';
            }
            if (!User::checkPassword($password)) {
                $errors[] = 'Пароль не может быть короче 6-ти символов';
            }

            $userId = User::checkUserData($email, $password);

            if ($userId == false) {
                $errors[] = 'Пользователь не найден!';
            } else {
                User::auth($userId);

                header("Location: /cabinet/");
            }

        }

        require_once(ROOT . '/views/user/login.php');

        return true;
    }

    /**
     * Unset session 'user'
     */
    public function actionLogout()
    {
        unset($_SESSION["user"]);
        header("Location: /");
    }

}

// TODO: maybe split validation for each field?
