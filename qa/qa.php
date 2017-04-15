<?php
require_once(__DIR__ . '/../remote/Remote.php');

class QA extends Remote{
	
	public function __construct()
	{
		parent::__construct();
	}

    function getSections($limit = 0){
        $stmt = $this->db->prepare("SELECT * FROM qa_sections ORDER BY questions_number DESC".($limit ? " LIMIT ".$limit : ""));
        $stmt->execute();
		$sections=array();
        while ($res = $stmt->fetch()) $sections[]=$res;
        return $sections;
    }

    function getSection($id = 0){
		if (!$id) return NULL;
        $stmt = $this->db->prepare("SELECT * FROM qa_sections WHERE id=:section_id LIMIT 1");
        $stmt->execute(array("section_id" => $id));
        return $stmt->fetch();
    }

    function getSectionByURI($uri = ''){
		if (!$uri) return NULL;
        $stmt = $this->db->prepare("SELECT * FROM qa_sections WHERE uri like '".addslashes($uri)."' LIMIT 1");
        $stmt->execute();
		$res=$stmt->fetch();
        return $res;
    }

    function getQuestionsFromSection($SectionID, $limit){
        $stmt = $this->db->prepare("SELECT * FROM qa_sections ORDER BY ordering");
        $stmt->execute();
        $res = $stmt->fetch();
        return $res;
    }

    function getUnansweredQuestionsCount(){
        $stmt = $this->db->prepare("SELECT COUNT(id) FROM qa_questions where answers=0");
        $stmt->execute();
        $res = $stmt->fetch();
        return $res;
    }

    function getQuestions($where="", $order="qq.when_added"){
        $stmt = $this->db->prepare("SELECT 
			qq.id as question_id,
			qs.name as section_name,
			qs.uri as section_uri,
			qq.title as question_title,
			qq.when_added as when_added,
			qq.views as views,
			qq.votes as votes,
			qq.answers as answers,
			qq.f_imaged as f_imaged,
			qq.f_sticked as f_sticked,
			su.username as user_name
			FROM qa_questions qq, qa_sections qs, steam_user su WHERE qq.section_id=qs.id AND qq.user_id=su.id ".($where ? " AND ".$where : "")." ORDER BY ".$order." DESC");
        $stmt->execute();
        $res = $stmt->fetchAll();
        return $res;
    }


    function getQuestion($id=0, $UserID=0){
		if (!$id) return NULL;
		
        $stmt = $this->db->prepare("SELECT 
			qs.name as section_name,
			qs.uri as section_uri,
			qs.id as section_id,
			qq.title as question_title,
			qq.text as question_text,
			qq.when_added as when_added,
			qq.when_edited as when_edited,
			qq.pinedTill as pinedTill,
			qq.views as views,
			qq.votes as votes,
			qq.answers as answers,
			qq.f_approved as f_approved,
			su.avatar_url as user_avatar,
			su.username as user_name
			FROM qa_questions qq, qa_sections qs, steam_user su WHERE qq.id=:question_id AND qq.section_id=qs.id AND qq.user_id=su.id ".($where ? " AND ".$where : "")." limit 1");
        $stmt->execute(array("question_id" => $id));
        $res = $stmt->fetch();
		
		// Проверяем голос пользователя
		if ($UserID) {
			$res["user_vote"]=0;
			$stmt = $this->db->prepare("SELECT vote FROM qa_question_votes WHERE question_id=:question_id AND user_id=:user_id LIMIT 1");
			$stmt->execute(array("question_id" => $id, "user_id" => $UserID));
			if($r=$stmt->fetch()) $res["user_vote"]=$r["vote"];
		}
		
        return $res;
    }

    function viewQuestion($id=0){
		if (!$id) return NULL;
		
        $stmt = $this->db->prepare("SELECT views FROM qa_questions WHERE id=:question_id LIMIT 1");
        $stmt->execute(array("question_id" => $id));
        $res = $stmt->fetch();
		
        $stmt = $this->db->prepare("UPDATE qa_questions SET views=:views WHERE id=:question_id LIMIT 1");
        $stmt->execute(array("views" => $res["views"]+1, "question_id" => $id));
        return;
    }

    function addQuestion($question){

		$hasImage = "0";
		$currentDate = new DateTime();
		$pos = strpos($question["text"], "<img src=");
		if(isset($pos) && $pos!==false){
			$hasImage = "1";
		}

        $stmt = $this->db->prepare("INSERT INTO qa_questions SET section_id=:section_id, title=:title, text=:text, when_added=NOW(), user_id=:user_id, f_imaged=:imaged, pinedTill=:pinedTill");


        $stmt->execute(
			array(
				":section_id" => $question["section_id"],
				":title" => $question["title"],
				":text" => $question["text"],
				":user_id" => $question["user_id"],
				":imaged" => $hasImage,
				":pinedTill" => $currentDate->format("Y-m-d")
			)
		);

		if ($LastInsertID=$this->db->lastInsertId())
		{
			$stmt = $this->db->prepare("UPDATE qa_sections SET questions_number=(SELECT COUNT(id) FROM qa_questions WHERE section_id=:section_id) WHERE id=:section_id LIMIT 1");
			$stmt->execute(
				array(
					":section_id" => $question["section_id"]
					)
			);
		}
		
		return $LastInsertID;
    }

    function addAnswer($answer){
		#echo "<pre>"; print_r($answer); echo "</pre>"; exit;
        $stmt = $this->db->prepare("INSERT INTO qa_answers SET question_id=:question_id, parent_id=:parent_id, text=:text, when_added=NOW(), user_id=:user_id");
        $stmt->execute(
			array(
				":question_id" => $answer["question_id"],
				":parent_id" => $answer["parent_id"],
				":text" => $answer["text"],
				":user_id" => $answer["user_id"]
			)
		);
		
		if ($LastInsertID=$this->db->lastInsertId())
		{
			$stmt = $this->db->prepare("UPDATE qa_questions SET answers=(SELECT COUNT(id) FROM qa_answers WHERE question_id=:question_id) WHERE id=:question_id LIMIT 1");
			$stmt->execute(
				array(
					":question_id" => $answer["question_id"]
					)
			);
		}
		
		return $LastInsertID;
    }

    function getAnswers($ID, $level=0, $UserID, $parent_answer=array()){
        $stmt = $this->db->prepare("SELECT 
			qa.id as answer_id,
			qa.parent_id as parent_answer_id,
			qa.text as answer_text,
			qa.when_added as when_added,
			qa.votes as votes,
			su.username as user_name,
			su.avatar_url as user_avatar_url,
			su.role_id as user_role_id
			FROM qa_answers qa, steam_user su WHERE ".($level ? "parent_id" : "parent_id=0 AND question_id")."=:id AND qa.user_id=su.id ORDER BY when_added DESC");
        $stmt->execute(array("id" => $ID));
		
		$answers=array();
        foreach ($stmt->fetchAll() as $a)
		{
			$answer=$a;
			$answer["level"]=$level;
			$answer["to_whom"]=($parent_answer ? $parent_answer["user_name"] : "");
			
			// Проверяем голос пользователя
			if ($UserID) {
				$answer["user_vote"]=0;
				$s = $this->db->prepare("SELECT vote FROM qa_answer_votes WHERE answer_id=:answer_id AND user_id=:user_id LIMIT 1");
				$s->execute(array("answer_id" => $answer["answer_id"], "user_id" => $UserID));
				if($r=$s->fetch()) $answer["user_vote"]=$r["vote"];
			}
		
			$answers[]=$answer;
			
			$answers=array_merge ($answers, $this->getAnswers($a["answer_id"], $level+1, $UserID, $answer));
		}
		
        return $answers;
    }

	function voteQuestion($UserID, $QuestionID, $HowToVote) {
		if ($HowToVote=="plus") $HTV=1;
		if ($HowToVote=="minus") $HTV=-1;
		
		if ($HTV) {
			$stmt = $this->db->prepare("SELECT id FROM qa_question_votes WHERE question_id=:question_id AND user_id=:user_id LIMIT 1");
			$stmt->execute(array("question_id" => $QuestionID, "user_id" => $UserID));
			if ($res = $stmt->fetch())
			{
				$stmt = $this->db->prepare("UPDATE qa_question_votes SET vote=:vote WHERE id=:id LIMIT 1");
				$stmt->execute(array("vote" => $HTV, "id" => $res["id"]));
			}
			else
			{
				$stmt = $this->db->prepare("INSERT INTO qa_question_votes SET question_id=:question_id, user_id=:user_id, vote=:vote");
				$stmt->execute(array("question_id" => $QuestionID, "user_id" => $UserID, "vote" => $HTV));
			}
		}
		
		// Подсчитываем количество голосов за вопрос (заменить SQL)
		$VotesSum=0;
        $stmt = $this->db->prepare("SELECT vote FROM qa_question_votes WHERE question_id=:question_id");
        $stmt->execute(array("question_id" => $QuestionID));

		foreach($stmt->fetchAll() as $v) {
			$VotesSum+=$v["vote"];
		}
		
        $stmt = $this->db->prepare("UPDATE qa_questions SET votes=:votes WHERE id=:question_id");
        $stmt->execute(array("votes" => $VotesSum, "question_id" => $QuestionID));
		
		return $VotesSum;
	}
	
	function voteAnswer($UserID, $AnswerID, $HowToVote) {
		if ($HowToVote=="plus") $HTV=1;
		if ($HowToVote=="minus") $HTV=-1;


		if ($HTV) {
			$stmt = $this->db->prepare("SELECT id FROM qa_answer_votes WHERE answer_id=:answer_id AND user_id=:user_id LIMIT 1");
			$stmt->execute(array("answer_id" => $AnswerID, "user_id" => $UserID));
			if ($res = $stmt->fetch())
			{
				$stmt = $this->db->prepare("UPDATE qa_answer_votes SET vote=:vote WHERE id=:id LIMIT 1");
				$stmt->execute(array("vote" => $HTV, "id" => $res["id"]));
			}
			else
			{
				$stmt = $this->db->prepare("INSERT INTO qa_answer_votes SET answer_id=:answer_id, user_id=:user_id, vote=:vote");
				$stmt->execute(array("answer_id" => $AnswerID, "user_id" => $UserID, "vote" => $HTV));
			}
		}
		
		// Подсчитываем количество голосов за вопрос (заменить SQL)
		$VotesSum=0;
        $stmt = $this->db->prepare("SELECT vote FROM qa_answer_votes WHERE answer_id=:answer_id");
        $stmt->execute(array("answer_id" => $AnswerID));

		foreach($stmt->fetchAll() as $v) {
			$VotesSum+=$v["vote"];
		}

		if($VotesSum<0){
			$VotesSum = 0;
		}

        $stmt = $this->db->prepare("UPDATE qa_answers SET votes=:votes WHERE id=:answer_id");
        $stmt->execute(array("votes" => $VotesSum, "answer_id" => $AnswerID));
		
		return $VotesSum;
	}
}
