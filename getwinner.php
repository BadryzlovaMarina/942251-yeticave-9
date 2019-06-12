<?php
require_once("functions.php");
require_once("init.php");
require_once('vendor/autoload.php');

$transport = new Swift_SmtpTransport("phpdemo.ru", 25);
$transport->setUsername("keks@phpdemo.ru");
$transport->setPassword("htmlacademy");
$mailer = new Swift_Mailer($transport);
$logger = new Swift_Plugins_Loggers_ArrayLogger();
$mailer->registerPlugin(new Swift_Plugins_LoggerPlugin($logger));
$sql = "SELECT b.user_id, u.name as name_u, u.email, l.name as name_l, l.id FROM lot l
    LEFT JOIN bet b ON l.id=b.lot_id
    JOIN user u ON b.user_id=u.id
    WHERE l.date_end <= now() and l.winner_id is null
    ORDER BY b.bet_date DESC LIMIT 1";
$result = mysqli_query($link, $sql);
$winner = mysqli_fetch_assoc($result);

if ($winner) {
    $sql = 'UPDATE lot SET winner_id = (?) WHERE id = ' . $winner['id'];
    $stmt = db_get_prepare_stmt($link, $sql, [$winner['user_id']]);
    $res = mysqli_stmt_execute($stmt);
    if ($res) {
        $lot_id = mysqli_insert_id($link);
    }
    $message = new Swift_Message();
    $message->setSubject("Ваша ставка победила");
    $message->setFrom(['keks@phpdemo.ru' => 'yeticave']);
    $message->setTo($winner['email']);
    $msg_content = include_template('email.php', ['winner' => $winner]);
    $message->setBody($msg_content, 'text/html');
    $result = $mailer->send($message);
    if ($result) {
        print("Сообщение успешно отправлено");
    } else {
        print("Не удалось отправить сообщение: " . $logger->dump());
    }
}