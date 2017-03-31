<?php


class FakeUserBoris
{
    public function create(){
        $_SESSION['steam_user'] = array('name'=>'BoriZZ','user_id'=>'12','avatar'=>'http://site1614/i/temp_ava.jpg', 'id'=>'321');
    }
}