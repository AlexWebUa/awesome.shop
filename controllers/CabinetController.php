<?php

class CabinetController
{

    /**
     * Checks if user logged and shows cabinet
     * @return bool
     */
    public function actionIndex()
    {
        $userId = User::checkLogged();

        $user = User::get($userId);

        require_once(ROOT . '/views/cabinet/index.php');

        return true;
    }
}
