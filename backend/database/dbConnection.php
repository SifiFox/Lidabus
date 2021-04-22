<?php
    $host = '127.0.0.1';
    $database = 'busdatabase';
    $user = 'root';
    $password = '';
    $salt = md5(1231);//добавление защиты хэширования паролей

    $dbLink = mysqli_connect($host, $user, $password, $database) or die("Ошибка " . mysqli_error($link));
?>
