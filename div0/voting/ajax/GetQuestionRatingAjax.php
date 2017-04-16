<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/div0/voting/requests/question/GetQuestionRatingRequest.php');

if(isset($_POST["questionId"])){
    $questionId = $_POST["questionId"];
    $getQuestionRatingRequest = new GetQuestionRatingRequest();
    $rating = $getQuestionRatingRequest->execute($questionId);
    echo $rating;
}


