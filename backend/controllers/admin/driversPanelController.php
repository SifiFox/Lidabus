<?php
getDriversTable();

$driver = json_encode(['PhoneNumber' => '+315422483654', 'Password' => '7182470Dima', 'PasswordConfirm' => '7182470Dima', 'Name' => 'Driver', 'Surname' => 'Driver', 'Patronymic' => 'Driver']);

createDriver($driver);

function getDriversTable(){
    include "../../database/dbConnection.php";
    include "../../utils/logger.php";

    $query = "SELECT * FROM users WHERE Role = 'Driver' ORDER BY ID";
    $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));

    if($result){
        $data = array(); // в этот массив запишем то, что выберем из базы

        while($row = mysqli_fetch_assoc($result)){ // оформим каждую строку результата
            // как ассоциативный массив
            $data[] = $row; // допишем строку из выборки как новый элемент результирующего массива
        }

        LogsWriteMessage("Getting drivers from user table is success");

        echo json_encode($data); // и отдаём как json
        return json_encode($data);
    }else{
        LogsWriteMessage("Getting driver from user table is failed");

        return json_encode("Ошибка при получении информации о водителях");
    }
}

function createDriver($driver){
    include "../../database/dbConnection.php";
    include "../../utils/logger.php";

    $driver = json_decode($driver, true);
    $regPassword = "/^[%?^#$]?(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{6,}/";//* любое число раз подряд или отсутствовать
    $errorsArray = array();

    if (!empty($driver)) {
        if ($driver["Password"] == $driver["PasswordConfirm"] && $driver["Password"] != null) {
            if (preg_match($regPassword, $driver["Password"])) {
                $phoneNumber = $driver["PhoneNumber"];
                $query = "SELECT PhoneNumber FROM users WHERE PhoneNumber = '$phoneNumber'";
                $result = mysqli_query($dbLink, $query) or die ("Select error" . mysqli_error($dbLink));

                $resultPhoneNumberRow = mysqli_fetch_row($result);

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

                        LogsWriteMessage("driver ".$driver['Surname']." ".$driver['Name']." registred");

                        return json_encode($driver);
                    } else {
                        array_push($errorsArray, "ошибка базы данных");
                        LogsRegFailed("error in data base request");

                        return json_encode($errorsArray);
                    }
                } else {
                    array_push($errorsArray, "данный номер телефона уже зарегистирован, попробуйте другой");
                    LogsRegFailed("This phone number is registered");

                    return json_encode($errorsArray);
                }
            }else{
                array_push($errorsArray, "пароль должен состоять более чем из 6-ти символов английского алфавита(обязательно одна заглавная, цифры и строчные буквы) Пример: \"1234Te\"");
                LogsRegFailed("the password must consist of more than 6 characters of the English alphabet (one uppercase, numbers and lowercase letters is required) Example: \"1234Te\"");

                return json_encode($errorsArray);
            }
        }else{
            array_push($errorsArray, "не одинаковые пароли");
            LogsRegFailed("Not equal passwords");

            return json_encode($errorsArray);
        }
    }else{
        array_push($errorsArray, "ошибка передачи данных");
        LogsRegFailed("JSON object is empty");

        return json_encode($errorsArray);
    }
}

