<?php


class DateUtil
{
    public static function format($time=0, $use_lables = true){

        if(intval($time)==0){
            $time=time();
        }

        $MonthNames=array("Января", "Февраля", "Марта", "Апреля", "Мая", "Июня", "Июля", "Августа", "Сентября", "Октября", "Ноября", "Декабря");
        $times = [
            5 => 'только что',
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
    
    public static function formatPassedTime($usebold = true, $short = false, $date = false, $startDate = false){
        $curDate = $date ?: $startDate;
        if($short){
            $text = $curDate ==
            strtotime('today') ?
                'Сегодня' :
                ($curDate == strtotime('yesterday') ?
                    'Вчера' : rdate($curDate));
        }
        else {
            $text = $curDate ==
            strtotime('today') ?
                ($usebold ? '<strong>Сегодня,</strong> ' : 'Сегодня, ') :
                ($curDate == strtotime('yesterday') ?
                    ($usebold ? '<strong>Вчера,</strong> ' : 'Вчера, ') : '');
            $text .= rdate($curDate, false);
        }
        return $text;
    }

    public static function showDate( $date ){
        $stf      = 0;
        $cur_time = time();
        $date = strtotime($date);
        $diff     = $cur_time - $date;
        
        $seconds = array( 'секунда', 'секунды', 'секунд' );
        $minutes = array( 'минута', 'минуты', 'минут' );
        $hours   = array( 'час', 'часа', 'часов' );
        $days    = array( 'день', 'дня', 'дней' );
        $weeks   = array( 'неделя', 'недели', 'недель' );
        $months  = array( 'месяц', 'месяца', 'месяцев' );
        $years   = array( 'год', 'года', 'лет' );
        $decades = array( 'десятилетие', 'десятилетия', 'десятилетий' );

        $phrase = array( $seconds, $minutes, $hours, $days, $weeks, $months, $years, $decades );
        $length = array( 1, 60, 3600, 86400, 604800, 2630880, 31570560, 315705600 );

        for ( $i = sizeof( $length ) - 1; ( $i >= 0 ) && ( ( $no = $diff / $length[ $i ] ) <= 1 ); $i -- ) {
            ;
        }
        if ( $i < 0 ) {
            $i = 0;
        }
        $_time = $cur_time - ( $diff % $length[ $i ] );

        $no    = floor( $no );

        $value = sprintf( "%d %s ", $no, self::getPhrase( $no, $phrase[ $i ] ) );

        if ( ( $stf == 1 ) && ( $i >= 1 ) && ( ( $cur_time - $_time ) > 0 ) ) {
            $value .= time_ago( $_time );
        }

        if($value>-1){
            return $value . ' назад';
        }
        else{
            return 'Error. Time past is negative.';
        }
    }
    

    private static function getPhrase( $number, $titles ) {
        $cases = array( 2, 0, 1, 1, 1, 2 );
        if($number>-1){
            return $titles[ ( $number % 100 > 4 && $number % 100 < 20 ) ? 2 : $cases[ min( $number % 10, 5 ) ] ];
        }
        else{
            return null;
        }
    }
}