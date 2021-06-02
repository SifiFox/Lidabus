<?php

function getAuto($autoID){
    include "../../database/dbConnection.php";
    include "../../utils/logger.php";

    $query = "SELECT * FROM autos WHERE ID = $autoID";
    $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));

    if($result){
        $data = array(); // в этот массив запишем то, что выберем из базы

        while($row = mysqli_fetch_assoc($result)){ // оформим каждую строку результата
            // как ассоциативный массив
            $data[] = $row; // допишем строку из выборки как новый элемент результирующего массива
        }

        print_r(json_encode($data));
        LogsWriteMessage("Getting autos is success");
        return json_encode($data);
    }else{
        LogsWriteMessage("Getting auto is failed");
        return json_encode("Ошибка при получении информации о автомобиле");
    }
}

function getAutoSeatsNumberByID($autoID){
    include "../../database/dbConnection.php";

    $query = "SELECT SeatsNumber AS count FROM autos WHERE ID = $autoID";
    $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));

    if($result){
        $countAutoSeatsNumber = 0;

        while($row = $result -> fetch_object()){
            $countAutoSeatsNumber = $row -> count;
        }

        LogsWriteMessage("Getting auto seatsNumber is success");
        return $countAutoSeatsNumber;
    }else{
        LogsWriteMessage("Getting auto seatsNumber is failed");
        return json_encode("Getting auto seatsNumber is failed");
    }
}

function getAutoByDriverID($driverID){
    include "../../database/dbConnection.php";
    include "../../utils/logger.php";

    $query = "SELECT a.Mark, a.Model, a.GovernmentNumber, a.SeatsNumber, a.Color 
                FROM autos a
                INNER JOIN drivers_autos da ON drivers_autos.ID_Auto = a.ID
                WHERE da.ID_Driver = $driverID";
    $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));

    if($result){
        $data = array(); // в этот массив запишем то, что выберем из базы

        while($row = mysqli_fetch_assoc($result)){ // оформим каждую строку результата
            // как ассоциативный массив
            $data[] = $row; // допишем строку из выборки как новый элемент результирующего массива
        }

        print_r(json_encode($data));
        LogsWriteMessage("Getting auto is success");
        return json_encode($data);
    }else{
        LogsWriteMessage("Getting auto is failed");
        return json_encode("Ошибка при получении информации о автомобиле");
    }
}