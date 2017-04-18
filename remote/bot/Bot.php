<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/remote/Remote.php');
class Bot extends Remote
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getName($userId){
        $stmt = $this->db->prepare("SELECT username FROM steam_user WHERE id=:id LIMIT 1");
        $stmt->execute(array("id" => $userId));
        $res = $stmt->fetch();
        $botName = $res["username"];
        return $botName;
    }
}