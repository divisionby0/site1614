<?php

class ModificationDateTimeView
{
    public function __construct($lastModifiedDateTime, $createdDateTime, $modificationAuthor)
    {
        $modificationTime = strtotime($lastModifiedDateTime);
        $creationTime = strtotime($createdDateTime);

        if($modificationTime!=$creationTime){
            echo "<div class='edited' id='questionModificationDateTimeElement'>Последний раз редактировалось ".$lastModifiedDateTime.". Редактор: ".$modificationAuthor."</div>";
        }
        else{
            echo "<div class='edited' id='questionModificationDateTimeElement'></div>";
        }
    }
}