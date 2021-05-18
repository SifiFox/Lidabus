<?php

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

        print_r(json_encode($countSeatsNumber));
        LogsWriteMessage("$countSeatsNumber -> ordered number of seats by the user");
        return $countSeatsNumber;
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

        print_r(json_encode($cost));
        LogsWriteMessage("Cost of roder = $cost Br");
        return $cost;
    }
}

function getUsersOrderedRouteByRouteID($routeID){
    include "../../database/dbConnection.php";
    include "../../utils/logger.php";

    $query = "SELECT u.Surname, u.Name, u.PhoneNumber, o.PassengerCount, r.Destination FROM orders o 
                INNER JOIN users u ON u.ID = o.ID_User
                INNER JOIN routes r ON r.ID = o.ID_Route
                WHERE o.ID_Route = $routeID";
    $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));

    if($result) {
        $data = array(); // в этот массив запишем то, что выберем из базы

        while ($row = mysqli_fetch_assoc($result)) { // оформим каждую строку результата
            // как ассоциативный массив
            $data[] = $row; // допишем строку из выборки как новый элемент результирующего массива
        }

        print_r(json_encode($data));
        LogsWriteMessage("Getting ordered users route is success");
        return json_encode($data);
    }else{
        LogsWriteMessage("Error getting ordered users route information");
        return json_encode("Ошибка при получении информации о пользователях заказавших поездку");
    }
}