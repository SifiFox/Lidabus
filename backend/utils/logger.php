<?php
    function LogsRegFailed(){
        $str = "[".date(DATE_RFC822)."] Registration failed\n";
        $fp = fopen("../logs.txt","a+");
        fwrite($fp, $str);
        fclose($fp);
    }

    function LogsRegAccepted(){
        $str = "[".date(DATE_RFC822)."] User ".$_SESSION["Login"]." register\n";
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
        $str = "[".date(DATE_RFC822)."] User ".$_SESSION["Login"]." is login\n";
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
        $str = "[".date(DATE_RFC822)."] Driver ".$_SESSION["Login"]." register\n";
        $fp = fopen("../logs.txt", "a+");
        fwrite($fp, $str);
        fclose($fp);
    }
    ?>