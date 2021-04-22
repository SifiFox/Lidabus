<?php
function userOrderRoute(){
    include "../../database/dbConnection.php";
    include "../../utils/logger.php";
    include "../promocode/promocodeController.php";
    include "../auto/autoController.php";

    $userID = $_POST['userID'];
    $autoID = $_POST['autoID'];
    $promocodeString = $_POST['promocodeString'];
    $passengerCount = $_POST['passengerCount'];

//    if(isset($userID)){
//
//        if(isset($promocodeString)){
//            $promocodeSale = getSalePromocodeByID(getIDPromocodeByString($promocodeString));
//            $seatsCountInAuto = getAutoSeatsNumberByID($autoID);
//            $autoSeatsNumber = getAutoSeatsNumberByID($autoID);
//            isConsistFreePlacesInAuto($seatsCountInAuto, $autoSeatsNumber);
//        }
//        else{
//
//        }
//    }else{
//        echo 'юзера нет';
//    }
    $sumOrderOccupiedPlaces = getOccupiedPlacesNumberByAutoID($autoID);
    $autoSeatsNumber = getAutoSeatsNumberByID($autoID);
    isConsistFreePlacesInAuto($sumOrderOccupiedPlaces, $autoSeatsNumber);
}

function getOccupiedPlacesNumberByAutoID($autoID){
    include "../../database/dbConnection.php";
//    include "../../utils/logger.php";

    $query = "SELECT SUM(PassengerCount) FROM orders WHERE ID_AUTO = $autoID";
    $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));

    if($result){
        $data = array(); // в этот массив запишем то, что выберем из базы

        while($row = mysqli_fetch_assoc($result)){ // оформим каждую строку результата
            // как ассоциативный массив
            $data[] = $row; // допишем строку из выборки как новый элемент результирующего массива
        }
//        LogsAutoGetSeatsNumberByIDSuccess($autoID);

        echo json_encode($data); // и отдаём как json
        return $data['PassengetCount'];
    }else{
//        LogsAutoGetSeatsNumberByIDFailed($autoID);
        return null;
    }
}

function isConsistFreePlacesInAuto($orderOccupiedPlaces, $autoSeatsNumber){
//    if((int)$autoSeatsNumber >= (int)$orderOccupiedPlaces){
//        echo 'true';
//        return true;
//    }else{
//        echo 'false';
//        return false;
//    }
    echo $autoSeatsNumber;
    echo (int)$orderOccupiedPlaces;
}
