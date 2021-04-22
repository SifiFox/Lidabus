<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
include "../../database/dbConnection.php";
include "../../utils/logger.php";


    $resultRow = null;
    $errorsArray = array();
    $data = $_POST;

    $PhoneNumber = $data["PhoneNumber"];
    $password = $data["password"];

    $query = "SELECT * FROM users WHERE PhoneNumber = '$PhoneNumber'";

    $result = mysqli_query($dbLink, $query) or die ("Database error");

    $resultRow = mysqli_fetch_assoc($result);

    print($PhoneNumber);
     print($password);

    //Authorization for users
    if(!empty($resultRow["ID"])){
        if($resultRow["PhoneNumber"] == $PhoneNumber){
            if($resultRow["Password"] == md5($password).$salt){
                if($resultRow["Role"] == "User"){
                    if($resultRow["Status"] == "Active"){
                        if(session_status() != PHP_SESSION_ACTIVE){
                            session_start();
                        }
                        LogsLoginAccepted();

//                        header("Location: 'file where need location'");
                    }else{
                        array_push($errorsArray, 'You are blocked');
                        LogsLoginFailed();
                    }
                }
            }else{
                array_push($errorsArray, 'Incorrect password');
                LogsLoginFailed();
            }
        }else{
            array_push($errorsArray, "Incorrect Phone number");
            LogsLoginFailed();
        }
    }else{
        echo "user failed";
        array_push($errorsArray, "ID is empty");
        LogsLoginFailed();
    }

    //Authorization for ADMIN
    if(!empty($resultRow["ID"])){
        if($resultRow["PhoneNumber"] == $PhoneNumber){
            if($resultRow["Password"] == md5($password).$salt){
                if($resultRow["Role"] == "Admin"){
                    if($resultRow["Status"] == "Active"){
                        if(session_status() != PHP_SESSION_ACTIVE){
                            session_start();
                        }
                        LogsLoginAccepted();

    //                        header("Location: 'file where need location'");
                    }else{
                        array_push($errorsArray, 'You are blocked');
                        LogsLoginFailedBlocked();
                    }
                }
            }else{
                array_push($errorsArray, 'Incorrect password');
                LogsLoginFailedPassword();
            }
        }else{
            array_push($errorsArray, "Incorrect Phone number");
            LogsLoginFailedNumber();
        }
    }else{
        array_push($errorsArray, "ID is empty");
        LogsLoginFailedId();
    }

    echo json_encode($errorsArray);
