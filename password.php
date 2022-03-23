<?php require_once "./includes/connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $email = strip_tags(trim($_POST["email"]));
    $stmt = $db->prepare("SELECT * FROM `tbl_admin` WHERE clm_a_email = ? OR clm_a_user = ?");
    $stmt->execute(array($email, $email));
    $row = $stmt->rowcount();
    $fetch = $stmt->fetch(PDO::FETCH_ASSOC);


    if ($row == 0) {
        $_SESSION['type'] = "danger";
        $_SESSION['msg'] = "Email Or Username  Is Not Correct";
    } else {

        $username = $fetch['clm_a_user'];
        $myEmail = $fetch['clm_a_email'];
        $img = $fetch['clm_u_img'];
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $generate_password = substr(str_shuffle($chars), 0, 10);
        $md5_password = md5($generate_password);

        $stmt = $db->prepare("SELECT * FROM tbl_smtp");
        $stmt->execute();
        $get = $stmt->fetch();

        $html = $db->prepare("SELECT * FROM tbl_html");
        $html->execute();
        $getH = $html->fetch();

        if ($get['clm_st_state'] == "on") {
            require("./includes/PHPMailer/class.phpmailer.php");

            $stmp_Host = $get['clm_st_host'];
            $stmp_Username = $get['clm_st_username'];
            $stmp_Password = $get['clm_st_password'];
            $stmp_Port = $get['clm_st_port'];
            $stmp_From =  $get['clm_st_from'];
            $stmp_FromName =  $get['clm_st_fromname'];
            $stmp_reply_to =  $get['clm_st_reply_to'];
            $stmp_Secure =   $get["clm_st_security"];

            $mail = new PHPMailer();
            $mail->CharSet = 'UTF-8';
            $mail->IsSMTP();
            $mail->Host = $stmp_Host;
            $mail->SMTPAuth = true;
            $mail->Username = $stmp_Username;
            $mail->Password = $stmp_Password;
            $mail->From = $stmp_From;
            $mail->SMTPSecure = $stmp_Secure;
            $mail->Port = $stmp_Port;
            $mail->FromName = $stmp_FromName;
            $mail->AddAddress("{$myEmail}");
            $mail->AddReplyTo("{$stmp_reply_to}");
            $mail->WordWrap = 50;
            $mail->IsHTML(true);

            $stmt = $db->prepare("UPDATE `tbl_admin` SET `clm_a_pass` = ? WHERE clm_a_email = ? OR clm_a_user= ?");
            $stmt->execute(array($md5_password, $email, $email));


            if ($getH['clm_subject'] != null) {
                $mail->Subject = $getH['clm_subject'];
            } else {
                $mail->Subject = "Restore password";
            }

            if ($getH['clm_subject'] != null) {

                $message =    base64_decode($getH['clm_html']);

                if (strpos($message, "(/newCode)") !== false) {
                    $message = str_replace("(/newCode)", $generate_password, $message);;
                }
                if (strpos($message, "(/username)") !== false) {
                    $message = str_replace("(/username)", $username, $message);;
                }
                if (strpos($message, "(/email)") !== false) {
                    $message = str_replace("(/email)", $myEmail, $message);;
                }
                if (strpos($message, "(/img)") !== false) {
                    if ($img != "empty")
                        $message = str_replace("(/img)", $img, $message);
                    else $message = str_replace("(/img)", "https://cdn4.iconfinder.com/data/icons/small-n-flat/24/user-alt-512.png", $message);
                }
                $message;

                $mail->Body = $message;
            } else {
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

            if ($mail->Send()) {
                $_SESSION['type'] = "success";
                $_SESSION['msg'] = "new password sent to your email";
            } else {
                $_SESSION['type'] = "danger";
                $_SESSION['msg'] = "something went wrong";
            }
        } else {
            $_SESSION['type'] = "danger";
            $_SESSION['msg'] = "smtp is off";
        }
    }

    $db = null;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Page Title - SB Admin</title>
    <link href="./assets/css/styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Password Recovery</h3>
                                </div>
                                <div class="card-body">

                                    <?php if (isset($_SESSION['msg']) && isset($_SESSION['type'])) { ?>
                                        <div class="sufee-alert alert with-close alert-<?php echo $_SESSION['type']; ?> alert-dismissible fade show">
                                            <span class="badge badge-pill badge-<?php echo $_SESSION['type']; ?>"><?php echo $_SESSION['type']; ?></span>
                                            <?php echo $_SESSION['msg']; ?>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    <?php unset($_SESSION['msg']);
                                        unset($_SESSION['type']);
                                    } ?>


                                    <div class="small mb-3 text-muted">Enter your email address or username and we will send you a link to reset your password.</div>
                                    <form method="post" action="<?php echo $_SERVER["PHP_SELF"] ?>"">
                                            <div class=" form-group">
                                        <label class="small mb-1" for="inputEmailAddress">Email</label>
                                        <input class="form-control py-4" name="email" id="inputEmailAddress" type="text" aria-describedby="emailHelp" placeholder="Enter email address oe username" />
                                </div>
                                <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                    <a class="small" href="index.php">Return to login</a>
                                    <input class="btn btn-primary" type="submit" value="Reset Password">
                                </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
        </div>
        </main>
    </div>
    <div id="layoutAuthentication_footer">
        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Copyright &copy; Your Website 2020</div>
                    <div>
                        <a href="#">Privacy Policy</a>
                        &middot;
                        <a href="#">Terms &amp; Conditions</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="./assets/js/scripts.js"></script>
</body>

</html>