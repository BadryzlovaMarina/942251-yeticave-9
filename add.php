<?php
require_once('functions.php');
require_once('init.php');

$sql_category = "SELECT id, name, symbol_code FROM category";
$category = get_mysql_result($link, $sql_category);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $image = $_POST['image'];
    $start_price = $_POST['start_price'];
    $date_end = $_POST['date_end'];
    $price_step = $_POST['price_step'];
    $category_id = $_POST['category_id'];

    $required = ['name', 'description', 'start_price', 'date_end', 'price_step', 'category_id'];
    $errors = [];
    
    foreach ($required as $key) {
        if (empty($lot[$key])) {
            $errors[$key] = 'Поле не заполнено';
        }
    }
    
    if (!empty($_FILES['image']['name'])) {
        $tmp_name = $_FILES['image']['tmp_name'];
        $path = $_FILES['image']['name'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $tmp_name);
        if ($file_type === "image/png" or $file_type === "image/jpg" or $file_type === "image/jpeg") {
            move_uploaded_file($tmp_name, 'uploads/' . $path);
            $image = ('uploads/' . $path);
        } else {
            $errors['image'] = 'Загрузите изображение в формате png, jpg или jpeg';
        }
    } else {
        $errors['image'] = 'Вы не загрузили изображение';
    }
    
    if ($start_price <= 0) {
        $errors['start_price'] = 'Введите число больше ноля';
    }
    
    if ($price_step <= 0 or intval($price_step) !== $price_step) {
        $errors['price_step'] = 'Введите целое число больше ноля';
    }
    
    if (count($errors)) {
        $page_content = include_template('add.php', [
        'category' => $category,
        'errors' => $errors
        ]);
    }
    
    else {
        $data = [$name, $description, $image, $start_price, $date_end, $price_step, $category_id];

        $sql = 'INSERT INTO lot (name, description, image, start_price, date_end, price_step, user_id, category_id) VALUES (?,?,?,?,?,?,1,?)';

        $stmt = db_get_prepare_stmt($link, $sql, $data);
        $res = mysqli_stmt_execute($stmt);

        if ($res) {
            $lot_id = mysqli_insert_id($link);
            header("Location: lot.php?id=" . $lot_id);
        }
        else {
            http_response_code(404);
            $page_content = include_template('404.php', []);
        }
    }
}
else{
	$page_content = include_template('add.php', [
        'category' => $category
    ]);
}

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'Добавление лота',
    'category' => $category,
    'user_name' => $user_name,
    'is_auth' => $is_auth
]);

print($layout_content);