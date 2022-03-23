<?php
require_once "../includes/connect.php";

if(isset($_POST["image"]) && isset($_POST["user"]) && isset($_POST["pass"]) && isset($_POST["user_id"]) && isset($_POST["user_id"])){

$image = $_POST["image"] ;
$user =  $_POST["user"];
$pass =  $_POST["pass"];
$user_id =  $_POST["user_id"];
$key =  $_POST["key"];

$root = $_SERVER["DOCUMENT_ROOT"];
$dir = $root . "/live/images/img_user/";
$puth = $dir . $key ;

if(!is_dir($dir) ) {
 mkdir($dir, 0755, true);
}

if($image != "empty" && $pass != "null"){
 if(file_put_contents($puth,base64_decode($_POST["image"]))) {
   $stmt = $db->prepare("UPDATE `tbl_users` 
    SET `clm_u_username` = ? , `clm_u_password` = ? , `clm_u_img` = ?
    WHERE `clm_u_id` = ? " );
    $stmt->execute(array($user ,md5($pass) ,$key,$user_id));
     echo "Success Update Photo" ;
 }
else{
  echo "Sorry There Was An Error" ;
}  
}
else if ($image != "empty" && $pass == "null"){
 if(file_put_contents($puth,base64_decode($_POST["image"]))) {
  $stmt = $db->prepare("UPDATE `tbl_users` 
  SET `clm_u_username` = ? , `clm_u_img` = ?
  WHERE `clm_u_id` = ? " );
  $stmt->execute(array($user,$key,$user_id));
  echo "Success Update Photo" ;
}
else{
  echo "Sorry There Was An Error" ;
}  
}
else if ($image == "empty" && $pass != "null"){
  $stmt = $db->prepare("UPDATE `tbl_users` 
  SET `clm_u_username` = ? , `clm_u_password` = ?
  WHERE `clm_u_id` = ? " );
  $stmt->execute(array($user, md5($pass),$user_id));
    
if($stmt){
  echo "Success Update Profile" ." : " . $pass ;
}else{
  echo "Sorry There Was An Error" ;
}

}
else if ($image == "empty" && $pass == "null"){
  $stmt = $db->prepare("UPDATE `tbl_users` 
  SET `clm_u_username` = ?
  WHERE `clm_u_id` = ? " );
  $stmt->execute(array($user,$user_id));
    
if($stmt){
  echo "Success Update Profile" ;
}else{
  echo "Sorry There Was An Error" ;
}
}
}else{
  echo "null" ;
}
$db = null ;
?>