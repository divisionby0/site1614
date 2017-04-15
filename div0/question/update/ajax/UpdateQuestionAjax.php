<?php
include_once($_SERVER['DOCUMENT_ROOT'].'div0/question/update/requests/UpdateQuestionRequest.php');

if(isset($_POST["questionId"])){
    $questionId = $_POST["questionId"];
    $questionContent = $_POST["questionContent"];
    
    $updateQuestionRequest = new UpdateQuestionRequest();
    echo $updateQuestionRequest->execute($questionId, $questionContent);
}
else{
    echo 'questionId not set';
}