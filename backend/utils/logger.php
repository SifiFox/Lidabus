<?php
    function LogsRegFailed(){
        $str = "[".date(DATE_RFC822)."] Registration failed\n";
        $fp = fopen("../logs.txt","a+");
        fwrite($fp, $str);
        fclose($fp);
    }

    function LogsRegAccepted(){
        $str = "[".date(DATE_RFC822)."] User ".$_SESSION["Email"]." register\n";
        $fp = fopen("../logs.txt", "a+");
        fwrite($fp, $str);
        fclose($fp);
    }

    function LogsLoginFailedId(){
        $str = "[".date(DATE_RFC822)."] Login failed id\n";
        $fp = fopen("../logs.txt", "a+");
        fwrite($fp, $str);
        fclose($fp);
    }

     function LogsLoginFailedNumber(){
        $str = "[".date(DATE_RFC822)."] Login failed number\n";
        $fp = fopen("../logs.txt", "a+");
        fwrite($fp, $str);
        fclose($fp);
    }
     function LogsLoginFailedPassword(){
        $str = "[".date(DATE_RFC822)."] Login failed password\n";
        $fp = fopen("../logs.txt", "a+");
        fwrite($fp, $str);
        fclose($fp);
    }
     function LogsLoginFailedBlocked(){
        $str = "[".date(DATE_RFC822)."] Login failed blocked\n";
        $fp = fopen("../logs.txt", "a+");
        fwrite($fp, $str);
        fclose($fp);
    }

    function LogsLoginAccepted(){
        $str = "[".date(DATE_RFC822)."] User ".$_SESSION["Email"]." is login\n";
        $fp = fopen("../logs.txt", "a+");
        fwrite($fp, $str);
        fclose($fp);
        return str;
    }

    function logsAllUsersTableWithBlockButtonForAdmin(){
        $str = "[".date(DATE_RFC822)."] All users table with block button for admin is success\n";
        $fp = fopen("../logs.txt", "a+");
        fwrite($fp, $str);
        fclose($fp);
    }

    function logsAllUsersTableWithBlockButtonForAdminFailed(){
        $str = "[".date(DATE_RFC822)."] All users table with block button for admin is failed\n";
        $fp = fopen("../logs.txt", "a+");
        fwrite($fp, $str);
        fclose($fp);
    }

    function logsUsersTableForAdminSuccess(){
        $str = "[".date(DATE_RFC822)."] Users table for admin is success\n";
        $fp = fopen("../logs.txt", "a+");
        fwrite($fp, $str);
        fclose($fp);
    }

    function logsUsersTableForAdminFailed(){
        $str = "[".date(DATE_RFC822)."] Users table for admin is failed\n";
        $fp = fopen("../logs.txt", "a+");
        fwrite($fp, $str);
        fclose($fp);
    }

    function logsDriversTableForAdminSuccess(){
        $str = "[".date(DATE_RFC822)."] Drivers table for admin is success\n";
        $fp = fopen("../logs.txt", "a+");
        fwrite($fp, $str);
        fclose($fp);
    }

    function logsDriversTableForAdminFailed(){
        $str = "[".date(DATE_RFC822)."] Drivers table for admin is failed\n";
        $fp = fopen("../logs.txt", "a+");
        fwrite($fp, $str);
        fclose($fp);
    }

    function LogsDriverRegFailed(){
        $str = "[".date(DATE_RFC822)."] Driver registration failed\n";
        $fp = fopen("../logs.txt","a+");
        fwrite($fp, $str);
        fclose($fp);
    }

    function LogsDriverRegAccepted(){
        $str = "[".date(DATE_RFC822)."] Driver ".$_SESSION["Email"]." register\n";
        $fp = fopen("../logs.txt", "a+");
        fwrite($fp, $str);
        fclose($fp);
    }

    function LogsPromocodeFailed(){
        $str = "[".date(DATE_RFC822)."] Promocode ".$_SESSION["Promocode"]." failed\n";
        $fp = fopen("../logs.txt", "a+");
        fwrite($fp, $str);
        fclose($fp);
    }

    function LogsPromocodeAccepted(){
        $str = "[".date(DATE_RFC822)."] Promocode ".$_SESSION["Promocode"]." register\n";
        $fp = fopen("../logs.txt", "a+");
        fwrite($fp, $str);
        fclose($fp);
    }

    function LogsUserSetPromocodeFailed(){
        $str = "[".date(DATE_RFC822)."] User set promocode ".$_SESSION["Promocode"]." failed\n";
        $fp = fopen("../logs.txt", "a+");
        fwrite($fp, $str);
        fclose($fp);
    }

    function LogsUserSetPromocodeAccepted(){
        $str = "[".date(DATE_RFC822)."] User set promocode ".$_SESSION["Promocode"]." accepted\n";
        $fp = fopen("../logs.txt", "a+");
        fwrite($fp, $str);
        fclose($fp);
    }

    function LogsAutoTableFailed(){
        $str = "[".date(DATE_RFC822)."] Autos table failed\n";
        $fp = fopen("../logs.txt", "a+");
        fwrite($fp, $str);
        fclose($fp);
    }

    function LogsAutoTableAccess(){
        $str = "[".date(DATE_RFC822)."] Autos table accepted\n";
        $fp = fopen("../logs.txt", "a+");
        fwrite($fp, $str);
        fclose($fp);
    }

    function LogsPromocodeTableFailed(){
        $str = "[".date(DATE_RFC822)."] Promocode table failed\n";
        $fp = fopen("../logs.txt", "a+");
        fwrite($fp, $str);
        fclose($fp);
    }

    function LogsPromocodeTableAccepted(){
        $str = "[".date(DATE_RFC822)."] Promocode table accepted\n";
        $fp = fopen("../logs.txt", "a+");
        fwrite($fp, $str);
        fclose($fp);
    }

    function LogsPromocodeContainsInTableFailed($promocode){
        $str = "[".date(DATE_RFC822)."] Promocode: ".$promocode." no such in DB\n";
        $fp = fopen("../logs.txt", "a+");
        fwrite($fp, $str);
        fclose($fp);
    }

    function LogsPromocodeContainsInTableAccepted($promocode){
        $str = "[".date(DATE_RFC822)."] Promocode: ".$promocode." is in DB\n";
        $fp = fopen("../logs.txt", "a+");
        fwrite($fp, $str);
        fclose($fp);
    }

    function LogsAutoGetSeatsNumberByIDFailed($autoID){
        $str = "[".date(DATE_RFC822)."] Get auto seats number by id: ".$autoID." failed\n";
        $fp = fopen("../logs.txt", "a+");
        fwrite($fp, $str);
        fclose($fp);
    }

    function LogsAutoGetSeatsNumberByIDSuccess($autoID){
        $str = "[".date(DATE_RFC822)."] Get auto seats number by id: ".$autoID." success\n";
        $fp = fopen("../logs.txt", "a+");
        fwrite($fp, $str);
        fclose($fp);
    }
    ?>