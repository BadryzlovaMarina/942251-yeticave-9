<?php
require_once('functions.php');
require_once('init.php');

session_start();

$sql_category = "SELECT id, name, symbol_code FROM category";
$category = get_mysql_result($link, $sql_category);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $required = ['name', 'email', 'password', 'contact'];
    $errors = [];
    
    foreach ($required as $key) {
        if (empty($_POST[$key])) {
            $errors[$key] = 'Поле не заполнено';
        }
        elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Некорректный email';
        }
    }
    
    $email = mysqli_real_escape_string($link, $_POST['email']);
    $sql = "SELECT id FROM user WHERE email = '$email'";
    $res = mysqli_query($link, $sql);

    if (mysqli_num_rows($res) > 0) {
        $errors['email'] = 'Пользователь с этим email уже зарегистрирован';
    }
    
    if (count($errors)) {
        $page_content = include_template('sign-up.php', [
            'category' => $category,
            'errors' => $errors,
            'post' => $_POST
        ]);
    }
        
    else {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $data = [$_POST['name'], $_POST['email'], $password, $_POST['contact']];
        $sql = 'INSERT INTO user (name, email, password, contact) VALUES (?,?,?,?)';
        $stmt = db_get_prepare_stmt($link, $sql, $data);
        $res = mysqli_stmt_execute($stmt);
        if ($res) {
            $lot_id = mysqli_insert_id($link);
            header('Location: /login.php');
        }
        else {
            http_response_code(404);
            $page_content = include_template('404.php', []);
        }
    }
}
else{
	$page_content = include_template('sign-up.php', [
        'category' => $category
    ]);
}

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'Регистрация',
    'category' => $category
]);

print($layout_content);