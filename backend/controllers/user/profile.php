<?php

//getRatingByID($userID); //-> узнать рейтинг юзера по айди, работает как для водилы, так и для юзера
//isUserActive(66);
function isUserActive($userID){
    include "../../database/dbConnection.php";

    $isUserActive = false;

    $query = "SELECT Status AS status FROM users WHERE ID = $userID";
    $result = mysqli_query($dbLink, $query) or die ("Select error ".mysqli_error($dbLink));

    if($result){
        $status = '';

        while($row = $result -> fetch_object()){
            $status = $row -> status;
        }

        if($status == 'Active'){
            $isUserActive = true;
            LogsWriteMessage("User is active");
            return $isUserActive;
        }else{
            $isUserActive = false;
            LogsWriteMessage("User is blocked");
            return $isUserActive;
        }
    }else{
        $isUserActive = false;
        LogsWriteMessage("Database error");
        return $isUserActive;
    }
}
$object = json_encode(['ID_Order' => 73]);
//cancelOrderByUser($object);
function cancelOrderByUser($object){
    include "../../database/dbConnection.php";
    include "../../utils/logger.php";

    $object = json_decode($object, true);
    $orderID = $object['ID_Order'];

    $query = "UPDATE orders SET Status = 'Отменена пользователем' 
                WHERE ID = $orderID AND Status = 'Ожидание посадки'";
    $result = mysqli_query($dbLink, $query) or die ("Select error ".mysqli_error($dbLink));

    if($result){
        $query = "DELETE FROM orders_passengerseats WHERE ID_Order = $orderID";
        $result = mysqli_query($dbLink, $query) or die ("Select error ".mysqli_error($dbLink));
        if($result){
            LogsWriteMessage("Trip is cancelled");
        }else{
            LogsWriteMessage("db error");
        }
    }else{
        LogsWriteMessage("Error database");
    }
}

//редактирование
$object = json_encode(['ID_User' => 49, 'PhoneNumber' => '+375447432624', 'OldPassword' => '7182470Dima',
    'NewPassword' => '1234123Diana', 'PasswordConfirm' => '1234123Diana', 'NewSurname' => 'Skoromnikova',
    'NewName' => 'Diana', 'NewPatronymic' => 'Igorevna']);
//updatePhoneNumber($object);
function updatePhoneNumber($object){
    include "../../database/dbConnection.php";
    include "../../utils/logger.php";

    $object = json_decode($object, true);
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

//updatePassword($object);
function updatePassword($object){
    include "../../database/dbConnection.php";
    include "../../utils/logger.php";

    $object = json_decode($object, true);
    $regPassword = "/^[%?^#$]?(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{6,}/";//* любое число раз подряд или отсутствовать
    $oldPassword = $object['OldPassword'];
    $newPassword = $object['NewPassword'];
    $passwordConfirm = $object['PasswordConfirm'];
    $phoneNumber = $object['PhoneNumber'];

    if(!empty($object)){
        $resultRow = getUserByPhoneNumber($phoneNumber);
        $userID = $resultRow["ID"];

        if(!empty($userID)){
            if($resultRow["Status"] == 'Active'){
                if($resultRow['Password'] == md5($oldPassword).$salt){
                    if($newPassword == $passwordConfirm){
                        if(preg_match($regPassword, $newPassword)){
                            $passwordHash = md5($newPassword).$salt;

                            $query = "UPDATE users SET Password = '$passwordHash'
                                        WHERE ID = $userID";
                            $result = mysqli_query($dbLink, $query) or die ("Select error" . mysqli_error($dbLink));

                            if($result){
                                LogsWriteMessage("Your password has been changed");
                                return json_encode("Ваш пароль изменен");
                            }else{
                                LogsWriteMessage("DB error with updating password");
                                return json_encode("Ошибка БД при обновлении пароля");
                            }
                        }else{
                            LogsWriteMessage("Registration user: the password must consist of more than 6
                                characters of the English alphabet (one uppercase, numbers and lowercase letters is required) Example: \"1234Te\"");
                            return json_encode("пароль должен состоять более чем из 6-ти
                                символов английского алфавита(обязательно одна заглавная, цифры и строчные буквы) Пример: \"1234Te\"");
                        }
                    }else{
                        LogsWriteMessage("not equal passwords");
                        return json_encode("Пароли не совпадают");
                    }
                }else{
                    LogsWriteMessage("incorrect password");
                    return json_encode('Неправильный пароль');
                }
            }else{
                LogsWriteMessage("user blocked he can't update password");
                return json_encode('Вы заблокировани и не можете сменить пароль');
            }
        }else{
            LogsWriteMessage("Authorization: user not found (database error)");
            return json_encode("Не найден пользователь(ошибка базы данных)");
        }
    }else{
        LogsWriteMessage("Enter the data to update password");
        return json_encode("введите данные");
    }
}

//updateSurname($object);
function updateSurname($object){
    include "../../database/dbConnection.php";
    include "../../utils/logger.php";

    $object = json_decode($object, true);
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

//updateName($object);
function updateName($object){
    include "../../database/dbConnection.php";
    include "../../utils/logger.php";

    $object = json_decode($object, true);
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

//updatePatronymic($object);
function updatePatronymic($object){
    include "../../database/dbConnection.php";
    include "../../utils/logger.php";

    $object = json_decode($object, true);
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

function getPhoneNumber($phoneNumber){
    include "../../database/dbConnection.php";

    $query = "SELECT PhoneNumber FROM users WHERE PhoneNumber = '$phoneNumber'";
    $result = mysqli_query($dbLink, $query) or die ("Select error" . mysqli_error($dbLink));

    if($result){
        $resultPhoneNumberRow = mysqli_fetch_row($result);

        LogsWriteMessage("Getting matches phone number from database with $phoneNumber");
        return $resultPhoneNumberRow;
    }else{
        LogsWriteMessage("DB error from getting phone number");
        return json_encode("ошибка БД");
    }
}

function getUserByPhoneNumber($phoneNumber){
    include "../../database/dbConnection.php";

    $query = "SELECT * FROM users WHERE PhoneNumber = '$phoneNumber'";
    $result = mysqli_query($dbLink, $query) or die ("Database error");

    if($result){
        $resultRow = mysqli_fetch_assoc($result);

        LogsWriteMessage("Getting information about user by phone number $phoneNumber");
        return $resultRow;
    }else{
        LogsWriteMessage("DB error from getting user by $phoneNumber");
        return json_encode("ошибка БД $phoneNumber");
    }
}