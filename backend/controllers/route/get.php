<?php
function getRoutesByDate($date){
    include "../../database/dbConnection.php";

    $query = "SELECT * FROM routes WHERE Date = '$date'";
    $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));

    if($result) {
        $data = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        print_r(json_encode($data));
        LogsWriteMessage("Getting routes table by date ".$date." is succesfully received");
        return json_encode($data);
    }else{
        LogsWriteMessage("Error retrieving route information");
        return json_encode("Ошибка при получении информации о маршрутах");
    }
}