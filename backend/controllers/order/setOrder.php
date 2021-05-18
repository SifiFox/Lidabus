<?php
require_once "../../database/dbConnection.php";
require_once "../auto/get.php";
require_once "get.php";
require_once "../../utils/logger.php";

header("Access-Control-Allow-Origin: http://localhost:3000");

$object = json_decode($_POST['setOrder'], true);

setOrderByUserID($object);
//$order = json_encode(['ID_User' => 20, 'ID_Auto' => 3, 'ID_Route' => 2, 'PassengerCount' => 3, 'ID_StartPoint' => 1, 'ID_EndPoint' => 7, 'Promocode' => 'ivcSOd', 'ID_PassengerSeat' => '2 12 11']);

//$order = json_encode(['ID_User' => 66, 'ID_Auto' => 3, 'ID_Route' => 1, 'PassengerCount' => 2, 'ID_StartPoint' => 1, 'ID_EndPoint' => 7, 'ID_PassengerSeat' => '2 3']);
//setOrderByUserID($order);

function setOrderByUserID($order){
    $passengerCount = $order['PassengerCount'];
    $autoSeatsNumber = intval(getAutoSeatsNumberByID($order['ID_Auto']));
    $seatsNumberInRoute = intval(getSeatsNumberByRoute($order['ID_Route']));
    $userID = $order['ID_User'];

    if(isUserActive($userID)){
        if($autoSeatsNumber >= $seatsNumberInRoute + $passengerCount){
            $autoID = $order['ID_Auto'];
            $routeID = $order['ID_Route'];
            $startPointID = $order['ID_StartPoint'];
            $endPointID = $order['ID_EndPoint'];
            $cost = getOrderCostByPassengerCount($userID, $passengerCount, $order['Promocode']);
            $passengerSeatsNumber = $order['ID_PassengerSeat'];

            if(isEmptyPassengerSeat($routeID, $passengerSeatsNumber)){
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
    $isSetPassengerSeat = true;
    $occupiedSeatNumber = array();
    $passengerSeatsNumber = explode(" ", $passengerSeatsNumber);
    //проверка на то свободно ли место
    foreach($passengerSeatsNumber as $number){
        $query = "SELECT op.ID_PassengerSeat FROM orders_passengerseats AS op
                    INNER JOIN orders AS o ON op.ID_Order = o.ID
                    WHERE o.ID_Route = $routeID AND ID_PassengerSeat = $number";
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
    $passengerSeatsNumber = explode(" ", $passengerSeatsNumber);
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