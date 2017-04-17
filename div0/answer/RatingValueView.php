<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/div0/utils/RatingColorUtil.php');
class RatingValueView
{
    public function __construct($rating, $answerId)
    {
        $color = RatingColorUtil::getColor($rating);
        echo "<strong style='color: #".$color.";' title='Кол-во патронов' id='avotes".$answerId."'>".$rating."</strong>";
    }
}