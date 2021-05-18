<?php

require_once "../../database/dbConnection.php";

function getUserByID($userID){
    $query = "SELECT u.ID, u.PhoneNumber, u.Surname, u.Name, 
                    u.Patronymic, u.Patronymic, u.Role, u.Status, r.Rating 
                    FROM users u
                INNER JOIN rating r ON r.ID = u.ID_Rating
                WHERE Role = 'User'
                AND u.ID = $userID";
    $result = mysqli_query($dbLink, $query) or die ("Database error");

    if($result){
        $resultRow = mysqli_fetch_assoc($result);
        print_r(json_encode($resultRow));
        LogsWriteMessage("Getting information about user by id $userID");
        return $resultRow;
    }else{
        LogsWriteMessage("DB error from getting by id $userID");
        return json_encode("ошибка БД");
    }
}

function getPhoneNumber($phoneNumber){
    $query = "SELECT PhoneNumber FROM users WHERE PhoneNumber = '$phoneNumber'";
    $result = mysqli_query($dbLink, $query) or die ("Select error" . mysqli_error($dbLink));

    if($result){
        $resultPhoneNumberRow = mysqli_fetch_row($result);
        print_r(json_encode($resultPhoneNumberRow));
        LogsWriteMessage("Getting matches phone number from database with $phoneNumber");
        return $resultPhoneNumberRow;
    }else{
        LogsWriteMessage("DB error from getting phone number");
        return json_encode("ошибка БД");
    }
}

function getUserByPhoneNumber($phoneNumber){
    $query = "SELECT * FROM users WHERE PhoneNumber = '$phoneNumber'";
    $result = mysqli_query($dbLink, $query) or die ("Database error");

    if($result){
        $resultRow = mysqli_fetch_assoc($result);
        print_r(json_encode($resultRow));
        LogsWriteMessage("Getting information about user by phone number $phoneNumber");
        return $resultRow;
    }else{
        LogsWriteMessage("DB error from getting user by $phoneNumber");
        return json_encode("ошибка БД $phoneNumber");
    }
}