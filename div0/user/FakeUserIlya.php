<?php

class FakeUserIlya
{
    public function create(){
        $_SESSION['steam_user'] = array('name'=>'Ilya','user_id'=>'3','avatar'=>'http://site1614/i/temp_ava.jpg', 'id'=>'123');
    }
}