<?php

header("Access-Control-Allow-Origin: http://localhost:3000");

    getUsers();

//getUsers();
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
        $data = array(); // в этот массив запишем то, что выберем из базы

        while($row = mysqli_fetch_assoc($result)){ // оформим каждую строку результата
            // как ассоциативный массив
            $data[] = $row; // допишем строку из выборки как новый элемент результирующего массива
        }
//        print_r(json_encode($data));
        header('Content-type: application/json');
        echo json_encode($data);

        LogsWriteMessage("Getting information about users");
        return json_encode($data);
    }else{
        LogsWriteMessage("DB error getting information about users");
        return json_encode("ошибка БД");
    }
}