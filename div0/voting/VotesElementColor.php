<?php

class VotesElementColor
{
    private static $colors = array("#91860b", "#a39d58", "#d6cf7c", "#ffea47", "#ffbf2a");
    public static function calculate($total){
        if($total == 0){
            return self::$colors[0];
        }
        else if($total > 3 && $total < 6){
            return self::$colors[1];
        }
        else if($total > 5 && $total < 9){
            return self::$colors[3];
        }
        else if($total > 8 && $total < 12){
            return self::$colors[4];
        }
        else if($total > 11){
            return self::$colors[4];
        }
    }
}