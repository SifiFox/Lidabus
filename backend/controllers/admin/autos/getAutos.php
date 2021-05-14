<?php
header("Access-Control-Allow-Origin: http://localhost:3000");

$object = json_decode($_GET['getAutos'], true);

if($object){
    include "../../auto/get.php";
    getAutos();
}