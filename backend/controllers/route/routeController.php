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

//getRoutesWithDependenciesByDate(date('Y-m-d'));
//createRoutesForBothDestination(date('Y-m-d'));

function getRoutesWithDependenciesByDate($date){
    include "../../database/dbConnection.php";
    include "../../utils/logger.php";

    $query = "SELECT r.Destination, r.StartTreepTime, r.EndTreepTime,
                    a.Mark, a.Model, a.GovernmentNumber, a.Color,
                    u.PhoneNumber, u.Name FROM routes r
                JOIN autos a ON a.ID = r.ID_Auto
                JOIN drivers_autos da ON da.ID_Auto = a.ID
                JOIN users u ON u.ID = da.ID_Driver
                WHERE r.Date = '$date'
                ORDER BY r.StartTreepTime, r.Destination";
    $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));

    if($result) {
        $data = array(); // в этот массив запишем то, что выберем из базы

        while ($row = mysqli_fetch_assoc($result)) { // оформим каждую строку результата
            // как ассоциативный массив
            $data[] = $row; // допишем строку из выборки как новый элемент результирующего массива
        }
//        var_dump(json_encode($data));  // и отдаём как json
        LogsWriteMessage("Getting routes table is succesfully received");
        return json_encode($data);
    }else{
        LogsWriteMessage("Error retrieving route information");
        return json_encode("Ошибка при получении информации о маршрутах");
    }
}

function createRoutesForBothDestination($date){//проверка на то существуют ли маршруты на $date, если их нет, то создаем
    include "../../utils/logger.php";

    $routesByDate = json_decode(getRoutesByDate($date));

    if(count($routesByDate) == 32){
//        echo ("Маршруты на ".$date." уже назначены");
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

function getRoutesByDate($date){
    include "../../database/dbConnection.php";
    include "../../utils/logger.php";

    $query = "SELECT * FROM routes WHERE Date = '$date'";
    $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));

    if($result) {
        $data = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        LogsWriteMessage("Getting routes table by date ".$date." is succesfully received");
        return json_encode($data);
    }else{
        LogsWriteMessage("Error retrieving route information");
        return json_encode("Ошибка при получении информации о маршрутах");
    }
}