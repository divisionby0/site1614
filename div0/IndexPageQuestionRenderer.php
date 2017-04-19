<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/div0/utils/RatingColorUtil.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/div0/utils/DateUtil.php');
class IndexPageQuestionRenderer
{
    protected $question;
    protected $containerClass;
    protected $questionHasImage;

    public function __construct($question)
    {
        $this->question = $question;
        $this->containerClass = "question";

        $id = $question["question_id"];
        $title = StringUtil::uppercaseFirstCharacter($question["question_title"]);

        $this->questionHasImage = $question["f_imaged"] == 1 ? true:false;
        $rating = $question["votes"];
        $ratingColor = RatingColorUtil::getColor($rating);
        $creationTimeDuration = DateUtil::showDate($question["when_added"]);
        $author = $question["user_name"];
        $sectionURI = $question["section_uri"];
        $sectionName = $question["section_name"];
        $viewsTotal = $question["views"];
        $totalAnswersText = $question["answers"]? $question["answers"]." ответов" : "Ждёт ответа";

        $this->updateContainerClass();
        
        echo '<div class="'.$this->containerClass.'">';
        $this->updateBadges();

        echo '<table><tr>';

        echo '<td valign="middle" align="center" width="50"><span class="patrons" style="color:#'.$ratingColor.'" title="Кол-во патронов">'.$rating.'</span></td>';
        echo '<td>';

        echo '<div class="svodki_info_news"><span>';
        echo '<b>'.$creationTimeDuration.' от <a href="#" title="Профиль пользователя '.$author.'">'.$author.'</a></b>';
        echo '</span></div>';
        echo '<h4><a href="/qa/'.$id.'">'.$title.'</a></h4>';
        echo '<ul>
                    <li><a href="/qa/'.$sectionURI.'">'.$sectionName.'</a></li>
                    <li>'.$viewsTotal.' просмотров</li>
                    <li>'.$totalAnswersText.'</li>
                  </ul>';

        echo '</td>';

        echo '</tr></table>';

        echo "</div>";
    }

    protected function updateContainerClass(){
    }

    protected function updateBadges(){
        if($this->questionHasImage){
            echo '<img src="/i/img-inside.png" alt="" title="Вопрос подкреплён изображением или скриншотом" />';
        }
    }
}