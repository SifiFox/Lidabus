<?php

function getPromocodeID($promocode){
    include "../../database/dbConnection.php";

    $query = "SELECT ID AS ID FROM promocodes WHERE Promocode = '$promocode'";
    $result = mysqli_query($dbLink, $query) or die ("Select error ".mysqli_error($dbLink));

    if($result){
        $promocodeID = 0;

        while($row = $result -> fetch_object()){
            $promocodeID = $row -> ID;
        }

        LogsWriteMessage("Promocode ID is succesfully received");
        return $promocodeID;
    }else{
        LogsWriteMessage("Error while getting information about promo code ID");
        return 0;
    }
}

function getPromocodeSale($promocode){
    include "../../database/dbConnection.php";

    $query = "SELECT Sale FROM promocodes WHERE Promocode = '$promocode'";
    $result = mysqli_query($dbLink, $query) or die ("Select error ".mysqli_error($dbLink));

    if($result){
        $promocodeSale = 0;

        while($row = $result -> fetch_object()){
            $promocodeSale = $row;
        }

//        print_r(json_encode($promocodeSale));
        LogsWriteMessage("Promocode sale is succesfully received");
        return $promocodeSale;
    }else{
        LogsWriteMessage("Error while getting information about sale ID");
        return 0;
    }
}