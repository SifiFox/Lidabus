<?php
//getDriversTable();

$driver = json_encode(['PhoneNumber' => '+375212132450', 'Password' => '7182470Dima', 'PasswordConfirm' => '7182470Dima', 'Name' => 'Driver', 'Surname' => 'Driver', 'Patronymic' => 'Driver']);

//createDriver($driver);

function createDriver($driver){
    include "../../database/dbConnection.php";
    include "../rating/rating.php";
    include "../user/get.php";
    include "../../utils/logger.php";

    $driver = json_decode($driver, true);
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

//$object = json_encode(['ID_Driver' => n, 'ID_Auto' => n]);
function assignDriverToAuto($object){
    include "../../database/dbConnection.php";
    include "../../utils/logger.php";

    $object = json_decode($object, true);
    $driverID = $object["ID_Driver"];
    $autoID = $object["ID_Auto"];

    $query = "UPDATE drivers_autos SET ID_Auto = $autoID
                WHERE ID_Driver = $driverID";
    $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));

    if($result){
        LogsWriteMessage("Driver assigned to car");
        return json_encode("Машина назначена водителю");
    }else{
        LogsWriteMessage("DB error in assign driver to Auto");
        return json_encode("Ошибка базы данных при назначении машины водителю");
    }
}

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

//        echo json_encode($data); // и отдаём как json
        return json_encode($data);
    }else{
        LogsWriteMessage("Getting driver from user table is failed");

        return json_encode("Ошибка при получении информации о водителях");
    }
}

function setDriverToDriversAutos($driverID, $autoID){
    include "../../database/dbConnection.php";

    $query = "INSERT INTO drivers_autos(ID_Driver, ID_Auto) VALUES ($driverID, $autoID)";
    $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));

    if($result){
        LogsWriteMessage("Driver setting into drivers_autos is success");
    }else{
        LogsWriteMessage("DB error to insert driver into drivers_autos table");
    }
}
