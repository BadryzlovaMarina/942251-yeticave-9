<?php
require_once 'helpers.php';
require_once 'config/db.php';
date_default_timezone_set("Europe/Moscow");

$is_auth = rand(0, 1);
$user_name = 'Marina';

$link = mysqli_connect($db['host'], $db['user'], $db['password'], $db['database']);

mysqli_set_charset($link, "utf8");