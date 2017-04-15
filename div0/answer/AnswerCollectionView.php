<?php


class AnswerCollectionView
{
    private $bestAnswer;
    private $collection;

    public function __construct($collection)
    {
        $this->collection = $collection;
    }
    public function show(){
        foreach ($this->collection as $a)
        {
            $id = $a["answer_id"];
            $class = "comment";
            if($a["level"]==1){
                $class.= " secondlevel";
            }
            else if($a["level"]>1){
                $class.= " thirdlevel";
            }
            $class.= 'cellpadding="0" cellspacing="0"';

            echo '<table class="'.$class.'" id="'.$id.'">';
            echo '<tr>';
            echo '<td valign="top" class="left">';
            echo '';
        }
    }
}