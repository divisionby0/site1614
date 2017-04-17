<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/div0/question/update/requests/UpdateQuestionRequest.php');

if(isset($_POST["questionId"])){
    $questionId = $_POST["questionId"];
    $questionContent = $_POST["questionContent"];
    $title = $_POST["title"];
    $questionSection = $_POST["section"];
    $userId = $_POST["userId"];
    
    $updateQuestionRequest = new UpdateQuestionRequest();
    echo $updateQuestionRequest->execute($questionId, $questionContent, $questionSection, $title, $userId);
}
else{
    echo 'questionId not set';
}