<?php

header("Access-Control-Allow-Origin: http://localhost:3000");

$object = json_decode($_POST['updateUser'], true);
update($object);

function update($object){
    include "../../database/dbConnection.php";
    include "../../utils/logger.php";

    $userDataFromDB = getUserByIDInUpdate($object["ID"]);
    $newUserData = null;

    if($object["PhoneNumber"] != $userDataFromDB["PhoneNumber"]){
        $newUserData = updatePhoneNumber($object);
    }
    if($object["Surname"] != $userDataFromDB["Surname"]){
        $newUserData = json_encode($newUserData);
    }
    if($object["Name"] != $userDataFromDB["Name"]){
        $newUserData = updateName($object);
    }
    if($object["Patronymic"] != $userDataFromDB["Patronymic"]){
        $newUserData = updatePatronymic($object);
    }

    print_r(json_encode($newUserData));
}

function updatePhoneNumber($object){
    include "../../database/dbConnection.php";
    include "get.php";

    $userID = $object['ID'];
    $newPhoneNumber = $object['PhoneNumber'];

    if(empty(getPhoneNumber($newPhoneNumber)[0])){
        $query = "UPDATE users SET PhoneNumber = '$newPhoneNumber'
                WHERE ID = $userID";
        $result = mysqli_query($dbLink, $query) or die ("Select error" . mysqli_error($dbLink));

        if($result){
            LogsWriteMessage("Your phone number has been changed to $newPhoneNumber");

            $clinet = getUserByID($object['ID']);

//            print_r(json_encode($clinet));
            return $clinet;
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
    include "../../database/dbConnection.php";

    $newSurname = $object['Surname'];
    $phoneNumber = $object['PhoneNumber'];

    if(!empty($object)){
        $query = "UPDATE users SET Surname = '$newSurname'
                    WHERE PhoneNumber = '$phoneNumber'";
        $result = mysqli_query($dbLink, $query) or die ("Select error " . mysqli_error($dbLink));

        if($result){
            LogsWriteMessage("Your surname has been changed");

            $clinet = getUserByID($object['ID']);

//            print_r(json_encode($clinet));
            return $clinet;
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
    include "../../database/dbConnection.php";

    $newName = $object['Name'];
    $phoneNumber = $object['PhoneNumber'];

    if(!empty($object)){
        $query = "UPDATE users SET Name = '$newName'
                    WHERE PhoneNumber = '$phoneNumber'";
        $result = mysqli_query($dbLink, $query) or die ("Select error " . mysqli_error($dbLink));

        if($result){
            LogsWriteMessage("Your name has been changed");

            $clinet = getUserByID($object['ID']);

//            print_r(json_encode($clinet));
            return $clinet;
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
    include "../../database/dbConnection.php";

    $newPatronymic = $object['Patronymic'];
    $phoneNumber = $object['PhoneNumber'];

    if(!empty($object)){
        $query = "UPDATE users SET Patronymic = '$newPatronymic'
                    WHERE PhoneNumber = '$phoneNumber'";
        $result = mysqli_query($dbLink, $query) or die ("Select error " . mysqli_error($dbLink));

        if($result){
            LogsWriteMessage("Your patronymic has been changed");

            $clinet = getUserByID($object['ID']);

//            print_r(json_encode($clinet));
            return $clinet;
        }else{
            LogsWriteMessage("DB error with updating patronymic");
            return json_encode("Ошибка БД при обновлении отчества");
        }
    }else{
        LogsWriteMessage("Enter the data to update password");
        return json_encode("введите данные");
    }
}

function getUserByIDInUpdate($userID){
    include "../../database/dbConnection.php";

    $query = "SELECT u.ID, u.PhoneNumber, u.Surname, u.Name, 
                    u.Patronymic, u.Patronymic, u.Role, u.Status, r.Rating 
                    FROM users u
                INNER JOIN rating r ON r.ID = u.ID_Rating
                WHERE Role = 'User'
                AND u.ID = $userID";
    $result = mysqli_query($dbLink, $query) or die ("Database error");

    if($result){
        $resultRow = mysqli_fetch_assoc($result);
//        print_r(json_encode($resultRow));
        LogsWriteMessage("Getting information about user by id $userID");
        return $resultRow;
    }else{
        LogsWriteMessage("DB error from getting by id $userID");
        return json_encode("ошибка БД");
    }
}