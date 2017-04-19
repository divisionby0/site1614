<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/div0/IndexPageQuestionRenderer.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/div0/IndexPagePinedQuestionRenderer.php');
class IndexPageQuestionCollectionView
{
    private $collection;
    
    public function __construct($collection)
    {
        $this->collection = $collection;

        $pinedQuestions = array();
        $notPinedQuestions = array();

        foreach($this->collection as $question){
            //new IndexPageQuestionRenderer($question);
            $currentTime = time();
            $pinedTillTime = strtotime($question["pinedTill"]);

            if($pinedTillTime > $currentTime){
                array_push($pinedQuestions, $question);
            }
            else{
                array_push($notPinedQuestions, $question);
            }
        }

        foreach($pinedQuestions as $question){
            new IndexPagePinedQuestionRenderer($question);
        }
        
        foreach($notPinedQuestions as $question){
            new IndexPageQuestionRenderer($question);
        }
    }
}