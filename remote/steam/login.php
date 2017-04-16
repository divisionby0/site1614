<?php
session_start();
require_once('steamsignin.php');
if(isset($_GET['a']) && $_GET['a'] == 'logout')
{
    unset($_SESSION['steam_user']);
}
else
{
    $steamId = SteamSignIn::validate();
    if($steamId){
        $steam = new SteamSignIn();
        $_SESSION['steam_user']['id'] = $steamId;

        $userInfo = SteamSignIn::userInfo($_SESSION['steam_user']['id']);
        $_SESSION['steam_user']['name'] = $userInfo->response->players[0]->personaname;
        $_SESSION['steam_user']['avatar'] = $userInfo->response->players[0]->avatar;
        $steam->saveUser($_SESSION['steam_user']);
		
        $userData = $steam->getUserByRemoteID($_SESSION['steam_user']['id']);

        $_SESSION['steam_user']['role'] = $userData["role_id"];
        $_SESSION['steam_user']['user_id'] = $userData["id"];
        $_SESSION['steam_user']['access'] = $userData["access"];
    }
}
if(isset($_GET['a']) && $_GET['a'] == 'tst'){
    var_dump($_SESSION);
    die();
}
header('Location: /');