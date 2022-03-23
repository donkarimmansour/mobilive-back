<?php

require_once "../includes/connect.php";

    $stmt = $db->prepare("SELECT * FROM tbl_channel WHERE clm_cn_id != -1 AND `clm_cn_status` = 'publish'");
   
    $stmt->execute();
   
    $row = $stmt->rowcount();
   
    $fetchall = $stmt->fetchall(PDO::FETCH_ASSOC);
    
    $channels = array();
    $data = array();
    
    if($channels > 0){
    
        foreach($fetchall as $fetch){
            $fetch["check"] = "fall" ;
            array_push($channels,$fetch) ;
     }   $data =  $channels ;
    }else{
        $data =  [array("check" => "empty")];
    }
    echo json_encode($data , JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
$db = null ;
?>
