<?php
include_once("../../DBConfig.php");
include_once("../ChangeQuestionRatingRequest.php");

$changeQuestionRatingRequest = new ChangeQuestionRatingRequest();

$questionId = $_POST["questionId"];
$value = $_POST["value"];
$userId = $_POST["userId"];

$changedQuestionRating = $changeQuestionRatingRequest->execute($questionId, $value, $userId);
echo $changedQuestionRating;