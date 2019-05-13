<?php
function include_template($name, array $data = []) {
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
}

function format_cost($num) {
    $ceil_num = ceil($num);

    if ($ceil_num < 1000) {
        $format_num = $ceil_num;
    }
    else  {
        $format_num = number_format($ceil_num, 0, '', ' ');
    }

    $result = $format_num . ' ' . '₽';

    return $result;
}

function get_mysql_result($link, $sql) {
    $result = mysqli_query($link, $sql);
    if (!$result) {
        $error = mysqli_error($link);
        print ("Ошибка запроса: " . $error);
        exit();
    }
    else {
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}