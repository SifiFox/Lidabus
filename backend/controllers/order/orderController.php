<?php

//$order = json_encode(['ID_User' => 20, 'ID_Auto' => 3, 'ID_Route' => 2, 'PassengerCount' => 3, 'ID_StartPoint' => 1, 'ID_EndPoint' => 7, 'Promocode' => 'ivcSOd', 'ID_PassengerSeat' => '2 12 11']);

$order = json_encode(['ID_User' => 66, 'ID_Auto' => 3, 'ID_Route' => 1, 'PassengerCount' => 2, 'ID_StartPoint' => 1, 'ID_EndPoint' => 7, 'ID_PassengerSeat' => '2 3']);
//setOrderByUserID($order);

function setOrderByUserID($order){
    include "../../database/dbConnection.php";
    include "../auto/autoController.php";
    include "../../utils/logger.php";
    include "../user/profile.php";

    $order = json_decode($order, true);
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
//                echo "Бронь оформлена, ожидайте поездки";
                    LogsWriteMessage("Reservation made, expect a trip");
                }else{
//                echo "Ошибка при внесении данных в таблицу заказов";
                    LogsWriteMessage("Error while entering data into the table of orders");
                }
            }else{
//            echo "22222";
                LogsWriteMessage("Seats are reserved, let the user select free seats");
            }
        }else{
            if($autoSeatsNumber - $seatsNumberInRoute > 0){
//            echo "Забронируйте меньшее количество. Вы заказали: ".$passengerCount.". Количество свободны мест: ".($autoSeatsNumber - $seatsNumberInRoute);
                LogsWriteMessage("Book less. You ordered: ". $passengerCount.". Number of free seats: ".($autoSeatsNumber - $seatsNumberInRoute));
            }
            else{
//            echo "Нет свободных мест";
                LogsWriteMessage("No free places");
            }
        }
    }else{
        LogsWriteMessage("You are blocked, you can't order a trip");
    }
}
//isEmptyPassengerSeat(2, '2 12 13');
function isEmptyPassengerSeat($routeID, $passengerSeatsNumber){
    include "../../database/dbConnection.php";
//    include "../../utils/logger.php";

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
//                echo "$number свободно";
                LogsWriteMessage($number." is empty");
            }else{
                array_push($occupiedSeatNumber, $number);
            }
        }else{
//            echo "db error";
            LogsWriteMessage("Database error");
        }
    }
//    var_dump($occupiedSeatNumber);
    if(!empty($occupiedSeatNumber)){
        $isSetPassengerSeat = false;
//        var_dump($isSetPassengerSeat);
        return $isSetPassengerSeat;
    }else{
//        var_dump($isSetPassengerSeat);
        return $isSetPassengerSeat;
    }
}

function setPassengerSeat($orderID, $passengerSeatsNumber){
    include "../../database/dbConnection.php";
//    include "../../utils/logger.php";

    $passengerSeatsNumber = explode(" ", $passengerSeatsNumber);
    foreach($passengerSeatsNumber as $number){
        $query = "INSERT INTO orders_passengerseats(ID_Order, ID_PassengerSeat) VALUES($orderID, $number)";
        $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));
        if($result){
//            echo "result";
            LogsWriteMessage("Passengers already added to orders_passengerseats table");
        }else{
//            echo "db error";
            LogsWriteMessage("Database error");
        }
    }
}

//getOrdersByUserID(19);
function getCompletedOrdersByUserID($userID){
    include "../../database/dbConnection.php";
    include "../../utils/logger.php";

    $query = "SELECT * FROM orders WHERE ID_User = $userID AND Status = 'Прибыл'";
    $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));

    if($result) {
        $data = array(); // в этот массив запишем то, что выберем из базы

        while ($row = mysqli_fetch_assoc($result)) { // оформим каждую строку результата
            // как ассоциативный массив
            $data[] = $row; // допишем строку из выборки как новый элемент результирующего массива
        }
//        var_dump(json_encode($data));  // и отдаём как json
        LogsWriteMessage("Data on the user's completed trips received");
        return json_encode($data);
    }else{
        LogsWriteMessage("Error retrieving route information");
        return json_encode("Ошибка при получении информации о маршрутах");
    }
}
//getSeatsNumberByRoute(1);
function getSeatsNumberByRoute($routeID){
    include "../../database/dbConnection.php";
//    include "../../utils/logger.php";

    $query = "SELECT SUM(o.PassengerCount) AS seatsNumber FROM orders o
                WHERE o.ID_Route = $routeID";
    $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));

    if($result){
        $countSeatsNumber = 0;

        while($row = $result -> fetch_object()){
            $countSeatsNumber = $row -> seatsNumber;
        }

        LogsWriteMessage("$countSeatsNumber -> ordered number of seats by the user");
        return $countSeatsNumber;
    }else{
//        echo "Ошибка при получении информации о количестве свободных мест в машине";
        LogsWriteMessage("Error when getting information about the number of free seats in the car");
        return 0;
    }
}
//getOrderCostByPassengerCount(19,3, "ADMIN");
function getOrderCostByPassengerCount($userID, $passengerCount, $promocode)  {
    include("../promocode/promocodeController.php");
//    include "../../utils/logger.php";

    $cost = 0;

    if(isUserHavePromocode($userID, $promocode)){
        $promocodeSale = getPromocodeSale($promocode) -> Sale;
        $cost = $passengerCount * (9 - (9 * $promocodeSale));
        deletePromocodeAfterUsing($promocode);
//            echo $cost;
        LogsWriteMessage("Cost of roder = $cost Br");
        return $cost;
    }else{
        $cost = $passengerCount * 9;
//        echo $cost;
        LogsWriteMessage("Cost of roder = $cost Br");
        return $cost;
    }
}