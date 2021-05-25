<?php
header("Access-Control-Allow-Origin: http://localhost:3000");

$object = json_decode($_POST['updateRouteStatusToInWay'], true);

updateRouteStatusToInWay($object);

function updateRouteStatusToInWay($object){
    include "../../database/dbConnection.php";
    include "../../utils/logger.php";

    $routeID = $object['ID_Route'];
    $statusToInWay = 'В пути';

    $query = "UPDATE routes SET STATUS = '$statusToInWay'
                WHERE ID = $routeID";
    $result = mysqli_query($dbLink, $query) or die ("Select error ".mysqli_error($dbLink));

    if($result){
        LogsWriteMessage("Route status updated to: '$statusToInWay'");
    }else{
        LogsWriteMessage("database error");
    }
}