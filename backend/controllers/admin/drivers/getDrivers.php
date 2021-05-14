<?php
header("Access-Control-Allow-Origin: http://localhost:3000");

$object = json_decode($_POST['getDrivers'], true);

if($object){
    getDrivers();
}

function getDrivers(){
    include "../../../database/dbConnection.php";
    include "../../../utils/logger.php";

    $query = "SELECT u.id, u.PhoneNumber, u.Surname, u.Name, 
                    u.Patronymic, u.Patronymic, u.Role, u.Status, r.Rating 
                    FROM users u
                INNER JOIN rating r ON r.ID = u.ID_Rating
                WHERE Role = 'Driver'
                ORDER BY u.ID ASC";
    $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));

    if($result){
        $data = array(); // в этот массив запишем то, что выберем из базы

        while($row = mysqli_fetch_assoc($result)){ // оформим каждую строку результата
            // как ассоциативный массив
            $data[] = $row; // допишем строку из выборки как новый элемент результирующего массива
        }

        LogsWriteMessage("Getting drivers from user table is success");
        return json_encode($data);
    }else{
        LogsWriteMessage("Getting driver from user table is failed");
        return json_encode("Ошибка при получении информации о водителях");
    }
}