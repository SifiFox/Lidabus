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

    function LogsLoginFailed(){
        $str = "[".date(DATE_RFC822)."] Login failed\n";
        $fp = fopen("../logs.txt", "a+");
        fwrite($fp, $str);
        fclose($fp);
    }

    function LogsLoginAccepted(){
        $str = "[".date(DATE_RFC822)."] User ".$_SESSION["Login"]." is login\n";
        $fp = fopen("../logs.txt", "a+");
        fwrite($fp, $str);
        fclose($fp);
    }

    ?>