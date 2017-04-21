<?php

class AnswerModificationDateTimeView
{
    public function __construct($lastModifiedDateTime, $createdDateTime, $modificationAuthor, $answerId)
    {
        $modificationTime = strtotime($lastModifiedDateTime);
        $creationTime = strtotime($createdDateTime);

        if($modificationTime!=$creationTime){
            echo "<div id='answerModificationInfoContainer".$answerId."' class='answerModifierInfo'>Последний раз редактировалось ".$lastModifiedDateTime.". Редактор: ".$modificationAuthor."</div>";
        }
        else{
            echo "<div class='answerModifierInfo' id='answerModificationInfoContainer".$answerId."'></div>";
        }
    }
}