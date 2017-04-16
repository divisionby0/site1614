<?php

class DeleteAnswerView
{
    public function __construct($answerId, $questionId)
    {
        echo "<input id='deleteAnswerButton".$answerId."' class='deleteAnswerButton' type='button' value='Удалить комментарий' data-answerid='".$answerId."' data-questionid='".$questionId."'>";
    }
}