<?php
    $host = '127.0.0.1';
    $database = 'lidabus';
    $user = 'root';
    $password = '';
    $salt = md5(1231);//так называемся соль для добавления защиты хэширования паролей

    $dbLink = mysqli_connect($host, $user, $password, $database) or die("Ошибка " . mysqli_error($link));
?>