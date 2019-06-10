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

function is_date_valid($date) : bool {
    $format_to_check = 'Y-m-d';
    $dateTimeObj = date_create_from_format($format_to_check, $date);

    return $dateTimeObj !== false && array_sum(date_get_last_errors()) === 0;
}

function db_get_prepare_stmt($link, $sql, $data = []) {
    $stmt = mysqli_prepare($link, $sql);

    if ($stmt === false) {
        $errorMsg = 'Не удалось инициализировать подготовленное выражение: ' . mysqli_error($link);
        die($errorMsg);
    }

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = 's';

            if (is_int($value)) {
                $type = 'i';
            }
            else if (is_string($value)) {
                $type = 's';
            }
            else if (is_double($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);

        if (mysqli_errno($link) > 0) {
            $errorMsg = 'Не удалось связать подготовленное выражение с параметрами: ' . mysqli_error($link);
            die($errorMsg);
        }
    }

    return $stmt;
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

function time_bets($date) {
    $date = strtotime($date);
    $dt_diff = time() - $date;
    $hr = floor($dt_diff / 3600);
    $min= floor(($dt_diff % 3600) / 60);
    if ($dt_diff < 60) {
        $date = "Только что";
    } elseif ($dt_diff < 3600 && $dt_diff >= 60) {
        $date = $min . " " . get_noun_plural_form($min, "минуту", "минуты", "минут") . " назад";
    } elseif ($dt_diff < 7200 && $dt_diff >= 3600) {
        $date = "Час назад";
    } elseif ($dt_diff < 86400 && $dt_diff >= 7200) {
        $date = $hr . " " . get_noun_plural_form($hr, "час", "часа", "часов") . " назад";
    } else {
        $date = date("d.m.y", $date) . " в " . date("H:i", $date);
    }
    return $date;
}

function format_time(string $time) {
    $dt_end = strtotime($time);
    $dt_diff = $dt_end - time();
    $sec = ($dt_diff % 60);
    $hr = floor($dt_diff / 3600);
    $min = floor(($dt_diff % 3600) / 60);
    if ($sec < 10) {
        $sec = '0' . $sec;
    }
    if ($hr < 10) {
        $hr = '0' . $hr;
    }
     if ($min < 10) {
        $min = '0' . $min;
    }
    $date_end = $hr . ":" . $min . ":" . $sec;
    
    return $date_end; 
}