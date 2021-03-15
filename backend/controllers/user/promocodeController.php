<?php
function setPromocode(){
    include "../../database/dbConnection.php";
    include "../../utils/logger.php";

    $promocode = $_POST["Promocode"];

    $query = "SELECT Promocode FROM promocodes WHERE Promocode = '$promocode'";
    $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));

    if($result){
        $row = mysqli_fetch_row($result);

        if(!empty($row[0])){
            if(isset($promocode)){
                $query = "DELETE FROM promocodes WHERE Promocode = '$promocode'";

                mysqli_query($dbLink, $query) or die ("DB error").mysqli_error($dbLink);

                $message = "Promocode accepted";

                LogsUserSetPromocodeAccepted();
            }
            else{
                $message = "Promocode not exist";

                LogsUserSetPromocodeFailed();
            }
        }else{
            $message = "Promocode not exist";

            LogsUserSetPromocodeFailed();
        }
    }else{
        $message = "Promocode not exist";

        LogsUserSetPromocodeFailed();
    }

    echo $message;
}