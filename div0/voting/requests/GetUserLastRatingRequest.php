<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/remote/Remote.php');
//include_once ("../../../remote/Remote.php");
class GetUserLastRatingRequest extends Remote
{
    public function __construct()
    {
        parent::__construct();
    }

    public function execute($questionId, $userId){

        $stmt = $this->db->prepare("SELECT vote FROM qa_question_votes WHERE question_id=:question_id AND user_id=:user_id LIMIT 1");
        $stmt->execute(array("question_id" => $questionId, "user_id" => $userId));

        $res = $stmt->fetch();
        echo $res["vote"];
    }
}