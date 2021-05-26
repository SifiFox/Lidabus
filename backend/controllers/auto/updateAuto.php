<?php

header("Access-Control-Allow-Origin: http://localhost:3000");

$object = json_decode($_POST['updateAuto'], true);
update($object);

function update($object){
    include "../../database/dbConnection.php";
    include "../../utils/logger.php";

    $autoDataFromDB = getAutoByID($object["ID"]);

    if($object["Mark"] != $autoDataFromDB["Mark"]){
        updateMark($object);
    }
    if($object["Model"] != $autoDataFromDB["Model"]){
        updateModel($object);
    }
    if($object["GovernmentNumber"] != $autoDataFromDB["GovernmentNumber"]){
        updateGovernmentNumber($object);
    }
    if($object["Color"] != $autoDataFromDB["Color"]){
        updateColor($object);
    }

    echo(json_encode($object));
}

function updateMark($object){
    include "../../database/dbConnection.php";

    $newMark = $object['Mark'];
    $autoID = $object['ID'];

    if(!empty($object)){
        $query = "UPDATE autos SET Mark = '$newMark'
                    WHERE ID = $autoID";
        $result = mysqli_query($dbLink, $query) or die ("Select error " . mysqli_error($dbLink));

        if($result){
            LogsWriteMessage("Mark has been changed");

            $auto = getAutoByID($object['ID']);

            return $auto;
        }else{
            LogsWriteMessage("DB error with updating mark");
            return json_encode("Ошибка БД при обновлении марки");
        }
    }else{
        LogsWriteMessage("Enter the data to update");
        return json_encode("введите данные");
    }
}

function updateModel($object){
    include "../../database/dbConnection.php";

    $newModel = $object['Model'];
    $autoID = $object['ID'];

    if(!empty($object)){
        $query = "UPDATE autos SET Model = '$newModel'
                    WHERE ID = $autoID";
        $result = mysqli_query($dbLink, $query) or die ("Select error " . mysqli_error($dbLink));

        if($result){
            LogsWriteMessage("Model has been changed");

            $auto = getAutoByID($object['ID']);

            return $auto;
        }else{
            LogsWriteMessage("DB error with updating Model");
            return json_encode("Ошибка БД при обновлении модели");
        }
    }else{
        LogsWriteMessage("Enter the data to update");
        return json_encode("введите данные");
    }
}

function updateGovernmentNumber($object){
    include "../../database/dbConnection.php";

    $newGovernmentNumber = $object['GovernmentNumber'];
    $autoID = $object['ID'];

    if(!empty($object)){
        $query = "UPDATE autos SET GovernmentNumber = '$newGovernmentNumber'
                    WHERE ID = $autoID";
        $result = mysqli_query($dbLink, $query) or die ("Select error " . mysqli_error($dbLink));

        if($result){
            LogsWriteMessage("Government number has been changed");

            $auto = getAutoByID($object['ID']);

            return $auto;
        }else{
            LogsWriteMessage("DB error with updating government number");
            return json_encode("Ошибка БД при обновлении номера машины");
        }
    }else{
        LogsWriteMessage("Enter the data to update");
        return json_encode("введите данные");
    }
}

function updateColor($object){
    include "../../database/dbConnection.php";

    $newColor = $object['Color'];
    $autoID = $object['ID'];

    if(!empty($object)){
        $query = "UPDATE autos SET Color = '$newColor'
                    WHERE ID = $autoID";
        $result = mysqli_query($dbLink, $query) or die ("Select error " . mysqli_error($dbLink));

        if($result){
            LogsWriteMessage("Color has been changed");

            $auto = getAutoByID($object['ID']);

            return $auto;
        }else{
            LogsWriteMessage("DB error with updating color");
            return json_encode("Ошибка БД при обновлении цвета");
        }
    }else{
        LogsWriteMessage("Enter the data to update");
        return json_encode("введите данные");
    }
}

function getAutoByID($autoID){
    include "../../database/dbConnection.php";
    include "../../utils/logger.php";

    $query = "SELECT * FROM autos WHERE ID = $autoID";
    $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));

    if($result){
        $resultRow = mysqli_fetch_assoc($result);

        LogsWriteMessage("Getting auto is success");
        return $resultRow ;
    }else{
        LogsWriteMessage("Getting auto is failed");
        return json_encode("Ошибка при получении информации о автомобиле");
    }
}