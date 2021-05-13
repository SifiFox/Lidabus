<?php
//isUserActive(66);
function isUserActive($userID){
    include "../../database/dbConnection.php";

    $isUserActive = false;

    $query = "SELECT Status AS status FROM users WHERE ID = $userID";
    $result = mysqli_query($dbLink, $query) or die ("Select error ".mysqli_error($dbLink));

    if($result){
        $status = '';

        while($row = $result -> fetch_object()){
            $status = $row -> status;
        }

        if($status == 'Active'){
            $isUserActive = true;
            LogsWriteMessage("User is active");
            return $isUserActive;
        }else{
            $isUserActive = false;
            LogsWriteMessage("User is blocked");
            return $isUserActive;
        }
    }else{
        $isUserActive = false;
        LogsWriteMessage("Database error");
        return $isUserActive;
    }
}
$object = json_encode(['ID_Order' => 73]);
//cancelOrderByUser($object);
function cancelOrderByUser($object){
    include "../../database/dbConnection.php";
    include "../../utils/logger.php";

    $object = json_decode($object, true);
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