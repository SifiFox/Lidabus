<?php
include "../database/dbConnection.php";

    $data = $_POST;

    if(!empty($data)){
        $regPassword = "/^[%?^#$]?(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{6,}/";//* любое число раз подряд или отсутствовать

        $errorsArray = array();

        if($data["password"] == $data["passwordConfirm"] && $data["password"] != null){
            if(preg_match($regPassword, $data["password"])){ }
            else{
                array_push($errorsArray, "Password error");
            }
        }
        else{
            array_push($errorsArray, "Not equal passwords");
        }


        if(empty($errorsArray)){
            $email = $data["Email"];

            $query = "SELECT Email FROM users WHERE Email ='$email'";

            $result = mysqli_query($dbLink, $query) or die ("Ошибка запроса".mysqli_error($dbLink));

            if($result){
                $row = mysqli_fetch_row($result);

                if(!empty($row[0])){
                    array_push($errorsArray, "This email is registered");
                }
            }

            if(empty($errorsArray)){
                $password = $data["password"];
                $confirmPassword = $data["passwordConfirm"];
                $name = $data["Name"];
                $phoneNumber = $data["phoneNumber"];
                $passwordHash = md5($password).$salt;

                $query = "INSERT INTO users(Name, Email, PhoneNumber, Password) VALUES ('$name', '$email', '$phoneNumber', '$passwordHash')";

                $result = mysqli_query($dbLink, $query) or die ("Ошибка запроса".mysqli_error($dbLink));
            }
        }

        echo json_encode($errorsArray);
    }
?>
