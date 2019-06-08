<?php
require_once('functions.php');
require_once('init.php');

$sql_category = "SELECT id, name, symbol_code FROM category";
$category = get_mysql_result($link, $sql_category);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $required = ['name', 'description', 'start_price', 'date_end', 'price_step', 'category_id'];
        $errors = [];

        foreach ($required as $key) {
            if (empty($_POST[$key])) {
                $errors[$key] = 'Поле не заполнено';
            }
        }
        if($_POST['category_id'] == 0) {
            $errors['category_id'] = "Поле не заполнено";
        }

        if ($_POST['start_price'] <= 0) {
            $errors['start_price'] = 'Введите число больше 0';
        }

        if (!ctype_digit($_POST['price_step']) or $_POST['price_step'] <= 0) {
            $errors['price_step'] = 'Введите целое число больше 0';
        }

        if (!is_date_valid($_POST['date_end'])) {
            $errors['date_end'] = 'Введите дату в формате «ГГГГ-ММ-ДД»';
        } else {
            $date_tomorrow = date("Y-m-d");
            $interval = date_diff(date_create($date_tomorrow), date_create($_POST['date_end']));
            if($interval->format('%R%a') < 1) {
                $errors['date_end'] = "Неверная дата";
            }
        }

        if (!empty($_FILES['image']['name'])) {
            $tmp_name = $_FILES['image']['tmp_name'];
            $path = $_FILES['image']['name'];
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $file_type = finfo_file($finfo, $tmp_name);

            if(empty($errors)) {
                if ($file_type === "image/png" or $file_type === "image/jpg" or $file_type === "image/jpeg") {
                    move_uploaded_file($tmp_name, 'uploads/' . $path);
                    $image = ('uploads/' . $path);
                } else {
                    $errors['image'] = 'Загрузите изображение в формате png, jpg или jpeg';
                }
            } else {
                $errors['image'] = 'Перезагрузите изображение';
            }
        } else {
            $errors['image'] = 'Вы не загрузили изображение';
        }

        if (count($errors)) {
            $page_content = include_template('add.php', [
                'category' => $category,
                'errors' => $errors,
                'post' => $_POST
            ]);
        }
        else {
            $data = [$_POST['name'], $_POST['description'], $image, $_POST['start_price'], $_POST['date_end'], $_POST['price_step'], $user_id, $_POST['category_id']];

            $sql = "INSERT INTO lot (name, description, image, start_price, date_end, price_step, user_id, category_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

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
    else {
        $page_content = include_template('add.php', [
            'category' => $category
        ]);
    }   

if (!isset($_SESSION['user'])) {
    http_response_code(403);
    $page_content = include_template('403.php', []);
}    

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'Добавление лота',
    'category' => $category,
    'user_name' => $user_name
]);

print($layout_content);
