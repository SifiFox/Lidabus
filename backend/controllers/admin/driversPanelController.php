<?php
function getDriversTable(){
    include "../../database/dbConnection.php";
    include "../../utils/logger.php";

    $query = "SELECT * FROM drivers WHERE Role = 'Driver' ORDER BY ID";
    $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));

    if($result){
        $data = array(); // в этот массив запишем то, что выберем из базы

        while($row = mysqli_fetch_assoc($result)){ // оформим каждую строку результата
            // как ассоциативный массив
            $data[] = $row; // допишем строку из выборки как новый элемент результирующего массива
        }

        logsDriversTableForAdminSuccess();

        echo json_encode($data); // и отдаём как json
    }else{
        logsDriversTableForAdminFailed();
    }
}

function createDriver(){
    include "../../database/dbConnection.php";
    include "../../utils/logger.php";

    $salt = md5(1231);//так называемся соль для добавления защиты хэширования паролей
    $data = $_POST;

    if(!empty($data)){
        session_start();
        $regPassword = "/^[%?^#$]?(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{6,}/";//* любое число раз подряд или отсутствовать
        $errorsArray = array();

        if($data["password"] == $data["passwordConfirm"] && $data["password"] != null){
            if(preg_match($regPassword, $data["password"])){ }
            else{
                array_push($errorsArray, "Password error");
                LogsDriverRegFailed();
            }
        }
        else{
            array_push($errorsArray, "Not equal passwords");
            LogsDriverRegFailed();
        }


        if(empty($errorsArray)){
            $email = $data["Email"];
            $query = "SELECT Email FROM drivers WHERE Email ='$email'";
            $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));

            if($result){
                $row = mysqli_fetch_row($result);
                if(!empty($row[0])){
                    array_push($errorsArray, "This email is registered");
                    LogsDriverRegFailed();
                }
            }

            $phoneNumber = $data["phoneNumber"];
            $query = "SELECT PhoneNumber FROM drivers WHERE PhoneNumber = '$phoneNumber'";
            $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));

            if($result){
                $row = mysqli_fetch_row($result);
                if(!empty($row[0])){
                    array_push($errorsArray, "This phone number is registered");
                    LogsDriverRegFailed();
                }
            }

            if(empty($errorsArray)){
                $password = $data["password"];
                $name = $data["Name"];
                $passwordHash = md5($password).$salt;

                $query = "INSERT INTO drivers(Name, Email, PhoneNumber, Password) VALUES ('$name', '$email', '$phoneNumber', '$passwordHash')";

                $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));

                LogsDriverRegAccepted();

//                if($result){
//                    header("Location: 'file where need location");
//                }
            }
        }

        echo json_encode($errorsArray);
    }
}
////кнопка в таблице как у юзеров для блокировки, либо прям удаление - я хз
//function renderBlockDriverButton($drivers){
//    include "../../database/dbConnection.php";
//
//    if(isset($_GET['del'])){
//        $id_users = $_GET['del'];
//
//        $query = "UPDATE drivers SET Status = 'Block' WHERE ID = $id_users";
//
//        mysqli_query($dbLink, $query) or die("Ошибка ".mysqli_error($dbLink));
//    }
//
//    ?>
<!--    <a href="?del=--><?//= $drivers['ID']?><!--">Block</a>-->
<!--    --><?php
//}
