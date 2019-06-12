<?php
require_once("functions.php");
require_once("init.php");

$sql_category = "SELECT id, name, symbol_code FROM category";
$category = get_mysql_result($link, $sql_category);

$lots = [];
$pages = 1;
$pages_count = 1;
$cur_page = 1;

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

    $sql_search = "SELECT l.name name, l.id, l.start_price, l.image, c.name as category, date_end FROM lot l
            JOIN category c on l.category_id=c.id
            WHERE MATCH(l.name, description) AGAINST('$search' IN BOOLEAN MODE)
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