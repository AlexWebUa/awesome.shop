<?php

class CabinetController
{
    public function actionIndex()
    {
        $userId = User::checkLogged();

        $user = User::get($userId);

        require_once(ROOT . '/views/cabinet/index.php');

        return true;
    }
}
