<?php


class QuestionCollectionSorterByAnswersTotal
{
    
    public function __construct($collection)
    {
        function compareFunction($a, $b)
        {
            $item1AnswersTotal = intval($a["answers"]);
            $item2AnswersTotal = intval($b["answers"]);
            return $item1AnswersTotal > $item2AnswersTotal;
        }

        usort($collection, "compareFunction");
    }
}