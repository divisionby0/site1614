<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/remote/Remote.php');
class GetRatingRequest extends Remote
{
    public function __construct()
    {
        parent::__construct();
    }

    public function execute($entityCurrentId){
        $entityId = $this->getEntityId();
        $tableName = $this->getTableName();

        $stmt = $this->db->prepare("SELECT votes FROM ".$tableName." WHERE id=:".$entityId." LIMIT 1");
        $stmt->execute(array($entityId => $entityCurrentId));
        $res = $stmt->fetch();
        echo $res["votes"];
    }

    protected function getEntityId(){
    }
    protected function getTableName(){
    }
}