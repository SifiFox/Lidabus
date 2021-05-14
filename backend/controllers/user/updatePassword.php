<?php
//updatePassword($object);
function updatePassword($object){
    include "../../database/dbConnection.php";
    include "profile.php";
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
