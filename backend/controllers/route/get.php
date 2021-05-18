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

function getRoutesInPendingByDriverID($driverID){
    include "../../database/dbConnection.php";
    include "../../utils/logger.php";

    $query = "SELECT r.Date, r.Destination, r.StartTreepTime, r.EndTreepTime, r.Status FROM routes r
                INNER JOIN autos a ON a.ID = r.ID_Auto
                INNER JOIN drivers_autos da ON da.ID_Auto = a.ID
                WHERE da.ID_Driver = $driverID
                AND r.Status = 'В ожидании'
                ORDER BY r.Date, r.StartTreepTime";
    $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));

    if($result) {
        $data = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        print_r(json_encode($data));
        LogsWriteMessage("Getting routes table by driver is succesfully received");
        return json_encode($data);
    }else{
        LogsWriteMessage("Error retrieving route information");
        return json_encode("Ошибка при получении информации о маршрутах");
    }
}
//getNearestRouteByDriverID(51);
function getNearestRouteByDriverID($driverID){
    include "../../database/dbConnection.php";
    include "../../utils/logger.php";

    $query = "SELECT r.Date, r.Destination, r.StartTreepTime, r.EndTreepTime, r.Status FROM routes r
                INNER JOIN autos a ON a.ID = r.ID_Auto
                INNER JOIN drivers_autos da ON da.ID_Auto = a.ID
                WHERE da.ID_Driver = $driverID
                AND r.Status = 'В ожидании'
                ORDER BY r.Date, r.StartTreepTime
                LIMIT 1";
    $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));

    if($result) {
        $data = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        print_r(json_encode($data));
        LogsWriteMessage("Getting nearest route by driver is succesfully received");
        return json_encode($data);
    }else{
        LogsWriteMessage("Error retrieving route information");
        return json_encode("Ошибка при получении информации о маршруте");
    }
}

function getAllRoutesByDriverID($driverID){
    include "../../database/dbConnection.php";
    include "../../utils/logger.php";

    $query = "SELECT r.Date, r.Destination, r.StartTreepTime, r.EndTreepTime, r.Status FROM routes r
                INNER JOIN autos a ON a.ID = r.ID_Auto
                INNER JOIN drivers_autos da ON da.ID_Auto = a.ID
                WHERE da.ID_Driver = $driverID
                ORDER BY r.Date, r.StartTreepTime DESC";
    $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));

    if($result) {
        $data = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        print_r(json_encode($data));
        LogsWriteMessage("Getting routes table by driver is succesfully received");
        return json_encode($data);
    }else{
        LogsWriteMessage("Error retrieving route information");
        return json_encode("Ошибка при получении информации о маршрутах");
    }
}