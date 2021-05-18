<?php
header("Access-Control-Allow-Origin: http://localhost:3000");

$object = json_decode($_GET['getUsersOrderedRoute'], true);

if($object){
    include "../order/get.php";
    getUsersOrderedRouteByRouteID($object);
}