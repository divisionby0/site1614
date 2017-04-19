<?php

class IndexPagePinedQuestionRenderer extends IndexPageQuestionRenderer
{
    public function __construct($question)
    {
        parent::__construct($question);
    }

    protected function updateContainerClass(){
        $this->containerClass.= " sticked";
    }

    protected function updateBadges(){
        parent::updateBadges();
        echo '<img src="/i/img-sticked.png" alt="" title="Закреплено">';
    }
}