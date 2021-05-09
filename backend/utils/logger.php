<?php
    function LogsRegFailed($errorMessage){
        $str = "[".date(DATE_RFC822)."] Registration failed: ".$errorMessage."\n";
        $fp = fopen("../logs.txt","a+");
        fwrite($fp, $str);
        fclose($fp);
    }

    function LogsRegAccepted($resultRow){
        $str = "[".date(DATE_RFC822)."] User ".$resultRow["Name"]." ".$resultRow["Surname"]." register\n";
        $fp = fopen("../logs.txt", "a+");
        fwrite($fp, $str);
        fclose($fp);
    }

    function LogsLoginFailed($errorMessage){
        $str = "[".date(DATE_RFC822)."] Login failed: ".$errorMessage."\n";
        $fp = fopen("../logs.txt", "a+");
        fwrite($fp, $str);
        fclose($fp);
    }

    function LogsLoginAccepted($resultRow){
        $str = "[".date(DATE_RFC822)."] User ".$resultRow["Name"]." ".$resultRow["Surname"]." is login\n";
        $fp = fopen("../logs.txt", "a+");
        fwrite($fp, $str);
        fclose($fp);
    }

    function LogsWriteMessage($message){
        $str = "[".date(DATE_RFC822)."]".$message."\n";
        $fp = fopen("../logs.txt", "a+");
        fwrite($fp, $str);
        fclose($fp);
    }

    ?>