<?php


class QuestionEditView
{
    public function __construct($id, $questionAuthorId, $userId)
    {
        echo '<li><div id="editQuestionButton" class="editQuestionButton" data-questionId="'.$id.'">Редактировать вопрос</div><input id="updateEditedQuestionButton" value="Сохранить изменения" type="button" data-questionId="'.$id.'" style="display:none;"/></li>';
    }
}