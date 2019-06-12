<?php
require_once("functions.php");
require_once("init.php");

$sql_category = "SELECT id, name, symbol_code FROM category";
$category = get_mysql_result($link, $sql_category);

$lots = [];

mysqli_query($link, "CREATE FULLTEXT INDEX lot_search ON lot(name, description)");
    
$search = $_GET['search'] ?? '';

if ($search) {

    $cur_page = $_GET['page'] ?? 1;
    $page_items = 9;

    $result = mysqli_query($link, "SELECT COUNT(*) as cnt FROM lot");
    $items_count = mysqli_fetch_assoc($result)["cnt"];
    $pages_count = ceil($items_count / $page_items);
    $offset = ($cur_page - 1) * $page_items;
    $pages = range(1, $pages_count);
    
    $sql_search = "SELECT l.id as lot_id, l.name as name, description, start_price, price_step, image, c.name as category, MAX(b.bet_price) as bet_price, date_end FROM lot l
            JOIN category c ON l.category_id = c.id
            LEFT JOIN bet b ON b.lot_id = l.id
            WHERE MATCH(l.name, description) AGAINST(?)
            GROUP BY l.id
            ORDER BY date_create DESC LIMIT $page_items OFFSET $offset";
    $lots = get_mysql_result($link, $sql_search);
}

$page_content = include_template("search.php", [
    'category' => $category,
    'lots' => $lots,
    'pages' => $pages,
    'pages_count' => $pages_count,
    'cur_page' => $cur_page,
    'search' => $search
]);

$layout_content = include_template("layout.php", [
    'content' => $page_content,
    'category' => $category,
    'user_name' => $user_name,
    "title" => 'Поиск лота'
]);

print($layout_content);