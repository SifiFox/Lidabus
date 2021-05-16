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

        LogsWriteMessage("$countSeatsNumber -> ordered number of seats by the user");
        return $countSeatsNumber;
    }else{
        LogsWriteMessage("Error when getting information about the number of free seats in the car");
        return 0;
    }
}

function getOrderCostByPassengerCount($userID, $passengerCount, $promocode)  {
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