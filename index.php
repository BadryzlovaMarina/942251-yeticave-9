<?php
require_once('functions.php');
require_once('init.php');

date_default_timezone_set("Europe/Moscow");

$dt_end = date_create("tomorrow");
$dt_now = date_create("now");
$dt_diff = date_diff($dt_end, $dt_now);
$time_count = date_interval_format($dt_diff, "%H:%I");

if (!$link) {
    $error = mysqli_connect_error();
    print("Ошибка: Невозможно подключиться к MySQL " . $error);
}
else {
    $sql = 'SELECT id, name, symbol_code FROM category';
    $result = mysqli_query($link, $sql);
    
    if ($result) {
        $category = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    else {
        $error = mysqli_error($link);
        print ("Ошибка запроса: " . $error);
    }
    
    $sql = "SELECT l.name title, image, start_price, c.name category FROM lot l "
        . "JOIN category c on l.category_id = c.id "
        . "ORDER BY date_create DESC LIMIT 6";

    if ($res = mysqli_query($link, $sql)) {
        $item_list = mysqli_fetch_all($res, MYSQLI_ASSOC);
    }
    else {
        $error = mysqli_error($link);
        print ("Ошибка запроса: " . $error);
    }
}

$page_content = include_template('index.php', [
    'item_list' => $item_list,
    'category' => $category,
    'time_count' => $time_count
]);

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'user_name' => $user_name,
    'is_auth' => $is_auth,
    'title' => 'Главная',
    'category' => $category
]);

print($layout_content);