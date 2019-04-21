<?php
require_once('functions.php');
require_once('data.php');

$page_content = include_template('index.php', [
    'item_list' => $item_list,
    'categories' => $categories
]);

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'user_name' => $user_name,
    'is_auth' => $is_auth,
    'title' => 'Главная',
    'categories' => $categories
]);

print($layout_content);
