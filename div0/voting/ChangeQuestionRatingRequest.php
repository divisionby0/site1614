<?php

include_once ("../../../remote/Remote.php");
class ChangeQuestionRatingRequest extends Remote
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function execute($questionId, $value, $userId){
        
        // update vote record 
        $stmt = $this->db->prepare("SELECT id FROM qa_question_votes WHERE question_id=:question_id AND user_id=:user_id LIMIT 1");
        $stmt->execute(array("question_id" => $questionId, "user_id" => $userId));
        if ($res = $stmt->fetch())
        {
            $stmt = $this->db->prepare("UPDATE qa_question_votes SET vote=:vote WHERE id=:id LIMIT 1");
            $stmt->execute(array("vote" => $value, "id" => $res["id"]));
        }
        else
        {
            $stmt = $this->db->prepare("INSERT INTO qa_question_votes SET question_id=:question_id, user_id=:user_id, vote=:vote");
            $stmt->execute(array("question_id" => $questionId, "user_id" => $userId, "vote" => $value));
        }
        
        // update question rating
        $rating=0;
        $stmt = $this->db->prepare("SELECT vote FROM qa_question_votes WHERE question_id=:question_id");
        $stmt->execute(array("question_id" => $questionId));

        foreach($stmt->fetchAll() as $v) {
            $rating+=$v["vote"];
        }

        $stmt = $this->db->prepare("UPDATE qa_questions SET votes=:votes WHERE id=:question_id");
        $stmt->execute(array("votes" => $rating, "question_id" => $questionId));
        
        return $rating;
    }
}