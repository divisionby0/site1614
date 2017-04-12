<?php
include_once($_SERVER['DOCUMENT_ROOT'].'div0/voting/requests/question/ChangeQuestionRatingRequest.php');

if(isset($_POST["questionId"]) && isset($_POST["value"]) && isset($_POST["userId"])){
    $changeQuestionRatingRequest = new ChangeQuestionRatingRequest();

    $questionId = $_POST["questionId"];
    $value = $_POST["value"];
    $userId = $_POST["userId"];

    $changedQuestionRating = $changeQuestionRatingRequest->execute($questionId, $value, $userId);
    echo $changedQuestionRating;
}