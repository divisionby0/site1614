<?php

class DeleteAnswerView
{
    public function __construct($id)
    {
        echo "<input id='deleteAnswerButton".$id."' class='deleteAnswerButton' type='button' value='Удалить комментарий' data-answerid='".$id."'>";
    }
}