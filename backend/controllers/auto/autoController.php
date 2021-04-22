<?php
function getAutosTable(){
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
        LogsAutoTableAccess();

        echo json_encode($data); // и отдаём как json
    }else{
        LogsAutoTableFailed();
    }
}

function getAutoSeatsNumberByID($autoID){
    include "../../database/dbConnection.php";
//    include "../../utils/logger.php";

    $query = "SELECT SeatsNumber FROM autos WHERE ID = $autoID";
    $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));

    if($result){
        $data = array(); // в этот массив запишем то, что выберем из базы

        while($row = mysqli_fetch_assoc($result)){ // оформим каждую строку результата
            // как ассоциативный массив
            $data[] = $row; // допишем строку из выборки как новый элемент результирующего массива
        }
        LogsAutoGetSeatsNumberByIDSuccess($autoID);

        echo json_encode($data); // и отдаём как json
        return $data;
    }else{
        LogsAutoGetSeatsNumberByIDFailed($autoID);
        return null;
    }
}

