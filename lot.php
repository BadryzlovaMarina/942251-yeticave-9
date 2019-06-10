<?php
require_once('functions.php');
require_once('init.php');

$sql_category = "SELECT name, symbol_code FROM category";
$category = get_mysql_result($link, $sql_category);

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    $sql_bets = "SELECT u.name, bet_price, bet_date FROM bet b
            LEFT JOIN user u on b.user_id=u.id
            WHERE lot_id = $id
            ORDER BY bet_date DESC LIMIT 10";
    $last_bets = get_mysql_result($link, $sql_bets);
    
    $sql_count = "SELECT count(*) as count FROM bet where lot_id = $id";
    $result = mysqli_query($link, $sql_count);
    $count_bets = mysqli_fetch_assoc($result)['count'];
    
    $sql_lot = "SELECT l.id, l.name as title, description, start_price, image, l.date_end as date_end, price_step, (start_price + price_step)as min_price, c.name as category FROM lot l
    JOIN category c ON l.category_id = c.id
    LEFT JOIN bet b ON b.lot_id=l.id
    WHERE l.id = $id ";
    $lot_list = get_mysql_result($link, $sql_lot);
    
    if(empty($lot_list)) {
        http_response_code(404);
        $page_content = include_template('404.php', []);
    }
    else {
        $page_content = include_template('lot.php', [
            'lot_list' => $lot_list,
            'category' => $category,
            'last_bets' => $last_bets,
            'count_bets' => $count_bets
        ]);
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $required = ['bet_price'];
        $errors = [];

        foreach ($required as $key) {
            if (empty($_POST[$key])) {
                $errors[$key] = 'Введите наименование лота';
            }
        }

        if (count($errors)) {
            $page_content = include_template('lot.php', [
                'category' => $category,
                'errors' => $errors,
                'post' => $_POST,
                'lot_list' => $lot_list,
                'last_bets' => $last_bets,
                'count_bets' => $count_bets
            ]);
        }
        else {
            $data = [$_POST['bet_price'], $user_id, $id];

            $sql = "INSERT INTO bet (bet_price, user_id, lot_id) VALUES (?, ?, ?)";

            $stmt = db_get_prepare_stmt($link, $sql, $data);
            $res = mysqli_stmt_execute($stmt);

            if ($res) {
                header("Refresh: 0");
                exit();
            }
        }   
    }   
}
else {
    http_response_code(404);
    $page_content = include_template('404.php', []);
} 

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'Страница лота',
    'category' => $category,
    'user_name' => $user_name
]);

print($layout_content);