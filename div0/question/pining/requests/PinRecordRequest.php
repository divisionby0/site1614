<?php

include_once($_SERVER['DOCUMENT_ROOT'].'remote/Remote.php');
class PinRecordRequest extends Remote
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function execute($recordId, $duration){

        // find existed record first
        // if exists - update starting today date
        // else create record

        //echo "recordId=".$recordId;

        $currentDate = new DateTime();
        if($duration === "0day"){
            $dateTill = $currentDate;
        }
        else if($duration === "1day"){
            $dateTill = $currentDate->add(new DateInterval("P1D"));
        }
        else if($duration === "2days"){
            $dateTill = $currentDate->add(new DateInterval("P2D"));
        }
        else if($duration === "1week"){
            $dateTill = $currentDate->add(new DateInterval("P7D"));
        }
        else if($duration === "2weeks"){
            $dateTill = $currentDate->add(new DateInterval("P14D"));
        }
        else if($duration === "1month"){
            $dateTill = $currentDate->add(new DateInterval("P1M"));
        }

        if(isset($dateTill)){
            //echo "dateTill = ".$dateTill->format("Y-m-d");

            $formattedDateTill = $dateTill->format("Y-m-d");
            $stmt = $this->db->prepare('UPDATE qa_questions SET pinedTill=:pinedTill WHERE id=:id LIMIT 1');
            $stmt->execute(array("pinedTill" => $formattedDateTill, "id"=>$recordId));
            $result = array("result"=>"complete", "till"=>$formattedDateTill);
            echo json_encode($result);
        }
        else{
            $result = array("result"=>"error", "text"=>"undefined duration");
            echo json_encode($result);
        }

        /*
        $stmt = $this->db->prepare('UPDATE qa_questions SET pinedTill=:pinedTill WHERE id=:id LIMIT 1');
        $stmt->execute(array("id" => $recordId));
        $res = $stmt->fetch();

        $recordIsPinedPreviously = $res === "0000-00-00" ? 1:0;
        
        if($recordIsPinedPreviously == 1){
            // update pinedTill parameter starting today date
        }
        else{
            
        }
        */

        //echo "duration:".$duration;
        
        //return "pined";
    }
}