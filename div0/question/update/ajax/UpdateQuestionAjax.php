<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/div0/question/update/requests/UpdateQuestionRequest.php');

if(isset($_POST["questionId"])){
    $questionId = $_POST["questionId"];
    $questionContent = $_POST["questionContent"];
    $title = $_POST["title"];
    $questionSection = $_POST["section"];
    
    $updateQuestionRequest = new UpdateQuestionRequest();
    echo $updateQuestionRequest->execute($questionId, $questionContent, $questionSection, $title);
}
else{
    echo 'questionId not set';
}