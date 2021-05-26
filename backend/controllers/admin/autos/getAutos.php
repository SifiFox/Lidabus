<?php
header("Access-Control-Allow-Origin: http://localhost:3000");

$object = json_decode($_GET['getAutos'], true);

getAutos();

function getAutos(){
    include "../../../database/dbConnection.php";
    include "../../../utils/logger.php";

    $query = "SELECT * FROM autos ORDER BY ID";
    $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));

    if($result){
        $data = array(); // в этот массив запишем то, что выберем из базы

        while($row = mysqli_fetch_assoc($result)){ // оформим каждую строку результата
            // как ассоциативный массив
            $data[] = $row; // допишем строку из выборки как новый элемент результирующего массива
        }

        echo(json_encode($data));
        LogsWriteMessage("Getting autos table is success");
        return json_encode($data);
    }else{
        LogsWriteMessage("Getting autos table is failed");
        return json_encode("Ошибка при получении информации о автомобилях");
    }
}