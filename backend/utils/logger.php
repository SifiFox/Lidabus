<?php

    function LogsWriteMessage($message){
        $str = "[".date(DATE_RFC822)."]".$message."\n";
        $fp = fopen("../logs.txt", "a+");
        fwrite($fp, $str);
        fclose($fp);
    }

    ?>