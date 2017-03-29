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
}