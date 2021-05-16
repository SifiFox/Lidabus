<?php

//функция удаления введенного промокода
//deletePromocodeAfterUsing("OBkoKe");
function deletePromocodeAfterUsing($promocode){
    include "../../database/dbConnection.php";
    include "get.php";

    $promocodeID = getPromocodeID($promocode);

    $query = "DELETE FROM users_promocodes WHERE ID_Promocode = $promocodeID";
    $result = mysqli_query($dbLink, $query) or die ("Select error ".mysqli_error($dbLink));

    if($result){
        $query = "DELETE FROM promocodes WHERE ID = $promocodeID";
        $result = mysqli_query($dbLink, $query) or die ("Select error ".mysqli_error($dbLink));

        LogsWriteMessage("Promocode successfully used");
        return json_encode("Промокод успешно использован");
    }else{
        LogsWriteMessage("db delete promocode error");
        return json_encode("db delete error");
    }
}

function isUserHavePromocode($userID, $promocode){
    include "../../database/dbConnection.php";
    include "get.php";

    $promocodeID = getPromocodeID($promocode);

    $query = "SELECT ID FROM `users_promocodes` WHERE ID_User = $userID AND ID_Promocode = $promocodeID";
    $result = mysqli_query($dbLink, $query) or die ("Select error ".mysqli_error($dbLink));

    if($result){
        $row = mysqli_fetch_row($result);
        if(!empty($row[0])){
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
}