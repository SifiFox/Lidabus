<?php
function createPromocode(){
    include "../../database/dbConnection.php";
    include "../../utils/logger.php";

    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $promocode = substr(str_shuffle($permitted_chars), 0, 6);

    $query = "SELECT Promocode FROM promocodes WHERE Promocode = '$promocode'";
    $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));

    if($result){
        $row = mysqli_fetch_row($result);

        if(!Empty($row[0])){
            $message = "This promocode is contains, try another";
            LogsPromocodeFailed();
        }
    }

    if(empty($message)){
        $query = "INSERT INTO promocodes(Promocode) VALUES ('$promocode')";

        $result = mysqli_query($dbLink, $query) or die ("Insert error".mysqli_error($dbLink));

        LogsPromocodeAccepted();
    }

    echo $message;
}