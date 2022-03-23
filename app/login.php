<?php
require_once "../includes/connect.php";

if(isset($_GET["user_email"]) && isset($_GET["pass"])){

$user_email = $_GET["user_email"];
$pass = $_GET["pass"];



$stmt = $db->prepare("SELECT `clm_u_id`,  `clm_u_username`, `clm_u_email` , `clm_u_password` FROM `tbl_users` 
WHERE  (`clm_u_username` = ? OR `clm_u_email` = ?) AND `clm_u_password` = ? AND clm_u_id != ?" );

$stmt->execute(array($user_email , $user_email ,md5($pass), "-1" ));
$fetch = $stmt->fetch();
$row = $stmt->rowcount();

if($row > 0){

$stmt = $db->prepare("SELECT * FROM  `tbl_users` WHERE `clm_u_id` = ? ");
$stmt->execute(array($fetch["clm_u_id"]));

$fetch = $stmt->fetch(PDO::FETCH_ASSOC);
$error = array("error" => "null");
$add = array_merge($fetch,$error);

echo json_encode($add);
}
else{

    $stmt = $db->prepare("SELECT `clm_u_username`, `clm_u_email`  FROM `tbl_users` WHERE   (`clm_u_username` = ? OR `clm_u_email` = ?)  " );
    
    $stmt->execute(array($user_email,$user_email));
    
    $row = $stmt->rowcount();
    
    if($row > 0){
        echo json_encode(array("error" => "Password Is Not Correct"));
    
    }else{
        echo json_encode(array("error" => "Email Or Username  Is Not Correct"));
    }

}//else


}//f
else{
    echo json_encode( array("error" => "null") );
    
}



$db = null ;

?>

 