<?php

class QuestionModerationView
{
    // 1- moderator
    // 2 - newsmaker
    // 3 - user
    public function __construct($questionId, $userAccess, $question, $sections, $userId)
    {
        $isModerator = $userAccess ===  "1";
        $isNewsmaker = $userAccess ===  "2";
        $isUser = $userAccess ===  "3";

        $questionSection = $question["section_id"];
        $questionPinedDate = $question["pinedTill"];

        $isOwn = 0;

        $questionAuthor = $question["user_id"];
        if($questionAuthor === $userId){
            $isOwn = 1;
        }

        echo "<ul id='editQuestionContainer' style='width: 100%;' class='editQuestionControlsContainer'>";
        if($isModerator){
            new QuestionPinView($questionPinedDate);
            $this->showQuestionEdit($question, $sections, $questionSection, $questionId, $userId);
            new QuestionDeleteView($questionId);
        }
        else if(($isNewsmaker || $isUser) && $isOwn == 1){
            $this->showQuestionEdit($question, $sections, $questionSection, $questionId, $userId);
            new QuestionDeleteView($questionId);
        }

        echo "</ul>";
    }

    private function createQuestionEditElement($question){
        echo "<div id='editQuestionHeader' style='width: 100%; text-align:center; color:red; display: none; padding: 20px;'>";
        echo "<h1>Редактирование вопроса</h1></div>";
        echo "<input type='text' id='questionTitleInput' value='".$question["question_title"]."' style='display:none;' class='editQuestionTitleInput'>";
        echo "<textarea id='editQuestionTextArea' style='display: none; height: 500px;' cols='30' rows='8'>".$question["question_text"]."</textarea>";
    }

    private function showQuestionEdit($question, $sections, $questionSection, $questionId, $userId){
        $this->createQuestionEditElement($question);
        $this->createQuestionSectionSelectionElement($sections, $questionSection);
        new QuestionEditView($questionId, $question["user_id"], $userId);
    }

    private function createQuestionSectionSelectionElement($sections, $questionSection){
        echo "<div id='editQuestionSectionsContainer' style='display: none;'><select id='editQuestionSectionsSelect' class='editQuestionSectionsSelect'>";

        foreach($sections as $section){

            if($section["id"] === $questionSection){
                echo "<option value='".$section["id"]."' selected='selected' data-url='"."/qa/".$section["uri"]."/'>".$section["name"]."</option>";
            }
            else{
                echo "<option value='".$section["id"]."' data-url='"."/qa/".$section["uri"]."/'>".$section["name"]."</option>";
            }
        }
        echo "</select><input type='text' id='questionSectionInput' value='".$questionSection."' style='display:none;'></div>";
    }
}