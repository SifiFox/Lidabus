<?php
//$driver = json_encode(['PhoneNumber' => '+375212132450', 'Password' => '7182470Dima', 'PasswordConfirm' => '7182470Dima', 'Name' => 'Driver', 'Surname' => 'Driver', 'Patronymic' => 'Driver']);

header("Access-Control-Allow-Origin: http://localhost:3000");

$object = json_decode($_POST['createDriver'], true);

createDriver($object);

function createDriver($driver){
    include "../../../database/dbConnection.php";
    include "../../rating/rating.php";
    include "../../user/get.php";
    include "../../../utils/logger.php";

    $regPassword = "/^[%?^#$]?(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{6,}/";//* любое число раз подряд или отсутствовать
    $errorsArray = array();
    $phoneNumber = $driver["PhoneNumber"];

    if (!empty($driver)) {
        if ($driver["Password"] == $driver["PasswordConfirm"] && $driver["Password"] != null) {
            if (preg_match($regPassword, $driver["Password"])) {
                $resultPhoneNumberRow = getPhoneNumber($phoneNumber);

                if (empty($resultPhoneNumberRow[0])) {
                    if (empty($errorsArray)) {
                        $password = $driver["Password"];
                        $name = $driver["Name"];
                        $surname = $driver["Surname"];
                        $patronymic = $driver["Patronymic"];
                        $passwordHash = md5($password).$salt;
                        $role = "Driver";

                        $query = "INSERT INTO users(PhoneNumber, Password, Surname, Name, Patronymic, Role) VALUES ( '$phoneNumber', '$passwordHash', '$surname', '$name', '$patronymic', '$role')";
                        $result = mysqli_query($dbLink, $query) or die ("Select error" . mysqli_error($dbLink));

                        if($result){
                            $query = "SELECT @@IDENTITY";
                            $result = mysqli_query($dbLink, $query) or die ("Select error" . mysqli_error($dbLink));
                            $row = $result->fetch_row();
                            $driverID = $row[0] ?? false;

                            createRating($driverID);
                            setDriverToDriversAutos($driverID, 9);

                            LogsWriteMessage("driver ".$driver['Surname']." ".$driver['Name']." registred");
                            return json_encode($driver);
                        }else{
                            array_push($errorsArray, "Ошибка базы данных");
                            LogsWriteMessage("Registration user: error in data base request");

                            return json_encode($errorsArray);
                        }
                    } else {
                        array_push($errorsArray, "ошибка базы данных");
                        LogsWriteMessage("Registration driver: error in data base request");

                        return json_encode($errorsArray);
                    }
                } else {
                    array_push($errorsArray, "данный номер телефона уже зарегистирован, попробуйте другой");
                    LogsWriteMessage("Registration driver: this phone number is registered");

                    return json_encode($errorsArray);
                }
            }else{
                array_push($errorsArray, "пароль должен состоять более чем из 6-ти 
                символов английского алфавита(обязательно одна заглавная, цифры и строчные буквы) Пример: \"1234Te\"");
                LogsWriteMessage("Registration driver: the password must consist of more than 6 
                characters of the English alphabet (one uppercase, numbers and lowercase letters is required) Example: \"1234Te\"");
                return json_encode($errorsArray);
            }
        }else{
            array_push($errorsArray, "не одинаковые пароли");
            LogsWriteMessage("Registration driver: not equal password");

            return json_encode($errorsArray);
        }
    }else{
        array_push($errorsArray, "ошибка передачи данных");
        LogsWriteMessage("Registration driver: JSON object is empty");

        return json_encode($errorsArray);
    }
}

function setDriverToDriversAutos($driverID, $autoID){
    include "../../../database/dbConnection.php";

    $query = "INSERT INTO drivers_autos(ID_Driver, ID_Auto) VALUES ($driverID, $autoID)";
    $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));

    if($result){
        LogsWriteMessage("Driver setting into drivers_autos is success");
    }else{
        LogsWriteMessage("DB error to insert driver into drivers_autos table");
    }
}