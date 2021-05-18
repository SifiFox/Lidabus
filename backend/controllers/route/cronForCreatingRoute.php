<?php

require_once "../../utils/logger.php";
require_once "createRoutes.php";

createFutureRoutesForDaysNumber(date('Y-m-d'), 3);

function createFutureRoutesForDaysNumber($currentDate, $daysNumber){
    for($i = 0; $i < $daysNumber; $i++){
        createRoutesForBothDestination(date('Y-m-d', strtotime(date("Y/m/d/") .' +'.$i.' day')));

        LogsWriteMessage("Cron success. Routes for ".date('Y-m-d', strtotime(date("Y/m/d/") .' +'.$i.' day'))." created");
    }
}
