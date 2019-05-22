<?php
require_once('functions.php');
require_once('init.php');

$dt_end = date_create("tomorrow");
$dt_now = date_create("now");
$dt_diff = date_diff($dt_end, $dt_now);
$time_count = date_interval_format($dt_diff, "%H:%I");

$sql_category = "SELECT name, symbol_code FROM category";
$category = get_mysql_result($link, $sql_category);

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql_lot = "SELECT l.id, l.name as title, description, start_price, image, c.name as category FROM lot l
    JOIN category c ON l.category_id = c.id
    WHERE l.id = $id ";
    $lot_list = get_mysql_result($link, $sql_lot);
    
    if(empty($lot_list)) {
        http_response_code(404);
        $page_content = include_template('404.php', []);
    }
    else {
        $page_content = include_template('lot.php', [
            'lot_list' => $lot_list,
            'time_count' => $time_count,
            'category' => $category
        ]);
    }
}

else {
    http_response_code(404);
    $page_content = include_template('404.php', []);
}

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'user_name' => $user_name,
    'is_auth' => $is_auth,
    'title' => 'Страница лота',
    'category' => $category
]);

print($layout_content);