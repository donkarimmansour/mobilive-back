<?php
require_once "../includes/connect.php";

if(isset($_POST["user"]) && isset($_POST["email"]) && isset($_POST["pass"])){

$user = $_POST["user"];
$email = $_POST["email"];
$pass = $_POST["pass"];

$stmt = $db->prepare("SELECT `clm_u_username`, `clm_u_email` FROM `tbl_users` WHERE  (`clm_u_username` = ? OR `clm_u_email` = ?) " );
$stmt->execute(array($user ,$email));

$row = $stmt->rowcount();

if($row > 0){

$fetch = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user == $fetch['clm_u_username'])
        {
            echo "Username already exists" ;
        }
   else if($email == $fetch['clm_u_email'])
        {
            echo "Email already exists";
        }


}

else{

    $stmt = $db->prepare("INSERT INTO `tbl_users` (`clm_u_username`, `clm_u_email`, `clm_u_password` , `clm_u_img`) 
    VALUES ( ?, ?, ? , ?)  ");
    
    $stmt->execute(array($user ,$email ,md5($pass),"empty"));


if($stmt ){

echo "good" ;

//$_GET["ServerUrl"]

// $VKey = md5(time() . $user) ;
// $subject = "Email Verification" ;
// $message = '<a href="' . "mmm.com " . '/live/connect.php?vkey="' . $VKey . '  target="_blank"></a>' ;
// $header = "from: franckydesf@gmail.com" ;

// if(mail("benzema.kw@gmail.com",$subject,$message,$header)){
//     echo 'Email on the way';
// }

}

else{
    echo "bad" ;
}

}//else


}//f

$db = null ;



?>

 