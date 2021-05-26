<?php

header("Access-Control-Allow-Origin: http://localhost:3000");

$object = json_decode($_GET['getDestination'], true);

include ("../driver/getDriver.php");
getDriversByDayOfWeek();