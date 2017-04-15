<?php


class QuestionDeleteView
{
    public function __construct($id)
    {
        echo '<td><input id="deleteQuestionButton" value="Удалить вопрос" type="button" data-questionId="'.$id.'"/></td>';
    }
}