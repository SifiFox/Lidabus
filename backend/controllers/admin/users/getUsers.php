<?php
require_once "../../../database/dbConnection.php";
require_once "../../../utils/logger.php";

header("Access-Control-Allow-Origin: http://localhost:3000");

if(json_decode($_GET['getUsers'], true)){
    getUsers();
}

function getUsers(){
    $query = "SELECT u.id, u.PhoneNumber, u.Surname, u.Name, 
                    u.Patronymic, u.Patronymic, u.Role, u.Status, r.Rating 
                    FROM users u
                INNER JOIN rating r ON r.ID = u.ID_Rating
                WHERE Role = 'User'
                ORDER BY u.ID ASC";
    $result = mysqli_query($dbLink, $query) or die ("Database error");

    if($result){
        $resultRow = mysqli_fetch_assoc($result);

        print_r(json_encode($resultRow));
        LogsWriteMessage("Getting information about users");
        return $resultRow;
    }else{
        LogsWriteMessage("DB error getting information about users");
        return json_encode("ошибка БД");
    }
}