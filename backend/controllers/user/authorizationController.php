<?php

header("Access-Control-Allow-Origin: http://localhost:3000");

//$authUser = json_encode(['PhoneNumber' => 'ADMIN', 'Password' => 'ADMIN']);
//$authUser = json_decode($authUser, true);

$authUser = json_decode($_GET['auth'], true);
authorizationUser($authUser);

function authorizationUser($authUser){
    include "../../database/dbConnection.php";
    include "../../utils/logger.php";
    include "get.php";
    include "../rating/get.php";

    $errorsArray = array();

    if(!empty($authUser)){
        $phoneNumber = $authUser["PhoneNumber"];
        $password = $authUser["Password"];

        $resultRow = getUserByPhoneNumber($phoneNumber);
        if(!empty($resultRow["ID"])){
            if($resultRow["PhoneNumber"] == $phoneNumber){
                if($resultRow["Password"] == md5($password).$salt){
                    if($resultRow["Status"] == "Active"){
                        $resultRow['Rating'] = getRatingByID($resultRow["ID"]);

                        print_r(json_encode($resultRow));

                        LogsWriteMessage("User ".$resultRow["Name"]." ".$resultRow["Surname"]." is login");
                        return json_encode($resultRow);
                    }else{
                        array_push($errorsArray, 'Вы заблокированы');
                        LogsWriteMessage("Authorization: you are blocked");
                        return json_encode($errorsArray);
                    }
                }else{
                    array_push($errorsArray, 'Неправильный пароль');
                    LogsWriteMessage("Authorization: incorrect password");
                    return json_encode($errorsArray);
                }
            }else{
                array_push($errorsArray, "Неправильный номер телефона");
                LogsWriteMessage("Authorization: incorrect phone number");
                return json_encode($errorsArray);
            }
        }else{
            array_push($errorsArray, "Не найден пользователь(ошибка базы данных)");
            LogsWriteMessage("Authorization: user not found (database error)");
            return json_encode($errorsArray);
        }
    }else{
        array_push($errorsArray, "введите данные");
        LogsWriteMessage("Authorization: enter the data");
        return json_encode($errorsArray);
    }
}