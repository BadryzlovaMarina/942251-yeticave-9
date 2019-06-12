<?php
require_once('functions.php');
require_once('init.php');

$sql_category = "SELECT id, name, symbol_code FROM category";
$category = get_mysql_result($link, $sql_category);

if (isset($_SESSION['user'])) {
    $id = $user_id;
    $sql_bets = "SELECT u.contact, l.image as image, l.name as name, u.contact as contact, l.winner_id, .c.name as category, l.date_end as date_end, l.start_price as price, b.bet_date as date_create, b.bet_price as bet_price, b.lot_id as lot_id FROM bet b
    LEFT JOIN lot l ON l.id = b.lot_id
    LEFT JOIN user u ON l.winner_id = u.id
    JOIN category c ON l.category_id = c.id
    WHERE b.user_id = $id ";
    $user_bets = get_mysql_result($link, $sql_bets);

    if(empty($user_bets)) {
        http_response_code(404);
        $page_content = include_template('404.php', []);
    }
    else {
        $page_content = include_template('my-bets.php', [
            'category' => $category,
            'user_bets' => $user_bets,
            'user_id' => $user_id
        ]);
    }
}
else {
    http_response_code(404);
    $page_content = include_template('404.php', []);
} 

if (!isset($_SESSION['user'])) {
    http_response_code(403);
    $page_content = include_template('403.php', []);
}

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'Мои ставки',
    'category' => $category,
    'user_name' => $user_name
]);

print($layout_content);