<?php

include_once ("../../../remote/Remote.php");
class ChangeRatingRequest extends Remote
{
    public function __construct()
    {
        parent::__construct();
    }

    public function execute($entityCurrentId, $value, $userId){
        $entityId = $this->getEntityId();
        $tableName = $this->getTableName();

        $stmt = $this->db->prepare('SELECT id FROM '.$tableName.' WHERE '.$entityId.'=:'.$entityId.' AND user_id=:user_id LIMIT 1');
        $stmt->execute(array($entityId => $entityCurrentId, "user_id" => $userId));
        if ($res = $stmt->fetch())
        {
            $stmt = $this->db->prepare("UPDATE ".$tableName." SET vote=:vote WHERE id=:id LIMIT 1");
            $stmt->execute(array("vote" => $value, "id" => $res["id"]));
        }
        else
        {
            $stmt = $this->db->prepare("INSERT INTO ".$tableName." SET ".$entityId."=:".$entityId.", user_id=:user_id, vote=:vote");
            $stmt->execute(array($entityId => $entityCurrentId, "user_id" => $userId, "vote" => $value));
        }
        
        // update question rating
        $rating=0;
        $stmt = $this->db->prepare("SELECT vote FROM ".$tableName." WHERE ".$entityId."=:".$entityId);
        $stmt->execute(array("question_id" => $entityCurrentId));

        foreach($stmt->fetchAll() as $v) {
            $rating+=$v["vote"];
        }

        $this->updateEntityAggregationTable($rating, $entityId, $entityCurrentId);
        
        return $rating;
    }

    protected function updateEntityAggregationTable($rating, $entityId, $entityCurrentId){
        $stmt = $this->db->prepare("UPDATE qa_questions SET votes=:votes WHERE id=:".$entityId);
        $stmt->execute(array("votes" => $rating, $entityId => $entityCurrentId));
    }


    protected function getEntityId(){
        return "question_id";
    }
    protected function getTableName(){
        return "qa_question_votes";
    }
}