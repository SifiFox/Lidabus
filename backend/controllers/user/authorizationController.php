<?php
//header("Access-Control-Allow-Origin: http://localhost:3000");

$authUser = json_encode(['PhoneNumber' => '+375257182477', 'Password' => '7182470Dima']);

authorizationUser($authUser);

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
                        LogsLoginAccepted($resultRow);

                        return json_encode($resultRow);
                    }else{
                        array_push($errorsArray, 'Вы заблокированы');
                        LogsLoginFailed("user blocked");
                        return json_encode($errorsArray);
                    }
                }else{
                    array_push($errorsArray, 'Неправильный пароль');
                    LogsLoginFailed("incorrect password");
                    return json_encode($errorsArray);
                }
            }else{
                array_push($errorsArray, "Неправильный номер телефона");
                LogsLoginFailed("incorrect phone number");
                return json_encode($errorsArray);
            }
        }else{
            array_push($errorsArray, "Ошибка базы данных");
            LogsLoginFailed("ID is empty");
            return json_encode($errorsArray);
        }
    }else{
        array_push($errorsArray, "Такого пользователя не сущесвует");
        LogsLoginFailed("This user is not registred");
        return json_encode($errorsArray);
    }
}