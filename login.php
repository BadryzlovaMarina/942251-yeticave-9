<?php
require_once('functions.php');
require_once('init.php');

session_start();

$sql_category = "SELECT id, name, symbol_code FROM category";
$category = get_mysql_result($link, $sql_category);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $required = ['email', 'password'];
    $errors = [];
    
    foreach ($required as $key) {
        if (empty($_POST[$key])) {
            $errors[$key] = 'Поле не заполнено';
        }  
    }
    
    $email = mysqli_real_escape_string($link, $_POST['email']);
    $sql = "SELECT * FROM user WHERE email = '$email'";
    $res = mysqli_query($link, $sql);

    $user = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;
    
    
    if (!count($errors) and $user) {
        if (password_verify($_POST['password'], $user['password'])) {
            $_SESSION['user'] = $user;
        }
        else {
            $errors['password'] = 'Вы ввели неверный пароль';
        }
    }
    
    if (!empty($_POST['email']) and !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) and empty($_POST['password'])) {
        $errors['email'] = 'Такой пользователь не найден';
    }
    
    if (count($errors)) {
        $page_content = include_template('login.php', [
            'errors' => $errors,
            'post' => $_POST
        ]);
    }
    else {
        header('Location: /index.php');
        exit();
    }
}
else {
    if (isset($_SESSION['user'])) {
            header('Location: /index.php');
    }
    else {
        $page_content = include_template('login.php', []);
    }
}

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'Вход на сайт',
    'category' => $category
]);

print($layout_content);