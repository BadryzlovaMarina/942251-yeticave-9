<?php
require_once('functions.php');
require_once('init.php');

if (!$link) {
    $error = mysqli_connect_error();
    exit("Ошибка: Невозможно подключиться к MySQL " . $error);
}
else {
    $sql_category = "SELECT id, name, symbol_code FROM category";
    $category = get_mysql_result($link, $sql_category);
    
    $sql_lot = "SELECT l.id, l.name title, image, start_price, c.name category, l.date_end as date_end FROM lot l 
                JOIN category c on l.category_id = c.id
                LEFT JOIN bet b ON b.lot_id = l.id
                GROUP BY l.id ORDER BY date_create DESC LIMIT 6";
    $item_list = get_mysql_result($link, $sql_lot);
}

$page_content = include_template('index.php', [
    'item_list' => $item_list,
    'category' => $category
]);

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'Главная',
    'category' => $category,
    'user_name' => $user_name
]);

print($layout_content);