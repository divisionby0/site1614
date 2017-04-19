<?php


class QuestionEditView
{
    public function __construct($id, $questionAuthorId, $userId)
    {
        echo '<li><div style="padding-top: 30px;"><div id="editQuestionButton" class="editQuestionButton" data-questionId="'.$id.'">Редактировать вопрос</div>';
        echo '<input id="updateEditedQuestionButton" value="Сохранить изменения" type="button" data-questionId="'.$id.'" style="display:none;"/>';
        echo '<input id="cancelUpdatingEditedQuestionButton" value="Отменить изменения" type="button" data-questionId="'.$id.'" style="display:none;"/>';
        echo '</li>';
    }
}