-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Янв 28 2020 г., 12:09
-- Версия сервера: 10.3.13-MariaDB-log
-- Версия PHP: 7.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `awesome_shop`
--

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `code` int(11) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `brand` varchar(255) CHARACTER SET utf8 NOT NULL,
  `image` varchar(255) CHARACTER SET utf8 NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `is_available` int(1) NOT NULL DEFAULT 1,
  `is_new` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `name`, `code`, `price`, `brand`, `image`, `description`, `is_available`, `is_new`) VALUES
(1, 'First item', 167492, '1499.99', 'Lenovo', '218344459.jpg', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid amet blanditiis consequatur cum deleniti dolores eius eligendi enim eos esse et eveniet exercitationem expedita explicabo facere hic in incidunt labore, maiores, nemo nisi odio odit omnis provident quas repudiandae sint sit totam, unde vel. Aliquid et, quos. Earum quibusdam, ratione.', 1, 1),
(2, 'Levi\'s mile', 8961, '399.99', 'Levi Strauss & Co.', '2189021.jpg', 'Джинсы из коллекции Levi\'s типа super skinny с завышенной талией. Модель выполнена из стираного денима.\r\n\r\nСогласно политике охраны товарных знаков примерно 10% ассортимента бренда Levi\'s имеют \"пустой ярлык\" (красного цвета без логотипа бренда, исключительно с международным знаком торговой марки). \"Пустой ярлык\" - это зарегистрированный товарный знак бренда Levi\'s и модель, имеющая данный ярлык, является полноценным оригинальным продуктом. В случаях неуверенности, просим связаться с нашим call-centre.\r\n\r\n- Крой super skinny.\r\n- Прорезные карманы.\r\n- Завышенная талия.\r\n- Застегивается на пуговицу и молнию.\r\n- Деним с декоративными потертостями.\r\n- Ширина по поясу: 34 см.\r\n- Полуобхват бедер: 45 см.\r\n- Высота талии: 27,5 см.\r\n- Ширина штанины снизу: 12 см.\r\n- Ширина штанины сверху: 26 см.\r\n- Длина штанины: 106 см.\r\n- Параметры указаны для размера: 27/30.\r\n\r\nКрой: скинни\r\nЦвет: синий\r\nСостав:\r\n97% Хлопок, 3% Эластан', 1, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `is_admin`) VALUES
(1, 'Aleksandr', 'alexwebua1@gmail.com', '987654321', 1),
(2, 'Test', 'asdfasd@asdf.adf', '123456', 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQUE` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
