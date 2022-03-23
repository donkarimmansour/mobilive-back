<?php
require_once "../includes/connect.php";


$stmt = $db->prepare("SELECT * FROM tbl_matches WHERE `clm_m_status` = 'publish' ");

$stmt->execute();

$row = $stmt->rowcount();

$fetchall = $stmt->fetchall(PDO::FETCH_ASSOC);

$matches = array();
$data = array();

if($row > 0){

    foreach($fetchall as $fetch){
        $fetch["check"] = "fall" ;
        array_push($matches,$fetch) ;
    }
    $data =  $matches ;
}else{
    $data =  [array("check" => "empty")];
}
echo json_encode($data , JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
$db = null ;
exit();
?>