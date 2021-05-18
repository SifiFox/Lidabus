<?php
require_once "../../../database/dbConnection.php";
require_once "../../../utils/logger.php";
//$object = json_encode(['ID_Driver' => n, 'ID_Auto' => n]);
header("Access-Control-Allow-Origin: http://localhost:3000");

$object = json_decode($_POST['assignDriverToAuto'], true);

assignDriverToAuto($object);

function assignDriverToAuto($object){
    $driverID = $object["ID_Driver"];
    $autoID = $object["ID_Auto"];

    $query = "UPDATE drivers_autos SET ID_Auto = $autoID
                WHERE ID_Driver = $driverID";
    $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));

    if($result){
        LogsWriteMessage("Driver assigned to car");
        return json_encode("Машина назначена водителю");
    }else{
        LogsWriteMessage("DB error in assign driver to Auto");
        return json_encode("Ошибка базы данных при назначении машины водителю");
    }
}