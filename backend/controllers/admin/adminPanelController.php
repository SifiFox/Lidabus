<?php
function renderAllUsersTableWithBlockButtonForAdmin(){
    include "../../database/dbConnection.php";
    include "../../utils/logger.php";

//    if(isset($_GET['del'])){
//        $id_users = $_GET['del'];
//
//        $query = "UPDATE users SET Status = 'Block' WHERE ID = $id_users";
//
//        mysqli_query($dbLink, $query) or die("Ошибка ".mysqli_error($dbLink));
//    }

    $query = "SELECT * FROM users ORDER BY ID";
    $results = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));

    if($results){
        for($data = []; $row = mysqli_fetch_assoc($results); $data[] = $row){
            echo "<table class='users_table'>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th></th><!--button to block-->
                </tr>";
            foreach ($data as $users){ ?>
                <tr>
                    <td><?= $users["ID"]?></td>
                    <td><?= $users["Name"]?></td>
                    <td><?= $users["Email"]?></td>
                    <td><?= $users["PhoneNumber"]?></td>
                    <td><?= $users["Role"]?></td>
                    <td><?= $users["Status"]?></td>
                    <td><?= renderBlockUserButton($users)?></td>
                    <!--                <td><a href="?del=--><?//= $users['ID']?><!--">Заблокировать</a></td>-->
                </tr>
                <?php
            }
            echo "</table>";
        }
        logsAllUsersTableWithBlockButtonForAdmin();
    }else{
        logsAllUsersTableWithBlockButtonForAdminFailed();
    }
}

function renderBlockUserButton($users){
    include "../../database/dbConnection.php";

    if(isset($_GET['del'])){
        $id_users = $_GET['del'];

        $query = "UPDATE users SET Status = 'Block' WHERE ID = $id_users";

        mysqli_query($dbLink, $query) or die("Ошибка ".mysqli_error($dbLink));
    }

    ?>
    <a href="?del=<?= $users['ID']?>">Block</a>
    <?php
}

function getUsersTable(){
    include "../../database/dbConnection.php";
    include "../../utils/logger.php";

    $query = "SELECT * FROM users WHERE Role = 'User' ORDER BY ID";
    $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));

    if($result){
        $data = array(); // в этот массив запишем то, что выберем из базы

        while($row = mysqli_fetch_assoc($result)){ // оформим каждую строку результата
            // как ассоциативный массив
            $data[] = $row; // допишем строку из выборки как новый элемент результирующего массива
        }

        logsUsersTableForAdminSuccess();

        echo json_encode($data); // и отдаём как json
    }else{
        logsUsersTableForAdminFailed();
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
            $query = "SELECT Email FROM users WHERE Email ='$email'";
            $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));

            if($result){
                $row = mysqli_fetch_row($result);
                if(!empty($row[0])){
                    array_push($errorsArray, "This email is registered");
                    LogsDriverRegFailed();
                }
            }

            $phoneNumber = $data["phoneNumber"];
            $query = "SELECT PhoneNumber FROM users WHERE PhoneNumber = '$phoneNumber'";
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

                $query = "INSERT INTO users(Name, Email, PhoneNumber, Password, Role) VALUES ('$name', '$email', '$phoneNumber', '$passwordHash', 'Driver')";

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
?>


