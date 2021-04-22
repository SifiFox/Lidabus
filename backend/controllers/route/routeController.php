<?php
function acceptRouteByDriver(){
    include "../../database/dbConnection.php";
//    include "../../utils/logger.php";

//    $query = "SELECT routes.ID, routes.ID_Auto, routes.Status,
//                    autos.ID, drivers.ID, auto_driver.ID_Auto, auto_driver.ID_Driver
//              FROM routes, autos, drivers, auto_driver
//              WHERE "

    $driverID = $_POST['driverID'];
    $acceptRouteID = $_POST['acceptRouteID'];
    $autoID = $_POST['autoID'];

    if(isset($driverID)){
        setAcceptedStatusInRouteByDriver($acceptRouteID);

        $query = "INSERT INTO auto_driver(ID_Auto, ID_Driver) VALUES($autoID, $driverID)";
        $result = mysqli_query($dbLink, $query) or die ("DB error".mysqli_error($dbLink));

        $message = 'success auto_driver set';
    }
    else{
        $message = 'failed auto_driver';
    }

    echo $message;
}

function setAcceptedStatusInRouteByDriver($acceptRouteID){
    include "../../database/dbConnection.php";
//    include "../../utils/logger.php";

    if(isset($acceptRouteID)){
        $setStatusQuery = "UPDATE routes SET Status = 'Accepted' 
                            WHERE ID = $acceptRouteID";

        $result = mysqli_query($dbLink, $setStatusQuery) or die ("DB error".mysqli_error($dbLink));
        $message = 'success set accept status in route by driver';
    }
    else{
        $message = "error set accept status in route by driver";
    }

    echo $message;
}