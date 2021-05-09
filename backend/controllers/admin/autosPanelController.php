<?php
include("../auto/autoController.php");
header("Access-Control-Allow-Origin: http://localhost:3000");

getAutoTable();

$auto = json_encode(['Mark' => 'Mercedes', 'Model' => 'Sprinter', 'GovernmentNumber' => '1234AA-6', 'SeatsNumber' => 15, 'Color' => 'Orange']);
//createAuto($auto);

function createAuto($auto){
    include "../../database/dbConnection.php";
    include "../../utils/logger.php";

    $auto = json_decode($auto, true);
    $errorsArray = array();

    if(!empty($auto)){
        $governmentNumber = $auto["GovernmentNumber"];

        $query = "SELECT GovernmentNumber FROM autos WHERE GovernmentNumber = '$governmentNumber'";
        $result = mysqli_query($dbLink, $query) or die ("Select error" . mysqli_error($dbLink));

        $resultGovernmentNumber = mysqli_fetch_row($result);

        if(empty($resultGovernmentNumber[0])){
            $mark = $auto["Mark"];
            $model = $auto["Model"];
            $seatsNumber = (int)$auto["SeatsNumber"];
            $color = $auto["Color"];

            $query = "INSERT INTO autos(Mark, Model, GovernmentNumber, SeatsNumber, Color) VALUES ('$mark', '$model', '$governmentNumber', $seatsNumber, '$color')";
            $result = mysqli_query($dbLink, $query) or die ("Select error" . mysqli_error($dbLink));

            LogsWriteMessage("car ".$mark." ".$model." ".$governmentNumber." added to data base");

            return json_encode($auto);
        }else{
            array_push($errorsArray, "машина с таким номером уже существует");
            LogsWriteMessage("this government number is registred");

            return json_encode($errorsArray);
        }
    }else{
        array_push($errorsArray, "ошибка передачи данных");
        LogsWriteMessage("JSON object is empty");

        return json_encode($errorsArray);
    }
}

