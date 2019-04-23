<?php
require_once('functions.php');
require_once('data.php');

date_default_timezone_set("Europe/Moscow");

$dt_end = date_create("tomorrow");
$dt_now = date_create("now");
$dt_diff = date_diff($dt_end, $dt_now);
$time_count = date_interval_format($dt_diff, "%H:%I");

$page_content = include_template('index.php', [
    'item_list' => $item_list,
    'categories' => $categories,
    'time_count' => $time_count
]);

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'user_name' => $user_name,
    'is_auth' => $is_auth,
    'title' => 'Главная',
    'categories' => $categories
]);

print($layout_content);
