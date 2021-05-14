<?php

function getUserByID($userID){
    include "../../database/dbConnection.php";

    $query = "SELECT * FROM users WHERE ID = $userID";
    $result = mysqli_query($dbLink, $query) or die ("Database error");

    if($result){
        $resultRow = mysqli_fetch_assoc($result);

        LogsWriteMessage("Getting information about user by phone number $phoneNumber");
        return $resultRow;
    }else{
        LogsWriteMessage("DB error from getting user by $phoneNumber");
        return json_encode("ошибка БД $phoneNumber");
    }
}

function getPhoneNumber($phoneNumber){
    include "../../database/dbConnection.php";

    $query = "SELECT PhoneNumber FROM users WHERE PhoneNumber = '$phoneNumber'";
    $result = mysqli_query($dbLink, $query) or die ("Select error" . mysqli_error($dbLink));

    if($result){
        $resultPhoneNumberRow = mysqli_fetch_row($result);

        LogsWriteMessage("Getting matches phone number from database with $phoneNumber");
        return $resultPhoneNumberRow;
    }else{
        LogsWriteMessage("DB error from getting phone number");
        return json_encode("ошибка БД");
    }
}

function getUserByPhoneNumber($phoneNumber){
    include "../../database/dbConnection.php";

    $query = "SELECT * FROM users WHERE PhoneNumber = '$phoneNumber'";
    $result = mysqli_query($dbLink, $query) or die ("Database error");

    if($result){
        $resultRow = mysqli_fetch_assoc($result);

        LogsWriteMessage("Getting information about user by phone number $phoneNumber");
        return $resultRow;
    }else{
        LogsWriteMessage("DB error from getting user by $phoneNumber");
        return json_encode("ошибка БД $phoneNumber");
    }
}