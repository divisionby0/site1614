<?php

class FakeUser
{
    public function create(){
        $_SESSION['steam_user'] = array('name'=>'Ilya','user_id'=>'76561198370245401','avatar'=>'http://site1614/i/temp_ava.jpg');
    }
}