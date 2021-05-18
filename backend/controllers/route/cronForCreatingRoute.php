<?php

createFutureRoutesForDaysNumber(date('Y-m-d'), 3);

function createFutureRoutesForDaysNumber($currentDate, $daysNumber){
    include "../../utils/logger.php";
    include "createRoutes.php";

    for($i = 0; $i < $daysNumber; $i++){
        createRoutesForBothDestination(date('Y-m-d', strtotime(date("Y/m/d/") .' +'.$i.' day')));

        LogsWriteMessage("Cron success. Routes for ".date('Y-m-d', strtotime(date("Y/m/d/") .' +'.$i.' day'))." created");
    }
}
