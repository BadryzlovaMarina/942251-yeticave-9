<?php
require_once('functions.php');
require_once('init.php');

$sql_category = "SELECT id, name, symbol_code FROM category";
$category = get_mysql_result($link, $sql_category);

$pages = 1;
$pages_count = 1;
$current_page = 1;

$lots = [];

mysqli_query($link, 'CREATE FULLTEXT INDEX lot_search ON lot(name, description)');

$category_id = $_GET['category'] ?? '';
$category_name = $_GET['name'] ?? '';
if ($category) {
    $current_page = $_GET['page'] ?? 1;
    $page_items = 9;
    $sql = 'SELECT COUNT(*) as cnt FROM lot WHERE category_id=(?)';
    $stmt = db_get_prepare_stmt($link, $sql, [$category_id]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $items_count = mysqli_fetch_assoc($result)['cnt'];
    $pages_count = ceil($items_count / $page_items);
    $offset = ($current_page - 1) * $page_items;
    $pages = range(1, $pages_count);
    $sql = "SELECT l.name title, l.id as id_l, start_price, image, MAX(b.bet_price), c.name as category, count(b.id), date_end FROM lot l
        JOIN category c ON l.category_id = c.id
        LEFT JOIN bet b ON b.lot_id = l.id 
        WHERE category_id=(?) and date_end > now() 
        GROUP BY l.id
        ORDER BY date_create DESC LIMIT $page_items OFFSET $offset";

    $stmt = db_get_prepare_stmt($link, $sql, [$category_id]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

$page_content = include_template('all-lots.php', [
    'category' => $category,
    'lots' => $lots,
    'category_id' => $category_id,
    'category_name' => $category_name,
    'pages' => $pages,
    'pages_count' => $pages_count,
    'current_page' => $current_page
]);

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'category' => $category,
    'title' => 'Все лоты',
    'user_name' => $user_name
]);

print($layout_content);