<?php

header("Access-Control-Allow-Origin: http://localhost:3000");

$object = json_decode($_GET['getUser'], true);

if($object){
    include "../../user/get.php";
    getUserByID($object["ID"]);
}