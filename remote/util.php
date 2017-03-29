<?php

function rdate($time=0, $use_lables = true) {
    if(intval($time)==0)$time=time();
    $MonthNames=array("Января", "Февраля", "Марта", "Апреля", "Мая", "Июня", "Июля", "Августа", "Сентября", "Октября", "Ноября", "Декабря");
    $times = [
        5 => 'Только что',
        10 => '5 минут назад',
        15 => '10 минут назад',
        60 => 'менее часа назад',
        120 => 'час назад',
    ];

    if($use_lables){
        $now = time();
        $minutesAgo = ($now - $time) /  60;
        foreach($times as $maxTime => $label){
            if($minutesAgo < $maxTime){
                return $label;
            }
        }
        if($time > strtotime('today')){
            return 'сегодня';
        }
        if($time > strtotime('yesterday')){
            return 'вчера';
        }
    }

    $format = 'd M Y';
    return date(str_replace(array('M', 'Y'),array($MonthNames[date('n',$time)-1], date('Y', $time) == date('Y') ? '' : date('Y', $time)),$format), $time);
}

function replaceLinks($s) {
    $s = preg_replace('@(https?://([-\w\.]+)+(:\d+)?(/([\w/_\.%-=#]*(\?\S+)?)?)?)@', '<noindex><a rel="nofollow"  href="$1">$1</a></noindex>', $s);
    return $s;
}

function replaceTwitterTags($s) {
    $s = preg_replace('/([#@][^\s]+)/', '<noindex><a rel="nofollow" href="https://twitter.com/$1">$1</a></noindex>', $s);
    return $s;
}
?>