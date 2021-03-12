<?php
include "../database/dbConnection.php";
include "../utils/logger.php";

    $resultRow = null;
    $errorsArray = array();
    $data = $_POST;

    $phoneNumber = $data["phoneNumber"];
    $password = $data["password"];

    $query = "SELECT * FROM users WHERE PhoneNumber = '$phoneNumber'";

    $result = mysqli_query($dbLink, $query) or die ("Database error");

    $resultRow = mysqli_fetch_assoc($result);

    if(!empty($resultRow["ID"])){
        if($resultRow["PhoneNumber"] == $phoneNumber){
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
            array_push($errorsArray, "Incorrect phone number");
            LogsLoginFailed();
        }
    }else{
        array_push($errorsArray, "ID is empty");
        LogsLoginFailed();
    }
echo json_encode($errorsArray);
