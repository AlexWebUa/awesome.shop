<?php


class UserController
{

    public function actionRegister()
    {
        $result = false;

        if (isset($_POST['submit'])) {
            $options = [
                'firstName' => $_POST['firstName'],
                'lastName' => $_POST['lastName'],
                'email' => $_POST['email'],
                'passwordHash' => md5($_POST['password'])
            ];

            $errors = $this->checkData($options['email'], $_POST['password']);

            if ($errors == false) {
                $result = User::register($options);

                if ($result) {
                    User::auth($result);
                }
            }
        }

        require_once(ROOT . '/views/user/register.php');

        return true;
    }

    private function checkData($email, $password)
    {
        $errors = false;

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

    public function actionLogin()
    {
        if (isset($_POST['submit'])) {
            $options = [
                'email' => $_POST['email'],
                'passwordHash' => md5($_POST['password'])
            ];
            $errors = false;

            if (!User::checkEmail($_POST['email'])) {
                $errors[] = 'Неправильный email';
            }

            if (!User::checkPassword($_POST['password'])) {
                $errors[] = 'Пароль не может быть короче 6-ти символов';
            }

            $userId = User::checkUserData($options);

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

    public function actionLogout()
    {
        unset($_SESSION["userId"]);
        unset($_SESSION["userRole"]);
        unset($_SESSION["userEmail"]);
        header("Location: /");
    }

}
