<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/div0/answer/update/requests/UpdateAnswerRequest.php');

if(isset($_POST["answerId"])){
    $answerId = $_POST["answerId"];
    $answerContent = $_POST["answerContent"];
    $userId = $_POST["userId"];

    $updateAnswerRequest = new UpdateAnswerRequest();
    echo $updateAnswerRequest->execute($answerId, $answerContent, $userId);
}
else{
    echo 'questionId not set';
}
