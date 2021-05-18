<?php
include "../../database/dbConnection.php";
include "../../utils/logger.php";
include "../user/get.php";
include "get.php";

header("Access-Control-Allow-Origin: http://localhost:3000");

$object = json_decode($_POST['updateUser'], true);
update($object);

function update($object){
    $userDataFromDB = getUserByID($object["ID"]);

    if($object["NewPhoneNumber"] != $userDataFromDB["PhoneNumber"]){
        updatePhoneNumber($object["NewPhoneNumber"]);
    }
    if($object["NewSurname"] != $userDataFromDB["Surname"]){
        updateSurname($object["NewSurname"]);
    }
    if($object["NewName"] != $userDataFromDB["Name"]){
        updateName($object["NewName"]);
    }
    if($object["NewPatronymic"] != $userDataFromDB["Patronymic"]){
        updatePatronymic($object["NewPatronymic"]);
    }

    $clinet = getUserByID($object['ID']);

    print_r(json_encode($clinet));
    return json_encode($clinet);
}

function updatePhoneNumber($object){
    $userID = $object['ID_User'];
    $newPhoneNumber = $object['PhoneNumber'];

    if(empty(getPhoneNumber($newPhoneNumber)[0])){
        $query = "UPDATE users SET PhoneNumber = '$newPhoneNumber'
                WHERE ID = $userID";
        $result = mysqli_query($dbLink, $query) or die ("Select error" . mysqli_error($dbLink));

        if($result){
            LogsWriteMessage("Your phone number has been changed to $newPhoneNumber");
            return json_encode("Ваш номер телефона изменен на $newPhoneNumber");
        }else{
            LogsWriteMessage("DB error with updating phone number");
            return json_encode("Ошибка БД при обновлении номера телефона");
        }
    }else{
        LogsWriteMessage("this phone number is registred, try another");
        return json_encode("данный номер телефона уже зарегистирован, попробуйте другой");
    }
}

function updateSurname($object){
    $newSurname = $object['NewSurname'];
    $phoneNumber = $object['PhoneNumber'];

    if(!empty($object)){
        $query = "UPDATE users SET Surname = '$newSurname'
                    WHERE PhoneNumber = '$phoneNumber'";
        $result = mysqli_query($dbLink, $query) or die ("Select error " . mysqli_error($dbLink));

        if($result){
            LogsWriteMessage("Your surname has been changed");
            return json_encode("Ваша фамилия изменена");
        }else{
            LogsWriteMessage("DB error with updating surname");
            return json_encode("Ошибка БД при обновлении фамилии");
        }
    }else{
        LogsWriteMessage("Enter the data to update password");
        return json_encode("введите данные");
    }
}

function updateName($object){
    $newName = $object['NewName'];
    $phoneNumber = $object['PhoneNumber'];

    if(!empty($object)){
        $query = "UPDATE users SET Name = '$newName'
                    WHERE PhoneNumber = '$phoneNumber'";
        $result = mysqli_query($dbLink, $query) or die ("Select error " . mysqli_error($dbLink));

        if($result){
            LogsWriteMessage("Your name has been changed");
            return json_encode("Ваше имя изменено");
        }else{
            LogsWriteMessage("DB error with updating name");
            return json_encode("Ошибка БД при обновлении имени");
        }
    }else{
        LogsWriteMessage("Enter the data to update password");
        return json_encode("введите данные");
    }
}

function updatePatronymic($object){
    $newPatronymic = $object['NewPatronymic'];
    $phoneNumber = $object['PhoneNumber'];

    if(!empty($object)){
        $query = "UPDATE users SET Patronymic = '$newPatronymic'
                    WHERE PhoneNumber = '$phoneNumber'";
        $result = mysqli_query($dbLink, $query) or die ("Select error " . mysqli_error($dbLink));

        if($result){
            LogsWriteMessage("Your patronymic has been changed");
            return json_encode("Ваше отчество изменено");
        }else{
            LogsWriteMessage("DB error with updating patronymic");
            return json_encode("Ошибка БД при обновлении отчества");
        }
    }else{
        LogsWriteMessage("Enter the data to update password");
        return json_encode("введите данные");
    }
}