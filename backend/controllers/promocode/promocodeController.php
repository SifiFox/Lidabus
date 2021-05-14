<?php

//функция удаления введенного промокода
//deletePromocodeAfterUsing("OBkoKe");
function deletePromocodeAfterUsing($promocode){
    include "../../database/dbConnection.php";
//    include "../../utils/logger.php";

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
//getPromocodeID("OBkoKe");
function getPromocodeID($promocode){
    include "../../database/dbConnection.php";
//    include "../../utils/logger.php";

    $query = "SELECT ID AS ID FROM promocodes WHERE Promocode = '$promocode'";
    $result = mysqli_query($dbLink, $query) or die ("Select error ".mysqli_error($dbLink));

    if($result){
        $promocodeID = 0;

        while($row = $result -> fetch_object()){
            $promocodeID = $row -> ID;
        }

//        var_dump($promocodeID);
        LogsWriteMessage("Promocode ID is succesfully received");
        return $promocodeID;
    }else{
//        echo "Ошибка при получении информации о ID промокода";
        LogsWriteMessage("Error while getting information about promo code ID");
        return 0;
    }
}

function getPromocodeSale($promocode){
    include "../../database/dbConnection.php";
//    include "../../utils/logger.php";

    $query = "SELECT Sale FROM promocodes WHERE Promocode = '$promocode'";
    $result = mysqli_query($dbLink, $query) or die ("Select error ".mysqli_error($dbLink));

    if($result){
        $promocodeSale = 0;

        while($row = $result -> fetch_object()){
            $promocodeSale = $row;
        }

//        var_dump($promocodeSale);
        LogsWriteMessage("Promocode sale is succesfully received");
        return $promocodeSale;
    }else{
//        echo "Ошибка при получении информации о скидке промокода";
        LogsWriteMessage("Error while getting information about sale ID");
        return 0;
    }
}
//getPromocodeTableByUser(19);
function getPromocodeTableByUser($userID){
    include "../../database/dbConnection.php";
    include "../../utils/logger.php";

    $query = "SELECT p.Promocode FROM promocodes AS p 
                INNER JOIN users_promocodes AS u 
                ON p.ID = u.ID_Promocode
                WHERE u.ID_User = $userID";
    $result = mysqli_query($dbLink, $query) or die ("Select error ".mysqli_error($dbLink));

    if($result){
        $promcoodes = array(); // в этот массив запишем то, что выберем из базы

        while ($row = mysqli_fetch_assoc($result)) { // оформим каждую строку результата
            // как ассоциативный массив
            $promcoodes[] = $row; // допишем строку из выборки как новый элемент результирующего массива
        }
//        var_dump(json_encode($promcoodes));  // и отдаём как json
        LogsWriteMessage("Promocodes table by userID is succesfully received");
        return json_encode($promcoodes);
    }else{
        LogsWriteMessage("Getting promocodes table is failed");
        return json_encode("Ошибка при получении информации о промкодах");
    }
}
//isUserHavePromocode(20, "dasdq");
function isUserHavePromocode($userID, $promocode){
    include "../../database/dbConnection.php";

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