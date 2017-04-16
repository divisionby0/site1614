<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/div0/question/pining/requests/PinRecordRequest.php');

if(isset($_POST["recordId"])){
    $recordId = $_POST["recordId"];
    $duration = $_POST["duration"];

    $pinRecord = new PinRecordRequest();
    echo $pinRecord->execute($recordId, $duration);
}
else{
    echo 'recordId not set';
}
