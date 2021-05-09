<?php

$order = json_encode(['ID_User' => 20, 'ID_Auto' => 1, 'ID_Route' => 1, 'PassengerCount' => 1, 'ID_StartPoint' => 1, 'ID_EndPoint' => 7, 'Promocode' => 'ADMIN']);

//setOrderByUserID($order);

function setOrderByUserID($order){
    include "../../database/dbConnection.php";
    include "../auto/autoController.php";

    $order = json_decode($order, true);
    $passengerCount = $order['PassengerCount'];
    $autoSeatsNumber = intval(getAutoSeatsNumberByID($order['ID_Auto']));
    $seatsNumberInRoute = intval(getSeatsNumberByRoute($order['ID_Route']));

    if($autoSeatsNumber >= $seatsNumberInRoute + $passengerCount){
        $userID = $order['ID_User'];
        $autoID = $order['ID_Auto'];
        $routeID = $order['ID_Route'];
        $startPointID = $order['ID_StartPoint'];
        $endPointID = $order['ID_EndPoint'];
        $cost = setOrderCostByPassengerCount($passengerCount, $order['Promocode']);

        $query = "INSERT INTO orders(ID_User, ID_Route, PassengerCount, ID_StartPoint, ID_EndPoint, Cost)
                    VALUES($userID, $routeID, $passengerCount, $startPointID, $endPointID, $cost)";
        $result = mysqli_query($dbLink, $query) or die ("Select error ".mysqli_error($dbLink));

        if($result){
            echo "Бронь оформлена, ожидайте поездки";
        }else{
            echo "Ошибка при внесении данных в таблицу заказов";
        }
    }else{
        if($autoSeatsNumber - $seatsNumberInRoute > 0){
            echo "Забронируйте меньшее количество. Вы заказали: ".$passengerCount.". Количество свободны мест: ".($autoSeatsNumber - $seatsNumberInRoute);
        }
        else{
            echo "Нет свободных мест";
        }
    }

}

function getOrdersByUserID($userID){
    include "../../database/dbConnection.php";

    $query = "SELECT * FROM orders WHERE ID_User = $userID";
    $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));

    if($result) {
        $data = array(); // в этот массив запишем то, что выберем из базы

        while ($row = mysqli_fetch_assoc($result)) { // оформим каждую строку результата
            // как ассоциативный массив
            $data[] = $row; // допишем строку из выборки как новый элемент результирующего массива
        }
        var_dump(json_encode($data));  // и отдаём как json
        return json_encode($data);
    }else{
        return json_encode("Ошибка при получении информации о маршрутах");
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

        return $countSeatsNumber;
    }else{
        echo "Ошибка при получении информации о количестве свободных мест в машине";
        return 0;
    }
}
setOrderCostByPassengerCount(20,3);
function setOrderCostByPassengerCount($userID, $passengerCount, $promocode = null){
    include("../promocode/promocodeController.php");

    $cost = 0;
//    if(!empty(getPromocodeTableByUser($userID))){
//        $promocodeSale = getPromocodeSale($promocode) -> Sale;
//
//        $cost = $passengerCount * (9 - (9 * $promocodeSale));
//        echo "123";
//
//        return $cost;
//    }else{
//        $cost = $passengerCount * 9;
//
//        return $cost;
//    }
}