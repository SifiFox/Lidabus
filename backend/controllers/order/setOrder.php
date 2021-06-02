<?php

header("Access-Control-Allow-Origin: http://localhost:3000");

$object = json_decode($_POST['setOrder'], true);

setOrderByUserID($object);

function setOrderByUserID($order){
    include "../../database/dbConnection.php";
    include "../auto/get.php";
    include "../../utils/logger.php";

    $passengerCount = $order['PassengerCount'];
    $autoSeatsNumber = intval(getAutoSeatsNumberByID($order['ID_Auto']));
    $seatsNumberInRoute = intval(getSeatsNumberByRoute($order['ID_Route']));
    $userID = intval($order['ID_User']);

    if(isUserActive($userID)){
        if($autoSeatsNumber >= $seatsNumberInRoute + $passengerCount){
            $autoID = $order['ID_Auto'];
            $routeID = intval($order['ID_Route']);
            $startPoint = $order['StartPoint'];
            $endPoint = $order['EndPoint'];
            $cost = getOrderCostByPassengerCount($userID, $passengerCount, $order['Promocode']);
            $passengerSeatsNumber = $order['ID_PassengerSeat'];

            if(isEmptyPassengerSeat($routeID, $passengerSeatsNumber)){
                $startPointID = getIDAddresseByAddress($startPoint);
                $endPointID = getIDAddresseByAddress($endPoint);
                $query = "INSERT INTO orders(ID_User, ID_Route, PassengerCount, ID_StartPoint, ID_EndPoint, Cost)
                        VALUES($userID, $routeID, $passengerCount, $startPointID, $endPointID, $cost)";
                $result = mysqli_query($dbLink, $query) or die ("Select error ".mysqli_error($dbLink));

                if($result){
                    $query = "SELECT @@IDENTITY";
                    $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));
                    $row = $result->fetch_row();
                    $orderID= $row[0] ?? false;

                    setPassengerSeat($orderID, $passengerSeatsNumber);
                    LogsWriteMessage("Reservation made, expect a trip");
                }else{
                    LogsWriteMessage("Error while entering data into the table of orders");
                }
            }else{
                LogsWriteMessage("Seats are reserved, let the user select free seats");
            }
        }else{
            if($autoSeatsNumber - $seatsNumberInRoute > 0){
                LogsWriteMessage("Book less. You ordered: ". $passengerCount.". Number of free seats: ".($autoSeatsNumber - $seatsNumberInRoute));
            }
            else{
                LogsWriteMessage("No free places");
            }
        }
    }else{
        LogsWriteMessage("You are blocked, you can't order a trip");
    }
}

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

function isEmptyPassengerSeat($routeID, $passengerSeatsNumber){
    include "../../database/dbConnection.php";

    $isSetPassengerSeat = true;
    $occupiedSeatNumber = array();
//    $passengerSeatsNumber = explode(",", $passengerSeatsNumber);
    $passengerSeatsNumber = array_map(function($arr) {
        return intval($arr);
    }, $passengerSeatsNumber);
    //проверка на то свободно ли место
    foreach($passengerSeatsNumber as $number){
        $query = "SELECT op.ID_PassengerSeat FROM orders_passengerseats AS op
                    INNER JOIN orders AS o ON o.ID = op.ID_Order
                    WHERE o.ID_Route = $routeID 
                    AND op.ID_PassengerSeat = $number";
        $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));

        if($result){
            $row = mysqli_fetch_row($result);
            if(empty($row[0])){
                LogsWriteMessage($number." is empty");
            }else{
                array_push($occupiedSeatNumber, $number);
            }
        }else{
            LogsWriteMessage("Database error");
        }
    }
    if(!empty($occupiedSeatNumber)){
        $isSetPassengerSeat = false;
        return $isSetPassengerSeat;
    }else{
        return $isSetPassengerSeat;
    }
}

function setPassengerSeat($orderID, $passengerSeatsNumber){
    include "../../database/dbConnection.php";

//    $passengerSeatsNumber = explode(",", $passengerSeatsNumber);
    foreach($passengerSeatsNumber as $number){
        $query = "INSERT INTO orders_passengerseats(ID_Order, ID_PassengerSeat) VALUES($orderID, $number)";
        $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));
        if($result){
            LogsWriteMessage("Passengers already added to orders_passengerseats table");
        }else{
            LogsWriteMessage("Database error");
        }
    }
}

function getIDAddresseByAddress($address){
    include "../../database/dbConnection.php";

    $query = "SELECT ID FROM addresses WHERE Address = '$address'";
    $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));

    if($result) {
        $addressID = 0;

        while($row = $result -> fetch_object()){
            $addressID = $row -> ID;
        }

        LogsWriteMessage("Getting id address is succesfully received");
        return $addressID;
    }else{
        LogsWriteMessage("Error retrieving id address information");
        return json_encode("Ошибка при получении информации о айди адреса");
    }
}


function getSeatsNumberByRoute($routeID){
    include "../../database/dbConnection.php";

    $query = "SELECT SUM(o.PassengerCount) AS seatsNumber FROM orders o
                WHERE o.ID_Route = $routeID";
    $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));

    if($result){
        $countSeatsNumber = 0;

        while($row = $result -> fetch_object()){
            $countSeatsNumber = $row -> seatsNumber;
        }
        LogsWriteMessage("$countSeatsNumber -> ordered number of seats by the user");
        if($countSeatsNumber == null){
            $countSeatsNumber = 0;
            return $countSeatsNumber;
        }else{
            return $countSeatsNumber;
        }
    }else{
        LogsWriteMessage("Error when getting information about the number of free seats in the car");
        return 0;
    }
}

function getOrderCostByPassengerCount($userID, $passengerCount, $promocode)  {
    include "../../database/dbConnection.php";
    include "../promocode/deletePromocode.php";
    include "../promocode/get.php";

    $cost = 0;

    if(isUserHavePromocode($userID, $promocode)){
        $promocodeSale = getPromocodeSale($promocode) -> Sale;
        $cost = $passengerCount * (9 - (9 * $promocodeSale));
        deletePromocodeAfterUsing($promocode);

        LogsWriteMessage("Cost of roder = $cost Br");
        return $cost;
    }else{
        $cost = $passengerCount * 9;

        LogsWriteMessage("Cost of roder = $cost Br");
        return $cost;
    }
}