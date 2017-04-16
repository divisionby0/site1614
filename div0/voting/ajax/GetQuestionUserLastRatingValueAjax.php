<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/div0/voting/requests/GetUserLastRatingRequest.php');

if(isset($_POST["questionId"]) && isset($_POST["userId"])){
    $questionId = $_POST["questionId"];
    $userId = $_POST["userId"];

    $questionUserLastRatingValueGetter = new GetUserLastRatingRequest();
    echo $questionUserLastRatingValueGetter->execute($questionId, $userId);
}