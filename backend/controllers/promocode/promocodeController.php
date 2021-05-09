<?php
//function setPromocode(){
//    include "../../database/dbConnection.php";
//    include "../../utils/logger.php";
//
//    $promocode = $_POST["Promocode"];
//
//    $query = "SELECT Promocode FROM promocodes WHERE Promocode = '$promocode'";
//    $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));
//
//    if($result){
//        $row = mysqli_fetch_row($result);
//
//        if(!empty($row[0])){
//            if(isset($promocode)){
//                $query = "DELETE FROM promocodes WHERE Promocode = '$promocode'";
//
//                mysqli_query($dbLink, $query) or die ("DB error").mysqli_error($dbLink);
//
//                $message = "Promocode accepted";
//
//                LogsUserSetPromocodeAccepted();
//            }
//            else{
//                $message = "Promocode not exist";
//
//                LogsUserSetPromocodeFailed();
//            }
//        }else{
//            $message = "Promocode not exist";
//
//            LogsUserSetPromocodeFailed();
//        }
//    }else{
//        $message = "Promocode not exist";
//
//        LogsUserSetPromocodeFailed();
//    }
//
//    echo $message;
//}
//createPromocode(19);
//
//function createPromocode($userID){
//    include "../../database/dbConnection.php";
////    include "../../utils/logger.php";
//    include "../order/orderController.php";
//
//    if(count(json_decode(getOrdersByUserID($userID))) % 10 == 0){
//        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
//        $promocode = substr(str_shuffle($permitted_chars), 0, 6);
//
//        $query = "SELECT Promocode FROM promocodes WHERE Promocode = '$promocode'";
//        $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));
//
//        if($result){
//            $row = mysqli_fetch_row($result);
//
//            if(empty($row[0])){
//                $query = "INSERT INTO promocodes(Promocode) VALUES ('$promocode')";
//                $result = mysqli_query($dbLink, $query) or die ("Insert error".mysqli_error($dbLink));
//
//                if($result){
//                    $query = "SELECT ID FROM promocodes WHERE Promocode = '$promocode'";
//                    $result = mysqli_query($dbLink, $query) or die ("Insert error".mysqli_error($dbLink));
//
//                    if($result){
//                        $row = mysqli_fetch_row($result);
//
//                        $query = "INSERT INTO users(ID_Promocode) VALUES ($row) WHERE ID = $userID";
//                        $result = mysqli_query($dbLink, $query) or die ("Insert error".mysqli_error($dbLink));
//
//                        if($result){
//                            echo "промокод ".$promocode." успешно добавлен";
//                        }else{
//                            echo "ошибка БД при привязке промокода юзеру";
//                        }
//                    }else{
//                        echo "Ошибка БД при выборке промокода";
//                    }
//                }else{
//                    echo "Ошибка БД при внесении созданного промокода";
//                }
//            }else{
//                echo "Данный промокд уже существует";
//            }
//        }else{
//            echo "Ошибка БД при выборке промокода(существует ли такой промокод)";
//        }
//    }else{
//        echo "вы не совершили 10 поездок, чтобы получить промокод совершите еще ".(10 - count(json_decode(getOrdersByUserID($userID))))." поездок";
//    }
//}

//getPromocodeSale("ADMIN");

function getPromocodeSale($promocode){
    include "../../database/dbConnection.php";
    include "../../utils/logger.php";

    $query = "SELECT Sale FROM promocodes WHERE Promocode = '$promocode'";
    $result = mysqli_query($dbLink, $query) or die ("Select error ".mysqli_error($dbLink));

    if($result){
        $promocodeSale = 0;

        while($row = $result -> fetch_object()){
            $promocodeSale = $row;
        }

//        var_dump($promocodeSale);
        return $promocodeSale;
    }else{
        echo "Ошибка при получении информации о скидке промокода";
        return 0;
    }
}
//getPromocodeTableByUser(20);
function getPromocodeTableByUser($userID){
    include "../../database/dbConnection.php";
//    include "../../utils/logger.php";

    $query = "SELECT p.Promocode FROM promocodes AS p 
                INNER JOIN users AS u 
                ON p.ID = u.ID_Promocode
                WHERE u.ID = $userID";
    $result = mysqli_query($dbLink, $query) or die ("Select error ".mysqli_error($dbLink));

    if($result){
        $data = array(); // в этот массив запишем то, что выберем из базы

        while($row = mysqli_fetch_assoc($result)){ // оформим каждую строку результата
            // как ассоциативный массив
            $data[] = $row; // допишем строку из выборки как новый элемент результирующего массива
        }
//        LogsWriteMessage("Getting promocodes table is success");

        var_dump($data); // и отдаём как json
        return $data;
    }else{
//        LogsWriteMessage("Getting promocodes table is failed");

        return json_encode("Ошибка при получении информации о промкодах");
    }
}