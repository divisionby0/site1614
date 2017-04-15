<?php


class QuestionEditView
{
    public function __construct($id)
    {
        echo '<td><input id="editQuestionButton" value="Редактировать вопрос" type="button" data-questionId="'.$id.'"/><input id="updateEditedQuestionButton" value="Сохранить изменения" type="button" data-questionId="'.$id.'" style="display:none;"/></td>';
    }
}