<?php
header("Access-Control-Allow-Origin: http://localhost:3000");

$object = json_decode($_GET['getDestination'], true);

getThreeDriversByDayOfWeek($object);

function getThreeDriversByDayOfWeek($object){
    if(getWeekDay() % 2 == 1){
        return getThreeOddDriverOnAuto($object);
    }else{
        return getThreeEvenDriverOnAuto($object);
    }
}

function getWeekDay(){
    $date = date('Y-m-d');

    return date('w', strtotime($date));
}

function getThreeOddDriverOnAuto($object){
    include "../../database/dbConnection.php";
    include "../../utils/logger.php";

    $date = date('Y/m/d');
    $destination = $object['Destination'];
    $currentTime = date("h:i");

    $query = "SELECT u.ID, u.PhoneNumber, u.Surname, u.Name, u.Patronymic, r.Rating, 
                    a.Mark, a.Model, a.GovernmentNumber, a.SeatsNumber, a.Color, ro.ID AS Route_ID,
                    ro.Date, ro.Destination, ro.StartTreepTime, ro.EndTreepTime, ro.Status 
                    FROM users u 
                    INNER JOIN rating r ON r.ID = u.ID_Rating 
                    INNER JOIN drivers_autos da ON da.ID_Driver = u.ID 
                    INNER JOIN autos a ON a.ID = da.ID_Auto 
                    INNER JOIN routes ro ON ro.ID_Auto = a.ID 
                    WHERE (da.ID % 2) = 1 
                    AND ro.Destination = '$destination'
                    AND ro.Date = '$date'
                    AND ro.StartTreepTime > '$currentTime'
                    AND ro.Status = 'В ожидании' 
                    GROUP BY u.ID 
                    ORDER BY ro.StartTreepTime 
                    LIMIT 3";
    $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));

    if($result){
        $data = array();

        while($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }

        echo json_encode($data);

        LogsWriteMessage("Getting odd drivers");
        return json_encode($data);
    }else{
        LogsWriteMessage("DB error getting odd drivers");
        return json_encode("ошибка БД");
    }
}

function getThreeEvenDriverOnAuto($object){
    include "../../database/dbConnection.php";
    include "../../utils/logger.php";

    $date = date('Y/m/d');
    $destination = $object['Destination'];
    $currentTime = date("h:i");

    $query = "SELECT u.ID, u.PhoneNumber, u.Surname, u.Name, u.Patronymic, r.Rating, 
                    a.Mark, a.Model, a.GovernmentNumber, a.SeatsNumber, a.Color, ro.ID AS Route_ID,
                    ro.Date, ro.Destination, ro.StartTreepTime, ro.EndTreepTime, ro.Status 
                    FROM users u 
                    INNER JOIN rating r ON r.ID = u.ID_Rating 
                    INNER JOIN drivers_autos da ON da.ID_Driver = u.ID 
                    INNER JOIN autos a ON a.ID = da.ID_Auto 
                    INNER JOIN routes ro ON ro.ID_Auto = a.ID 
                    WHERE (da.ID % 2) = 0 
                    AND ro.Destination = '$destination'
                    AND ro.Date = '$date'
                    AND ro.StartTreepTime > '$currentTime'
                    AND ro.Status = 'В ожидании' 
                    GROUP BY u.ID 
                    ORDER BY ro.StartTreepTime 
                    LIMIT 3";
    $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));

    if($result){
        $data = array();

        while($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }

        echo json_encode($data);

        LogsWriteMessage("Getting even drivers");
        return json_encode($data);
    }else{
        LogsWriteMessage("DB error getting even drivers");
        return json_encode("ошибка БД");
    }
}