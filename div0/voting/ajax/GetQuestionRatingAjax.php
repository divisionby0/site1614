<?php
include_once("../requests/question/GetQuestionRatingRequest.php");

$questionId = $_POST["questionId"];

$getQuestionRatingRequest = new GetQuestionRatingRequest();
$rating = $getQuestionRatingRequest->execute($questionId);
echo $rating;