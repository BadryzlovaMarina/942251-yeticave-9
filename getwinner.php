<?php
require_once("functions.php");
require_once("init.php");

$sql = "SELECT b.user_id, u.name name_u, u.email, l.name name_l, l.id FROM lot l
    left join bet b on l.id=b.lot_id
    join user u on b.user_id=u.id
    where l.date_end <= now() and l.winner_id is null
    order by b.bet_date desc limit 1";
$winner = get_mysql_result($link, $sql);
if ($winner) {
    $sql = 'update lot set winner_id = (?) where id = ' . $winner[0]['id'];
    $stmt = db_get_prepare_stmt($link, $sql, [$winner[0]['user_id']]);
    $res = mysqli_stmt_execute($stmt);
    if ($res) {
        $lot_id = mysqli_insert_id($link);
    }
    if ($result) {
        print("Сообщение успешно отправлено");
    } else {
        print("Не удалось отправить сообщение: ");
    }
}