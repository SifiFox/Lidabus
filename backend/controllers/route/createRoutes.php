<?php
//echo date("Y/m/d/H/i");
//var_dump(time_range(10800, 66600));

//$datetime = date_create()->format('Y-m-d');
//echo($datetime);
//$date = date("h:i",strtotime("23:40"));
//$date2 = date_create()->format('h:i');
//if($date == $date2){
//    echo "123";
//    }


//$next_date = date('Y-m-d', strtotime(date("Y/m/d/") .' +1 day'));

function generateTreepTime($start, $end, $step = 3600) {
    $startTreepTime = array();

    for( $time = $start; $time <= $end; $time += $step )
        $startTreepTime[] = date( 'H:i', $time );

    return $startTreepTime;
}

function createRoutesForBothDestination($date){//проверка на то существуют ли маршруты на $date, если их нет, то создаем
    include "get.php";

    $routesByDate = json_decode(getRoutesByDate($date));

    if(count($routesByDate) == 32){
        LogsWriteMessage("Routes to ".$date." already appointed");
        return json_encode("Маршруты на ".$date." уже назначены");
    }else{
        $id_autos_to_lida = [1, 3, 5, 7, 2, 4, 6, 8, 1, 3, 5, 7, 2, 4, 6, 8];
        $id_auto_to_minsk = [2, 4, 6, 8, 1, 3, 5, 7, 2, 4, 6, 8, 1, 3, 5, 7];
        $startTreepTime = generateTreepTime(10800, 66600);
        $endTreepTime = generateTreepTime(19800, 73800);

        createRoutesForOneDestination($id_autos_to_lida, $date,'Лида', $startTreepTime, $endTreepTime);
        createRoutesForOneDestination($id_auto_to_minsk,$date, 'Минск', $startTreepTime, $endTreepTime);

//        echo "Маршруты на ".$date." созданы";
        LogsWriteMessage("Routes to ".$date." already created");
        return json_encode("Маршруты на ".$date." созданы");
    }
}

function createRoutesForOneDestination($id_auto, $date, $destination, $startTreepTime, $endTreepTime){// minsk or lida
    include "../../database/dbConnection.php";

    for($i = 0; $i < count($startTreepTime); $i++){
        $query = "INSERT INTO routes(ID_Auto, Date, Destination, StartTreepTime, EndTreepTime) 
                    VALUES ($id_auto[$i], '$date', '$destination', '$startTreepTime[$i]', '$endTreepTime[$i]')";
        $result = mysqli_query($dbLink, $query) or die ("Select error" . mysqli_error($dbLink));
    }
}