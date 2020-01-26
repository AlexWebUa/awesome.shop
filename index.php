<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
define('ROOT', dirname(__FILE__));

require_once(ROOT . '/core/Autoload.php');


$router = new Router();
$router->run();


// TODO: products, cart, user-panel, admin-panel


/*
 * В магазине должен быть реализован следующий функционал:
 * -логин
 * -регистрация
 * -отображение товаров
 * -добавление товаров
 * -редактирования товаров
 * -удаления товаров
 * -корзина (должна отображать список заказанных товаров, их количество, стоимость и сумма итого )
 * -добавление в корзину.
 */

