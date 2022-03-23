<?php
require_once "../includes/connect.php";

    $stmt = $db->prepare("SELECT from_unixtime(UNIX_TIMESTAMP(clm_nw_date),'%y-%M-%D') as date , from_unixtime(UNIX_TIMESTAMP(clm_nw_date),'%W') as time ,
    clm_nw_id , clm_nw_title , clm_nw_desc ,clm_nw_img
    FROM tbl_news WHERE `clm_nw_status` = 'publish' ");

    $stmt->execute();
    
    $row = $stmt->rowcount();
    
    $fetchall = $stmt->fetchall(PDO::FETCH_ASSOC);
    
    $news = array();
    $data = array();

    if($row > 0){
    
        foreach($fetchall as $fetch){
            $fetch["check"] = "fall" ;
            array_push($news,$fetch) ;
        }   $data =  $news ;
    }else{
        $data =  [array("check" => "empty")];
    }
    echo json_encode($data , JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
  $db = null ;
?>