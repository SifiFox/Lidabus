<?php
// при нажатии на кнопку с фронты передается объект json ['Status' => 'Active/Block']
header("Access-Control-Allow-Origin: http://localhost:3000");

$object = json_decode($_POST['updateUserStatus'], true);
//$object = json_encode(['ID_User' => 66, 'Status' => 'Blocked']);
setStatusToUser($object);

function setStatusToUser($object){
    include "../../../database/dbConnection.php";
    include "../../../utils/logger.php";

    $userID = $object['ID_User'];
    $status = $object['Status'];

    $query = "UPDATE users SET Status = '$status'
                WHERE ID = $userID";
    $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));

    if($result){
        LogsWriteMessage("user with ID $userID updated status to: $status");

        echo $status;
    }else{
        LogsWriteMessage("Database error");
    }
}