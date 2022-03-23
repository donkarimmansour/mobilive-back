<?php
require_once "../includes/connect.php";

$email = strip_tags(trim($_POST["email"]));
  
$stmt = $db->prepare("SELECT * FROM `tbl_users` WHERE clm_u_email = ? OR clm_u_username = ?");
$stmt->execute(array($email,$email));
$row = $stmt->rowcount();
$fetch = $stmt->fetch(PDO::FETCH_ASSOC);

if($row == 0){

echo "Email Or Username  Is Not Correct" ;

}else{
    $username = $fetch['clm_u_username'];
	$myEmail = $fetch['clm_u_email'];
	$img = $fetch['clm_u_img'];
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	$generate_password = substr(str_shuffle($chars),0,10);
	$md5_password = md5($generate_password);

	$stmt = $db->prepare("SELECT * FROM tbl_smtp");
	$stmt->execute();
	$get = $stmt->fetch();

	$html = $db->prepare("SELECT * FROM tbl_html");
	$html->execute();
	$getH = $html->fetch();

	
	if($get['clm_st_state'] == "on"){
			  require("../includes/PHPMailer/class.phpmailer.php");
			  
		$stmp_Host = $get['clm_st_host'] ;
		$stmp_Username = $get['clm_st_username'] ;
		$stmp_Password = $get['clm_st_password'] ;
		$stmp_Port = $get['clm_st_port'] ;
		$stmp_From =  $get['clm_st_from'] ;
		$stmp_FromName =  $get['clm_st_fromname'] ;
		$stmp_reply_to =  $get['clm_st_reply_to'] ;
		$stmp_Secure =   $get["clm_st_security"];
        
		$mail = new PHPMailer();
		$mail->CharSet = 'UTF-8';
		$mail->IsSMTP();
		$mail->Host = $stmp_Host;
		$mail->SMTPAuth = true;
		$mail->Username = $stmp_Username;
		$mail->Password = $stmp_Password;
		$mail->From = $stmp_From;
		$mail->SMTPSecure = $stmp_Secure ;
		$mail->Port = $stmp_Port;
		$mail->FromName = $stmp_FromName;
		$mail->AddAddress("{$myEmail}");
		$mail->AddReplyTo("{$stmp_reply_to}");
		$mail->WordWrap = 50;
		$mail->IsHTML(true);
		
		$stmt = $db->prepare("UPDATE `tbl_users` SET `clm_u_password` = ? WHERE clm_u_email = ? OR clm_u_username = ?");
		$stmt->execute(array($md5_password,$email,$email));

		if($getH['clm_subject'] != null){
			$mail->Subject = $getH['clm_subject'];
		}else{
			$mail->Subject = "Restore password";
		}

		if($getH['clm_subject'] != null){

		 $message =	base64_decode($getH['clm_html']) ;

		 if(strpos($message, "(/newCode)") !== false ){
			$message = str_replace("(/newCode)", $generate_password , $message );  ;
		 } if(strpos($message, "(/username)") !== false ){
			$message = str_replace("(/username)", $username , $message );  ;
		 } if(strpos($message, "(/email)") !== false ){
			$message = str_replace("(/email)", $myEmail , $message );  ;
		 }if(strpos($message, "(/img)") !== false ){
			 if($img != "empty")
				 $message = str_replace("(/img)", $img , $message ); 
			 else $message = str_replace("(/img)", "https://cdn4.iconfinder.com/data/icons/small-n-flat/24/user-alt-512.png" , $message ); 
		 }
		 $message ;

			$mail->Body = $message ;
		
		}else{
			$mail->Body    = "<div style='text-align: center;'>
			&nbsp; ------------------------------<wbr>------------------------------<wbr>---------<br>
			&nbsp; MobiKora Password Reset<br>
			&nbsp; ------------------------------<wbr>------------------------------<wbr>---------<br>
			<br>
			&nbsp; Dear {$username},<br>
			<br>
			<br>
			&nbsp;For your information:<br>
			<br>
			<br>
			&nbsp; User Name :&nbsp; {$username} <br>
			&nbsp; Email :&nbsp; {$myEmail} <br>
			&nbsp; New Password :&nbsp; {$generate_password} <br>
			<br>
			<br>
			</div>";
		}
		
		$mail->AltBody = "By Karrim Mansour";

if($mail->Send())
			{
			   echo "new password sent to your email";   			
			   
			}else{
				echo "something went wrong";
				 
			}

}else{
	echo "You must turn on the SMTP protocol";
}
}
$db = null ;
?> 
  