<?php
include_once($_SERVER['DOCUMENT_ROOT'].'div0/answer/update/requests/UpdateAnswerRequest.php');

if(isset($_POST["answerId"])){
    $answerId = $_POST["answerId"];
    $answerContent = $_POST["answerContent"];

    $updateAnswerRequest = new UpdateAnswerRequest();
    echo $updateAnswerRequest->execute($answerId, $answerContent);
}
else{
    echo 'questionId not set';
}
