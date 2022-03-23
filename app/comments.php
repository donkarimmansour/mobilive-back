<?php

require_once "../includes/connect.php";

if(isset($_GET["matchId"]) && isset($_GET["msg"]) ){

    if(isset($_GET["user_id"])){

    $stmt = $db->prepare("INSERT INTO `tbl_chat_room` (`clm_cr_msg`, `clm_cr_match_id`, `clm_cr_user_id`) VALUES (? ,? ,?)");
    $stmt->execute(array(  $_GET["msg"] , $_GET["matchId"] , $_GET["user_id"] ));
    }else{

    $stmt = $db->prepare("INSERT INTO `tbl_chat_room` (`clm_cr_msg`, `clm_cr_match_id`, `clm_cr_user_id`) VALUES (? ,? ,-1)");
    $stmt->execute(array(  $_GET["msg"] , $_GET["matchId"]));
    }
}
else{
    $data = array();

    if(isset($_GET["match_id"])){

        $stmt = $db->prepare("SELECT tbl_chat_room.* , tbl_users.*  , tbl_chat_room.clm_cr_user_id
        FROM tbl_chat_room 
        JOIN tbl_users
        ON tbl_chat_room.clm_cr_user_id = tbl_users.clm_u_id 
        WHERE tbl_chat_room.clm_cr_match_id = ? 
        ORDER BY clm_cr_id ASC");
       
        $stmt->execute(array($_GET["match_id"]));
       
        $row = $stmt->rowcount();
       
        $fetchall = $stmt->fetchall(PDO::FETCH_ASSOC);
        $comments= array();
        
      if($row > 0){
           
            foreach($fetchall as $fetch){
                $fetch["check"] = "fall" ;
                array_push($comments,$fetch) ;
           }

         $data = $comments;
        
        }//row
        else{
            $data =  [array("check" => "empty")];
        }
        } // end if match_id 
        else{
            $data =  [array("check" => "empty")];
        }

        echo json_encode($data , JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
    }// else
    

    $db = null ;
?>
