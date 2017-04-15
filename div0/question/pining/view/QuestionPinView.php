<?php

class QuestionPinView
{
    public function __construct($pinedDate)
    {
        echo '<div><div id="pinedTillContainer"><p style="color: #fff;" id="pinedTillContent">Закреплена до:'.$pinedDate.'</p></div>';
        echo '<div><p style="color: #fff;">Закрепить на</p>';
        echo '<p><select id="pinDurationSelect"><option value="0day">открепить</option><option value="1day">1 день</option><option value="2days">2 дня</option><option value="1week">1 неделю</option><option value="2weeks">2 недели</option><option value="1month">1 месяц</option></select></p>';
        echo '<input type="button" value="Применить" id="pinButton"/>';
        echo '</div>';
    }
}