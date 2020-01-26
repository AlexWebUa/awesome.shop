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

}
