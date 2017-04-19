<?php


class QuestionDeleteView
{
    public function __construct($id)
    {
        echo '<li><a href="#" id="deleteQuestionButton" class="delete deleteQuestionButton" data-questionId="'.$id.'">Удалить вопрос</a></li>';
    }
}