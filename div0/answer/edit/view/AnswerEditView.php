<?php


class AnswerEditView
{
    public function __construct($answerId, $questionId)
    {
        echo '<td><input id="editAnswerButton'.$answerId.'" class="editAnswerButton" value="Редактировать комментарий" type="button" data-questionId="'.$questionId.'" data-answerid="'.$answerId.'"/><input id="updateEditedAnswerButton'.$answerId.'" class="updateEditedAnswerButton" value="Сохранить изменения" type="button" data-answerId="'.$answerId.'" data-questionId="'.$questionId.'" style="display:none;"/></td>';
    }
}