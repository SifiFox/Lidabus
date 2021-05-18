<?php
header("Access-Control-Allow-Origin: http://localhost:3000");

$object = json_decode($_GET['setRating'], true);
//setRatingToDriver($authUser);
//$object = json_encode(['ID_User' => 49, 'ID_Driver' => 48, 'Rating' => 4]);
setRatingToDriver($object);
function setRatingToDriver($object){
    include "../../database/dbConnection.php";
    include "../../utils/logger.php";
    include "get.php";

    $userID = $object['ID_User'];
    $userVote = $object['Rating'];
    $currentRating = getRatingByID($userID);
    $countVotes = getCountVotesByID($userID);

    $newRating = round(calculateRating($currentRating, $countVotes, $userVote), 2);

     $query = "UPDATE rating SET Rating = $newRating, CountVotes = ($countVotes + 1)
                    WHERE ID = $userID";
    $result = mysqli_query($dbLink, $query) or die ("Select error".mysqli_error($dbLink));

    if($result){
        LogsWriteMessage("User rating with ID: ".$newRating);
    }else{
        LogsWriteMessage("DB error");
    }
}

function calculateRating($currentRating, $countVotes, $userVote){
    $rating = (($currentRating * $countVotes) + $userVote)/($countVotes + 1);

    return $rating;
}
