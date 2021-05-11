<?php
// при нажатии на кнопку с фронты передается объект json ['Status' => 'Active/Block']

$promocode = json_encode(['Sale' => 10, 'Count' => 5]);
//создать промокод на 10%(мб акции какие будут)
//createPromocode($promocode);
function createPromocode($promocode){
    include "../../database/dbConnection.php";
    include "../../utils/logger.php";

    $promocode = json_decode($promocode, true);
    $sale = intval($promocode['Sale'])/100;
    $count = intval($promocode['Count']);

    for($i = 0; $i < $count; $i++){
        $promocode = createStringForPromocode();

        $query = "SELECT Promocode FROM promocodes WHERE Promocode = '$promocode'";
        $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));

        if($result){
            $row = mysqli_fetch_row($result);

            if(empty($row[0])){//такого промокода нет - заносим в таблицу
                $query = "INSERT INTO promocodes(Promocode, Sale) VALUES('$promocode', $sale)";
                $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));

                LogsWriteMessage("Promocode $promocode with sale".($sale*100)."% created");
            }else{//такой промокод есть - создаем заново
                $promocode = createStringForPromocode();

                $query = "INSERT INTO promocodes(Promocode, Sale) VALUES('$promocode', $sale)";
                $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));

                LogsWriteMessage("Promocode $promocode with sale".($sale*100)."% created");
            }
        }
    }
}

function getIDCreatedPromocode(){
    include "../../database/dbConnection.php";
    include "../../utils/logger.php";

    $sale = 1;
    $promocode = createStringForPromocode();

    $query = "SELECT Promocode FROM promocodes WHERE Promocode = '$promocode'";
    $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));

    if($result){
        $row = mysqli_fetch_row($result);

        if(empty($row[0])){//такого промокода нет - заносим в таблицу
            $query = "INSERT INTO promocodes(Promocode, Sale) VALUES('$promocode', $sale)";
            $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));

            if($result){
                $query = "SELECT @@IDENTITY";
                $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));
                $row = $result->fetch_row();
                $value = $row[0] ?? false;

                LogsWriteMessage("Promocode $promocode with sale".($sale*100)."% created");

                return $value;
            }else{
                LogsWriteMessage("Error database");
                return "db error";
            }
        }else{//такой промокод есть - создаем заново
            $promocode = createStringForPromocode();

            $query = "INSERT INTO promocodes(Promocode, Sale) VALUES('$promocode', $sale)";
            $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));

            if($result){
                $query = "SELECT @@IDENTITY";
                $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));
                $row = $result->fetch_row();
                $value = $row[0] ?? false;

                LogsWriteMessage("Promocode $promocode with sale".($sale*100)."% created");

                return $value;
            }else{
                LogsWriteMessage("Error database");
                return "db error";
            }
        }
    }else{
        LogsWriteMessage("Error database");
        return null;
    }
}

function createStringForPromocode(){
    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $createPromocode = substr(str_shuffle($permitted_chars), 0, 6);

    return $createPromocode;
}

//назначить промокод
$assignPromocode = json_encode(['ID_User' => 20, 'ID_Promocode' => 18]);
//assignPromocodeToUser($assignPromocode);
function assignPromocodeToUser($assignPromocode){//табличка промокодов(промокд и скидка), табличка юзеров(айди юзера и имя)
    include "../../database/dbConnection.php";
    include "../../utils/logger.php";

    $assignPromocode = json_decode($assignPromocode, true);
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
//            echo "промокод назначен";
            LogsWriteMessage("Promocode assigned");
            return json_encode("Промокод назначен");
        }else{//промокод уже назначен - назначить другому юзеру
//            echo "Данный промокд уже назначен юзеру, назначьте другой";
            LogsWriteMessage("This promocode has already been assigned to the user, assign a different one");
            return json_encode("Данный промокд уже назначен юзеру, назначьте другой");
        }
    }else{
//        echo "ошибка селекта БД";
        LogsWriteMessage("Error database");
        return json_encode("ошибка селекта БД");
    }
}