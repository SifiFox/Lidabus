<?php

//$object = json_encode(['ID_User' => 54, 'ID_Route' => 2, 'OrderStatus' => 'Прибыл']);
header("Access-Control-Allow-Origin: http://localhost:3000");

$object = json_decode($_POST['updateStatusOrder'], true);

setStatusToOrder($object);

function setStatusToOrder($object){
    include "../../database/dbConnection.php";
    include "../../utils/logger.php";

    $userID = $object['ID_User'];
    $routeID = $object['ID_Route'];
    $orderStatus = $object['OrderStatus'];

    if(isUserDriver($userID)){
        if(isDriverHasOrderInRoute($userID, $routeID)){
//            $query = "UPDATE orders SET Status = '$orderStatus'
//                        WHERE ID_Route = $routeID
//                        AND Status = 'Ожидание поездки'";
            $query = "UPDATE orders SET Status = '$orderStatus'
                        WHERE ID_Route = $routeID";
            $result = mysqli_query($dbLink, $query) or die ("Select error ".mysqli_error($dbLink));

            if($result){
                LogsWriteMessage("trip status updated to: '$orderStatus'");
            }else{
                LogsWriteMessage("database error");
            }
        }else{
            LogsWriteMessage("This driver don't have orders in this route");
        }
    }else{
        LogsWriteMessage("This user is not a driver");
    }
}
//isUserDriver(50);
function isUserDriver($userID){
    include "../../database/dbConnection.php";

    $isDriver = false;

    $query = "SELECT * FROM `users` 
                WHERE ID = $userID AND Role = 'Driver'";
    $result = mysqli_query($dbLink, $query) or die ("Select error ".mysqli_error($dbLink));

    if($result){
        $row = mysqli_fetch_row($result);

        if(!empty($row[0])){
            $isDriver = true;
            LogsWriteMessage("This user is driver");
            return $isDriver;
        }else{
            LogsWriteMessage("This user isn't driver");
            return $isDriver;
        }
    }else{
        $isDriver = false;
        LogsWriteMessage("database error");
        return $isDriver;
    }
}

function isDriverHasOrderInRoute($driverID, $routeID){

    include "../../database/dbConnection.php";

    $isHasOrderInRoute = false;

    $query = "SELECT o.Status, u.PhoneNumber FROM orders o 
                    INNER JOIN routes r ON r.ID = o.ID_Route 
                    INNER JOIN autos a ON a.ID = r.ID_Auto 
                    INNER JOIN drivers_autos da ON da.ID_Auto = a.ID 
                    INNER JOIN users u ON u.ID = da.ID_Driver 
                    WHERE da.ID_Driver = $driverID AND o.ID_Route = $routeID";
    $result = mysqli_query($dbLink, $query) or die ("Select error ".mysqli_error($dbLink));

    if($result){
        $row = mysqli_fetch_row($result);

        if(!empty($row[0])){
            $isHasOrderInRoute = true;
            LogsWriteMessage("This driver has orders in this route");
            return $isHasOrderInRoute;
        }else{
            LogsWriteMessage("This driver isn't has orders in this route");
            return $isHasOrderInRoute;
        }
    }else{
        $isHasOrderInRoute = false;
        LogsWriteMessage("database error");
        return $isHasOrderInRoute;
    }
}