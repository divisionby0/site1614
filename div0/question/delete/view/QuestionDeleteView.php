<?php


class QuestionDeleteView
{
    public function __construct($id)
    {
        echo '<li><div style="padding-top: 30px;"><a href="#" id="deleteQuestionButton" class="delete deleteQuestionButton" data-questionId="'.$id.'">Удалить вопрос</a></div></li>';
    }
}