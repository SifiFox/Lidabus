<?php

function createRating($userID){
    include "../../database/dbConnection.php";

    $query = "INSERT INTO rating(ID) VALUES($userID)";
    $result = mysqli_query($dbLink, $query) or die ("Select error" . mysqli_error($dbLink));

    if($result) {
        $query = "UPDATE users SET ID_Rating = $userID WHERE ID = $userID";
        $result = mysqli_query($dbLink, $query) or die ("Select error" . mysqli_error($dbLink));
        if($result){
            LogsWriteMessage("Rating for user created");
        }else{
            LogsWriteMessage("Database error");
        }
    }else{
        LogsWriteMessage("Database error");
    }
}