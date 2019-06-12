<?php
require_once('functions.php');
require_once('init.php');

$sql_category = "SELECT id, name, symbol_code FROM category";
$category = get_mysql_result($link, $sql_category);

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql_user = "SELECT user_id FROM bet
    WHERE lot_id = $id
    ORDER BY bet_date DESC LIMIT 1";
    $last_user = get_mysql_result($link, $sql_user);

    $sql_bets = "SELECT u.name, bet_price, bet_date, user_id FROM bet b
            LEFT JOIN user u on b.user_id=u.id
            WHERE lot_id = $id
            ORDER BY bet_date DESC LIMIT 10";
    $last_bets = get_mysql_result($link, $sql_bets);

    $sql_count = "SELECT count(*) as count FROM bet where lot_id = $id";
    $result = mysqli_query($link, $sql_count);
    $count_bets = mysqli_fetch_assoc($result)['count'];

    $sql_lot = "SELECT l.id as id_l, l.name as title, description, start_price, image, l.user_id, l.date_end as date_end, price_step, MAX(b.bet_price), c.name as category FROM lot l
    JOIN category c ON l.category_id = c.id
    LEFT JOIN bet b ON b.lot_id = l.id
    WHERE l.id = $id
    GROUP BY l.id LIMIT 1";
    $lot = get_mysql_result($link, $sql_lot);

    if(empty($lot)) {
        http_response_code(404);
        $page_content = include_template('404.php', []);
    }
    else {
        $page_content = include_template('lot.php', [
            'lot' => $lot,
            'category' => $category,
            'last_bets' => $last_bets,
            'count_bets' => $count_bets,
            'user_id' => $user_id,
            'last_user' => $last_user
        ]);
    }

    if (($_SERVER['REQUEST_METHOD'] === 'POST')) {

        $required = ['bet_price'];
        $errors = [];
        $start_price = $lot[0]['start_price'];
        $price_step = $lot[0]['price_step'];
        $MAX_price = $lot[0]['MAX(b.bet_price)'];

        foreach ($required as $key) {
            if (empty($_POST[$key])) {
                $errors[$key] = 'Поле не заполнено';
            }
        }

        if (!empty($_POST['bet_price']) && (!ctype_digit($_POST['bet_price']) or $_POST['bet_price'] <= 0)) {
            $errors['bet_price'] = 'Введите целое число > 0';
        }

        if (empty($errors) && $_POST['bet_price'] < ($start_price + $price_step)) {
            $errors['bet_price'] = 'Указать ставку > мин. ставки';
        }

        if (empty($errors) && $_POST['bet_price'] < ($MAX_price + $price_step)) {
            $errors['bet_price'] = 'Указать ставку > мин. ставки';
        }

        if (count($errors)) {
            $page_content = include_template('lot.php', [
                'category' => $category,
                'errors' => $errors,
                'post' => $_POST,
                'lot' => $lot,
                'last_bets' => $last_bets,
                'count_bets' => $count_bets,
                'user_id' => $user_id,
                'last_user' => $last_user
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
