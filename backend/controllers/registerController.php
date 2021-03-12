<?php
include "../database/dbConnection.php";
include "../utils/logger.php";

    $data = $_POST;

    if(!empty($data)){
        session_start();
        $regPassword = "/^[%?^#$]?(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{6,}/";//* любое число раз подряд или отсутствовать
        $errorsArray = array();

        if($data["password"] == $data["passwordConfirm"] && $data["password"] != null){
            if(preg_match($regPassword, $data["password"])){ }
            else{
                array_push($errorsArray, "Password error");
                LogsRegFailed();
            }
        }
        else{
            array_push($errorsArray, "Not equal passwords");
            LogsRegFailed();
        }


        if(empty($errorsArray)){
            $email = $data["Email"];
            $query = "SELECT Email FROM users WHERE Email ='$email'";
            $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));

            if($result){
                $row = mysqli_fetch_row($result);
                if(!empty($row[0])){
                    array_push($errorsArray, "This email is registered");
                    LogsRegFailed();
                }
            }

            $phoneNumber = $data["phoneNumber"];
            $query = "SELECT PhoneNumber FROM users WHERE PhoneNumber = '$phoneNumber'";
            $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));

            if($result){
                $row = mysqli_fetch_row($result);
                if(!empty($row[0])){
                    array_push($errorsArray, "This phone number is registered");
                    LogsRegFailed();
                }
            }

            if(empty($errorsArray)){
                $password = $data["password"];
                $confirmPassword = $data["passwordConfirm"];
                $name = $data["Name"];
                $passwordHash = md5($password).$salt;

                $query = "INSERT INTO users(Name, Email, PhoneNumber, Password) VALUES ('$name', '$email', '$phoneNumber', '$passwordHash')";

                $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));

                LogsRegAccepted();

//                if($result){
//                    header("Location: 'file where need location");
//                }
            }
        }

        echo json_encode($errorsArray);
    }
?>
