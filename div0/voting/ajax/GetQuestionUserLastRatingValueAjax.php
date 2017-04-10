<?php
include_once("../requests/GetUserLastRatingRequest.php");

$questionId = $_POST["questionId"];
$userId = $_POST["userId"];

$questionUserLastRatingValueGetter = new GetUserLastRatingRequest();
echo $questionUserLastRatingValueGetter->execute($questionId, $userId);