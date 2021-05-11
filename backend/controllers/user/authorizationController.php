<?php
//header("Access-Control-Allow-Origin: http://localhost:3000");

$authUser = json_encode(['PhoneNumber' => '+375257182477', 'Password' => '7182470Dima']);

//authorizationUser($authUser);

function authorizationUser($authUser){
    include "../../database/dbConnection.php";
    include "../../utils/logger.php";

    $authUser = json_decode($authUser, true);
    $errorsArray = array();

    if(!empty($authUser)){
        $phoneNumber = $authUser["PhoneNumber"];
        $password = $authUser["Password"];

        $query = "SELECT * FROM users WHERE PhoneNumber = '$phoneNumber'";
        $result = mysqli_query($dbLink, $query) or die ("Database error");

        $resultRow = mysqli_fetch_assoc($result);
        var_dump($resultRow);

        if(!empty($resultRow["ID"])){
            if($resultRow["PhoneNumber"] == $phoneNumber){
                if($resultRow["Password"] == md5($password).$salt){
                    if($resultRow["Status"] == "Active"){
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
        array_push($errorsArray, "Такого пользователя не сущесвует");
        LogsWriteMessage("Authorization: this user is not registred");
        return json_encode($errorsArray);
    }
}