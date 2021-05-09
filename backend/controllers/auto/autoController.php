<?php
function getAutoTable(){
    include "../../database/dbConnection.php";
    include "../../utils/logger.php";

    $query = "SELECT * FROM autos ORDER BY ID";
    $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));

    if($result){
        $data = array(); // в этот массив запишем то, что выберем из базы

        while($row = mysqli_fetch_assoc($result)){ // оформим каждую строку результата
            // как ассоциативный массив
            $data[] = $row; // допишем строку из выборки как новый элемент результирующего массива
        }
        LogsWriteMessage("Getting autos table is success");

        echo json_encode($data); // и отдаём как json
        return json_encode($data);
    }else{
        LogsWriteMessage("Getting autos table is failed");

        return json_encode("Ошибка при получении информации о автомобилях");
    }
}

function getAutoSeatsNumberByID($autoID){
    include "../../database/dbConnection.php";
    include "../../utils/logger.php";

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

