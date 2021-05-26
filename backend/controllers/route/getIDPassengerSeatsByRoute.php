<?php
header("Access-Control-Allow-Origin: http://localhost:3000");

$object = json_decode($_GET['getRouteID'], true);

getIDPassengerSeatsByRoute($object);

function getIDPassengerSeatsByRoute($object){
    include "../../database/dbConnection.php";
    include "../../utils/logger.php";

    $routeID = $object['Route_ID'];

    $query = "SELECT op.ID_PassengerSeat FROM orders_passengerseats op 
                    INNER JOIN orders o ON o.ID = op.ID_Order 
                    WHERE o.ID_Route = $routeID";
    $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));

    if($result){
        $data = array();

        while($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }

        echo json_encode($data);

        LogsWriteMessage("Getting id passenger seats");
        return json_encode($data);
    }else{
        LogsWriteMessage("DB error getting id passenger seats");
        return json_encode("ошибка БД");
    }
}