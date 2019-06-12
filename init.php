<?php
require_once 'helpers.php';
require_once 'config/db.php';
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
date_default_timezone_set("Asia/Novosibirsk");

$link = mysqli_connect($db['host'], $db['user'], $db['password'], $db['database']);

mysqli_set_charset($link, "utf8");

session_start();

if (isset($_SESSION['user'])) {
    $user_id = $_SESSION['user']['id'];
    $user_name = $_SESSION['user']['name'];
}