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
        logsALLUsersTableWithBlockButtonForAdminFailed();
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
        for($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row){
            logsUsersTableForAdminSuccess();
            return $data;
        }
    }else{
        logsUsersTableForAdminFailed();
    }
}
?>


