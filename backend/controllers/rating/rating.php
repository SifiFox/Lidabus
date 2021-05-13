<?php
$object = json_encode(['ID_User' => 49, 'ID_Driver' => 48, 'Rating' => 4]);
//setRatingToDriver($object);
function setRatingToDriver($object){
    include "../../database/dbConnection.php";
    include "../../utils/logger.php";

    $object = json_decode($object, true);
    $userID = $object['ID_Driver'];
    $userVote = $object['Rating'];
    $currentRating = getRatingByID($userID);
    $countVotes = getCountVotesByID($userID);

    $newRating = round(calculateRating($currentRating, $countVotes, $userVote), 2);
//    echo $newRating;

     $query = "UPDATE rating SET Rating = $newRating, CountVotes = ($countVotes + 1)
                    WHERE ID = $userID";
    $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));

    if($result){
        LogsWriteMessage("User rating with ID: ".$newRating);
    }else{
        LogsWriteMessage("DB error");
    }
}

//getRatingByID(48);
function getRatingByID($userID){
    include "../../database/dbConnection.php";

    $rating = 0;

    $query = "SELECT r.Rating AS rating FROM rating r 
                INNER JOIN users u ON u.ID_Rating = r.ID 
                WHERE u.ID = $userID";
    $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));

    if($result){
        $driverRating = 0;

        while($row = $result -> fetch_object()){
            $driverRating = $row -> rating;
        }

        $rating = $driverRating;

        LogsWriteMessage("Getting reting by user ID: ".$rating);
        return $rating;
    }else{
        LogsWriteMessage("DB error");
        return json_encode("DB error");
    }
}
//getCountVotesByID(48);
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

        LogsWriteMessage("Getting count votes by user ID: ".$countVotes);
        return $countVotes;
    }else{
        LogsWriteMessage("DB error");
        return json_encode("DB error");
    }
}

function calculateRating($currentRating, $countVotes, $userVote){
    $rating = (($currentRating * $countVotes) + $userVote)/($countVotes + 1);

    return $rating;
}

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