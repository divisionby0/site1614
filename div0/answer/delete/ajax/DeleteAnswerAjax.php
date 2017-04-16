<?php
include_once($_SERVER['DOCUMENT_ROOT'].'div0/answer/delete/requests/DeleteAnswerRequest.php');

if(isset($_POST["answerId"])){

    $answerId = $_POST["answerId"];
    $questionId = $_POST["questionId"];
    $deleteAnswerRequest = new DeleteAnswerRequest();
    echo $deleteAnswerRequest->execute($answerId, $questionId);
}
else{
    echo 'answer Id not set';
}