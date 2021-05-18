<?php
require_once "../../database/dbConnection.php";
require_once "../../utils/logger.php";

header("Access-Control-Allow-Origin: http://localhost:3000");

$object = json_decode($_POST['getPromocodes'], true);

getPromocodeTableByUser($object);
function getPromocodeTableByUser($userID){
    $query = "SELECT p.Promocode FROM promocodes AS p 
                INNER JOIN users_promocodes AS u 
                ON p.ID = u.ID_Promocode
                WHERE u.ID_User = $userID";
    $result = mysqli_query($dbLink, $query) or die ("Select error ".mysqli_error($dbLink));

    if($result){
        $promcodes = array(); // в этот массив запишем то, что выберем из базы

        while ($row = mysqli_fetch_assoc($result)) { // оформим каждую строку результата
            // как ассоциативный массив
            $promcodes[] = $row; // допишем строку из выборки как новый элемент результирующего массива
        }

        print_r(json_encode($promcodes));
        LogsWriteMessage("Promocodes table by userID is succesfully received");
        return json_encode($promcodes);
    }else{
        LogsWriteMessage("Getting promocodes table is failed");
        return json_encode("Ошибка при получении информации о промкодах");
    }
}