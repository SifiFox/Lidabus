<?php

function getDriversByDayOfWeek(){
    if(getWeekDay() % 2 == 1){
        return getOddDriverOnAuto();
    }else{
        return getEvenDriverOnAuto();
    }
}

function getThreeDriversByDayOfWeek(){
    if(getWeekDay() % 2 == 1){
        return getOddDriverOnAuto();
    }else{
        return getEvenDriverOnAuto();
    }
}

function getEvenDriverOnAuto(){
    include "../../database/dbConnection.php";
    include "../../utils/logger.php";

    $query = "SELECT u.ID, u.PhoneNumber, u.Surname, u.Name, u.Patronymic,
                    r.Rating, a.Mark, a.Model, a.GovernmentNumber, a.SeatsNumber, a.Color,
                    ro.Date, ro.Destination, ro.StartTreepTime, ro.EndTreepTime, ro.Status
                    FROM users u
                    INNER JOIN rating r ON r.ID = u.ID_Rating
                    INNER JOIN drivers_autos da ON da.ID_Driver = u.ID
                    INNER JOIN autos a ON a.ID = da.ID_Auto
                    INNER JOIN routes ro ON ro.ID_Auto = a.ID
                    WHERE (da.ID % 2) = 0
                    GROUP BY u.ID
                    ORDER BY u.ID";
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

function getOddDriverOnAuto(){
    include "../../database/dbConnection.php";
    include "../../utils/logger.php";

    $query = "SELECT u.ID, u.PhoneNumber, u.Surname, u.Name, u.Patronymic,
                    r.Rating, a.Mark, a.Model, a.GovernmentNumber, a.SeatsNumber, a.Color,
                    ro.Date, ro.Destination, ro.StartTreepTime, ro.EndTreepTime, ro.Status
                    FROM users u
                    INNER JOIN rating r ON r.ID = u.ID_Rating
                    INNER JOIN drivers_autos da ON da.ID_Driver = u.ID
                    INNER JOIN autos a ON a.ID = da.ID_Auto
                    INNER JOIN routes ro ON ro.ID_Auto = a.ID
                    WHERE (da.ID % 2) = 1
                    GROUP BY u.ID
                    ORDER BY u.ID";
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

function getThreeEvenDriverOnAuto(){
    include "../../database/dbConnection.php";
    include "../../utils/logger.php";

    $query = "SELECT u.ID, u.PhoneNumber, u.Surname, u.Name, u.Patronymic,
                    r.Rating, a.Mark, a.Model, a.GovernmentNumber, a.SeatsNumber, a.Color,
                    ro.Date, ro.Destination, ro.StartTreepTime, ro.EndTreepTime, ro.Status
                    FROM users u
                    INNER JOIN rating r ON r.ID = u.ID_Rating
                    INNER JOIN drivers_autos da ON da.ID_Driver = u.ID
                    INNER JOIN autos a ON a.ID = da.ID_Auto
                    INNER JOIN routes ro ON ro.ID_Auto = a.ID
                    WHERE (da.ID % 2) = 0
                    GROUP BY u.ID
                    ORDER BY u.ID
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

function getThreeOddDriverOnAuto(){
    include "../../database/dbConnection.php";
    include "../../utils/logger.php";

    $query = "SELECT u.ID, u.PhoneNumber, u.Surname, u.Name, u.Patronymic,
                    r.Rating, a.Mark, a.Model, a.GovernmentNumber, a.SeatsNumber, a.Color,
                    ro.Date, ro.Destination, ro.StartTreepTime, ro.EndTreepTime, ro.Status
                    FROM users u
                    INNER JOIN rating r ON r.ID = u.ID_Rating
                    INNER JOIN drivers_autos da ON da.ID_Driver = u.ID
                    INNER JOIN autos a ON a.ID = da.ID_Auto
                    INNER JOIN routes ro ON ro.ID_Auto = a.ID
                    WHERE (da.ID % 2) = 1
                    GROUP BY u.ID
                    ORDER BY u.ID
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

function getWeekDay(){
    $date = date('Y-m-d');

    return date('w', strtotime($date));
}