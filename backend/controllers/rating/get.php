<?php
function getRatingByID($userID){
    include "../../database/dbConnection.php";

    $rating = 0;

    $query = "SELECT r.Rating AS rat FROM rating r
                INNER JOIN users u ON u.ID_Rating = r.ID
                WHERE u.ID = $userID";
    $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));

    if($result){
        $driverRating = 0;

        while($row = $result -> fetch_object()){
            $driverRating = $row -> rat;
        }

        $rating = $driverRating;

//        print_r(json_encode($rating));
        LogsWriteMessage("Getting reting by user ID: ".$rating);
        return $rating;
    }else{
        LogsWriteMessage("DB error");
        return json_encode("DB error");
    }
}

function getCountVotesByID($userID){
    include "../../database/dbConnection.php";

    $countVotes = 0;

    $query = "SELECT r.CountVotes AS rating FROM rating r 
                INNER JOIN users u ON u.ID_Rating = r.ID 
                WHERE u.ID = $userID";
    $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));

    if($result){
        $driverRating = 0;

        while($row = $result -> fetch_object()){
            $driverRating = $row -> rating;
        }

        $countVotes = $driverRating;

        print_r($countVotes);
        LogsWriteMessage("Getting count votes by user ID: ".$countVotes);
        return $countVotes;
    }else{
        LogsWriteMessage("DB error");
        return json_encode("DB error");
    }
}