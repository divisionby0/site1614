<?php


class UserDataParser
{
    public function __construct()
    {
        
    }
    
    public function parse(){
        if(isset($_SESSION['steam_user'])){
            if(isset($_SESSION['steam_user']['user_id'])){
                return $_SESSION['steam_user']['user_id'];
            }
        }
        return null;
    }
}