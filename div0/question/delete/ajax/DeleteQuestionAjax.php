<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/div0/question/delete/requests/DeleteQuestionRequest.php');

if(isset($_POST["questionId"])){

    $questionId = $_POST["questionId"];
    $deleteQuestionRequest = new DeleteQuestionRequest();
    echo $deleteQuestionRequest->execute($questionId);
}
else{
    echo 'questionId not set';
}