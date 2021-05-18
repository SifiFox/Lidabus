<?php
require_once "../../../database/dbConnection.php";
require_once "../../../utils/logger.php";

//$promocode = json_encode(['Sale' => 10, 'Count' => 5]);
//создать промокод на 10%(мб акции какие будут)
header("Access-Control-Allow-Origin: http://localhost:3000");

$object = json_decode($_POST['createPromocode'], true);

createPromocode($object);

function createPromocode($promocode){
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

function createStringForPromocode(){
    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $createPromocode = substr(str_shuffle($permitted_chars), 0, 6);

    return $createPromocode;
}