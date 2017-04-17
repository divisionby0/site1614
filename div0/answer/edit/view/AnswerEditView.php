<?php


class AnswerEditView
{
    public function __construct($answerId, $questionId)
    {
        echo '<li><div style="display: inline-block;" id="editAnswerButton'.$answerId.'" class="editAnswerButton" data-questionId="'.$questionId.'" data-answerid="'.$answerId.'">Редактировать</div><input id="updateEditedAnswerButton'.$answerId.'" class="updateEditedAnswerButton answerEditingStateButton" value="Сохранить изменения" type="button" data-answerId="'.$answerId.'" data-questionId="'.$questionId.'" style="display:none;"><input class="cancelEditAnswerButton answerEditingStateButton" id="cancelEditAnswerButton'.$answerId.'" value="Отменить изменение" type="button" data-answerId="'.$answerId.'" data-questionId="'.$questionId.'" style="display:none;"></li>';
    }
}