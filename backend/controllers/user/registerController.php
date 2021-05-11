<?php


//    header("Access-Control-Allow-Origin: *");

//    $register = json_decode(file_get_contents('php://input'), true);
$client = ['PhoneNumber' => '+375257182477', 'Password' => '7182470Dima', 'PasswordConfirm' => '7182470Dima',
    'Name' => 'Dzmitry', 'Surname' => 'Ramantsevich', 'Patronymic' => 'Andreevich'];

$client = json_encode($client);

//    registerUser($client);

function registerUser($client){
    include "../../database/dbConnection.php";
    include "../../utils/logger.php";

    $client = json_decode($client, true);

    if (!empty($client)) {
        $regPassword = "/^[%?^#$]?(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{6,}/";//* любое число раз подряд или отсутствовать
        $errorsArray = array();
        $password = $client["Password"];
        $passwordConfirm = $client["PasswordConfirm"];

        if ($password == $passwordConfirm && $password != null) {
            if (preg_match($regPassword, $password)) {
                $phoneNumber = $client["PhoneNumber"];
                $query = "SELECT PhoneNumber FROM users WHERE PhoneNumber = '$phoneNumber'";
                $result = mysqli_query($dbLink, $query) or die ("Select error" . mysqli_error($dbLink));

                $resultPhoneNumberRow = mysqli_fetch_row($result);

                if (empty($resultPhoneNumberRow[0])) {
                    if (empty($errorsArray)) {
                        $name = $client["Name"];
                        $surname = $client["Surname"];
                        $patronymic = $client["Patronymic"];
                        $passwordHash = md5($password).$salt;

                        $query = "INSERT INTO users(PhoneNumber, Password, Surname, Name, Patronymic) VALUES ( '$phoneNumber', '$passwordHash', '$surname', '$name', '$patronymic')";
                        $result = mysqli_query($dbLink, $query) or die ("Select error" . mysqli_error($dbLink));

                        LogsWriteMessage("User ".$client["Name"]." ".$client["Surname"]." register");

                        return json_encode($client);
                    } else {
                        array_push($errorsArray, "Ошибка базы данных");
                        LogsWriteMessage("Registration user: error in data base request");

                        return json_encode($errorsArray);
                    }
                } else {
                    array_push($errorsArray, "данный номер телефона уже зарегистирован, попробуйте другой");
                    LogsWriteMessage("Registration user: this phone number is registred, try another");

                    return json_encode($errorsArray);
                }
            }else{
                array_push($errorsArray, "пароль должен состоять более чем из 6-ти 
                символов английского алфавита(обязательно одна заглавная, цифры и строчные буквы) Пример: \"1234Te\"");
                LogsWriteMessage("Registration user: the password must consist of more than 6 
                characters of the English alphabet (one uppercase, numbers and lowercase letters is required) Example: \"1234Te\"");

                return json_encode($errorsArray);
            }
        } else {
            array_push($errorsArray, "Пароли не совпадают");
            LogsWriteMessage("Registration user: not equal passwords");

            return json_encode($errorsArray);
        }
    }else {
        array_push($errorsArray, "Ошибка передачи данных");
        LogsWriteMessage("Registration user: JSON object is empty");

        return json_encode($errorsArray);
    }
}