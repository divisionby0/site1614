<?php

class AnswerModerationView
{
    public function __construct($userAccess, $answer, $questionId, $userId)
    {
        if($userAccess === "1" || $userAccess === "2" || $userAccess === "3"){
            echo "<div id='editAnswerHeader".$answer["answer_id"]."' style='width: 100%; text-align:center; color:red; display: none; padding: 20px;'><h1>Редактирование комментарий</h1></div>";
            echo "<textarea class='editAnswerTextArea' id='editAnswerTextArea".$answer["answer_id"]."' style='display: none; height: 500px;' cols='30' rows='2'>".$answer["answer_text"]."</textarea>";
            //echo "<table id='editAnswerControlsContainer".$answer["answer_id"]."'><tbody>";

            new AnswerEditView($answer["answer_id"], $questionId);
            new DeleteAnswerView($answer["answer_id"], $questionId);
            
            //echo "</tbody></table>";
        }
    }
}