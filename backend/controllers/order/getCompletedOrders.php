<?php
header("Access-Control-Allow-Origin: http://localhost:3000");

$object = json_decode($_POST['getCompletedOrders'], true);

getCompletedOrdersByUserID($object);

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

        LogsWriteMessage("Data on the user's completed trips received");
        return json_encode($data);
    }else{
        LogsWriteMessage("Error retrieving route information");
        return json_encode("Ошибка при получении информации о маршрутах");
    }
}
