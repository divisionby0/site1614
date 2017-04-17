<?php

class DeleteAnswerView
{
    public function __construct($answerId, $questionId)
    {
        echo "<li><a href='#' id='deleteAnswerButton".$answerId."' class='delete deleteAnswerButton' data-answerid='".$answerId."' data-questionid='".$questionId."'>Удалить</a></li>";
    }
}