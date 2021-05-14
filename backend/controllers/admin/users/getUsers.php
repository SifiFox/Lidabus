<?php
header("Access-Control-Allow-Origin: http://localhost:3000");

if(json_decode($_GET['getUsers'], true)){
    getUsers();
}

function getUsers(){
    include "../../../database/dbConnection.php";
    include "../../../utils/logger.php";

    $query = "SELECT u.id, u.PhoneNumber, u.Surname, u.Name, 
                    u.Patronymic, u.Patronymic, u.Role, u.Status, r.Rating 
                    FROM users u
                INNER JOIN rating r ON r.ID = u.ID_Rating
                WHERE Role = 'User'
                ORDER BY u.ID ASC";
    $result = mysqli_query($dbLink, $query) or die ("Database error");

    if($result){
        $resultRow = mysqli_fetch_assoc($result);

        LogsWriteMessage("Getting information about users");
        return $resultRow;
    }else{
        LogsWriteMessage("DB error getting information about users");
        return json_encode("ошибка БД");
    }
}