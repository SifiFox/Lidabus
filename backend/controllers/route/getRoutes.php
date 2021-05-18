<?php
require_once "../../database/dbConnection.php";
require_once "../../utils/logger.php";

header("Access-Control-Allow-Origin: http://localhost:3000");

$object = json_decode($_GET['getRoutes'], true);
getRoutesWithDependenciesByDate($object);

function getRoutesWithDependenciesByDate($object){
    $date = $object['Date'];
    $query = "SELECT r.Destination, r.StartTreepTime, r.EndTreepTime,
                    a.Mark, a.Model, a.GovernmentNumber, a.Color,
                    u.PhoneNumber, u.Name FROM routes r
                JOIN autos a ON a.ID = r.ID_Auto
                JOIN drivers_autos da ON da.ID_Auto = a.ID
                JOIN users u ON u.ID = da.ID_Driver
                WHERE r.Date = '$date'
                ORDER BY r.StartTreepTime, r.Destination";
    $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));

    if($result) {
        $data = array(); // в этот массив запишем то, что выберем из базы

        while ($row = mysqli_fetch_assoc($result)) { // оформим каждую строку результата
            // как ассоциативный массив
            $data[] = $row; // допишем строку из выборки как новый элемент результирующего массива
        }

        print_r(json_encode($data));
        LogsWriteMessage("Getting routes table is succesfully received");
        return json_encode($data);
    }else{
        LogsWriteMessage("Error retrieving route information");
        return json_encode("Ошибка при получении информации о маршрутах");
    }
}