<?php
header("Access-Control-Allow-Origin: http://localhost:3000");

$object = json_decode($_GET['getUsersOrderedRoute'], true);

getUsersOrderedRouteByRouteID($object);

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