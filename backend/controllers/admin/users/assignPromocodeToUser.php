<?php
include "../../../database/dbConnection.php";
include "../../../utils/logger.php";

//назначить промокод
//$assignPromocode = json_encode(['ID_User' => 20, 'ID_Promocode' => 18]);
header("Access-Control-Allow-Origin: http://localhost:3000");

$object = json_decode($_POST['assignPromocodeToUser'], true);

assignPromocodeToUser($object);

function assignPromocodeToUser($assignPromocode){
    $userID = $assignPromocode["ID_User"];
    $promocodeID = $assignPromocode["ID_Promocode"];
    //проверка на то назначен ли этот промокд юзеру
    $query = "SELECT ID_Promocode FROM users_promocodes WHERE ID_Promocode = $promocodeID";
    $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));

    if($result){
        $row = mysqli_fetch_row($result);
        if(empty($row[0])){//если не назначен этот промокод, то назначить
            $query = "INSERT INTO users_promocodes(ID_User, ID_Promocode) VALUES($userID, $promocodeID)";
            $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));

            LogsWriteMessage("Promocode assigned");
            return json_encode("Промокод назначен");
        }else{//промокод уже назначен - назначить другому юзеру
            LogsWriteMessage("This promocode has already been assigned to the user, assign a different one");
            return json_encode("Данный промокд уже назначен юзеру, назначьте другой");
        }
    }else{
        LogsWriteMessage("Error database");
        return json_encode("ошибка селекта БД");
    }
}