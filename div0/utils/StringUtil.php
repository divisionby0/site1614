<?php

class StringUtil
{
    public static function replaceTwitterTags($s) {
        $s = preg_replace('/([#@][^\s]+)/', '<noindex><a rel="nofollow" href="https://twitter.com/$1">$1</a></noindex>', $s);
        return $s;
    }
    public static function replaceLinks($s) {
        $s = preg_replace('@(https?://([-\w\.]+)+(:\d+)?(/([\w/_\.%-=#]*(\?\S+)?)?)?)@', '<noindex><a rel="nofollow"  href="$1">$1</a></noindex>', $s);
        return $s;
    }

    public static function parseQuestionId($sourceString){
        $id = "";
        $questionIdData = explode("/qa/", $sourceString)[1];

        preg_replace("/[^0-9]/","",'604-619-5135');

        $idCharactersCollection = preg_split('//', $questionIdData, -1, PREG_SPLIT_NO_EMPTY);

        for($i=0; $i<sizeof($idCharactersCollection)-1; $i++ ){
            $id.=$idCharactersCollection[$i];
        }
        return $id;
    }
}