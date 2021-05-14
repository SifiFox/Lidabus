<?php

//getRatingByID($userID); //-> узнать рейтинг юзера по айди, работает как для водилы, так и для юзера
//isUserActive(66);
function isUserActive($userID){
    include "../../database/dbConnection.php";

    $isUserActive = false;

    $query = "SELECT Status AS status FROM users WHERE ID = $userID";
    $result = mysqli_query($dbLink, $query) or die ("Select error ".mysqli_error($dbLink));

    if($result){
        $status = '';

        while($row = $result -> fetch_object()){
            $status = $row -> status;
        }

        if($status == 'Active'){
            $isUserActive = true;
            LogsWriteMessage("User is active");
            return $isUserActive;
        }else{
            $isUserActive = false;
            LogsWriteMessage("User is blocked");
            return $isUserActive;
        }
    }else{
        $isUserActive = false;
        LogsWriteMessage("Database error");
        return $isUserActive;
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