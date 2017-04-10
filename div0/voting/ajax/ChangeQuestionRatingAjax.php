<?php
include_once("../requests/question/ChangeQuestionRatingRequest.php");

$changeQuestionRatingRequest = new ChangeQuestionRatingRequest();

$questionId = $_POST["questionId"];
$value = $_POST["value"];
$userId = $_POST["userId"];

$changedQuestionRating = $changeQuestionRatingRequest->execute($questionId, $value, $userId);
echo $changedQuestionRating;