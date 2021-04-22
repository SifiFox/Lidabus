<?php
function getPromocodeTable(){
    include "../../database/dbConnection.php";

    $data = array(); // в этот массив запишем то, что выберем из базы

    $query = "SELECT * FROM promocodes ORDER BY ID";
    $result = mysqli_query($dbLink, $query) or die ("DB error".mysqli_error($dbLink));

    if($result){
        while($row = mysqli_fetch_assoc($result)){ // оформим каждую строку результата
            // как ассоциативный массив
            $data[] = $row; // допишем строку из выборки как новый элемент результирующего массива
        }

        LogsPromocodeTableAccepted();

//        echo json_encode($data); // и отдаём как json
//        return json_encode($data);
        return $data;
    }else{
        LogsPromocodeTableFailed();
        return null;
    }
}

function getIDPromocodeByString($promocodeString){
    include "../../database/dbConnection.php";

    $data = getPromocodeTable();
    $promocodeID = 0;

    if($data != null){
        foreach($data as $promocode){
            if($promocode["Promocode"] == $promocodeString){
                $promocodeID = $promocode["ID"];
            }
        }
    }else{
        return null;
    }

    return $promocodeID;
}

function getSalePromocodeByID($promocodeID){
    include "../../database/dbConnection.php";

    $data = getPromocodeTable();
    $promocodeSale = 0;

    if($data != null){
        foreach($data as $promocode){
            if($promocode["ID"] == $promocodeID){
                $promocodeSale = $promocode["Sale"];
            }
        }
    }else{
        return null;
    }

    return $promocodeSale;
}
