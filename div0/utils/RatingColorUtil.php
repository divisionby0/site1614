<?php


class RatingColorUtil
{
    public static function getColor($rating){
        $colors = array("91860b", "a39d58", "d6cf7c", "ffea47", "ffbf2a");
        $rating = intval($rating);

        if($rating > -1 && $rating < 3){
            return $colors[0];
        }
        else if($rating > 3 && $rating < 6){
            return $colors[1];
        }
        else if($rating > 5 && $rating < 9){
            return $colors[2];
        }
        else if($rating > 8 && $rating < 12){
            return $colors[3];
        }
        else if($rating > 11){
            return $colors[4];
        }
    }
}