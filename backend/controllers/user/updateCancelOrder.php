<?php
require_once "../../database/dbConnection.php";
require_once "../../utils/logger.php";

header("Access-Control-Allow-Origin: http://localhost:3000");

$object = json_decode($_POST['updateCancelOrder'], true);
cancelOrderByUser($object);
//$object = json_encode(['ID_Order' => 73]);
function cancelOrderByUser($object){
    $orderID = $object['ID_Order'];

    $query = "UPDATE orders SET Status = 'Отменена пользователем' 
                WHERE ID = $orderID AND Status = 'Ожидание посадки'";
    $result = mysqli_query($dbLink, $query) or die ("Select error ".mysqli_error($dbLink));

    if($result){
        $query = "DELETE FROM orders_passengerseats WHERE ID_Order = $orderID";
        $result = mysqli_query($dbLink, $query) or die ("Select error ".mysqli_error($dbLink));
        if($result){
            LogsWriteMessage("Trip is cancelled");
        }else{
            LogsWriteMessage("db error");
        }
    }else{
        LogsWriteMessage("Error database");
    }
}
