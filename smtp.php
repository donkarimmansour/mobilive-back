<?php
require_once "includes/header.php";

if (!isset($_SESSION['admin_id'])) {

    header("Location:index.php");
    exit;
} else {

    $stmt = $db->prepare("SELECT * FROM tbl_smtp");
    $stmt->execute();
    $get = $stmt->fetch();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        //  $_SESSION['msg'] = "";
        if ($_POST["host"] == "") {
            $_SESSION['msg'] = "Please enter host...";
        } elseif ($_POST["username"] == "") {
            $_SESSION['msg'] = "Please enter username...";
        } elseif ($_POST["password"] == "") {
            $_SESSION['msg'] = "Please enter password...";
        } elseif ($_POST["port"] == "") {
            $_SESSION['msg'] = "Please enter port...";
        } elseif ($_POST["from"] == "") {
            $_SESSION['msg'] = "Please enter from...";
        } elseif ($_POST["fromname"] == "") {
            $_SESSION['msg'] = "Please enter fromname...";
        } elseif ($_POST["reply_to"] == "") {
            $_SESSION['msg'] = "Please enter reply to...";
        } else {

            $valueRadio = $_POST['optradio'];
            $Secure =   $_POST["secure"];
      
            $stmt = $db->prepare("UPDATE tbl_smtp SET                   
                    clm_st_host = ? ,
                    clm_st_username = ? ,
                    clm_st_password = ? ,
                    clm_st_port = ? ,
                    clm_st_from = ? ,
                    clm_st_fromname = ?, 
                    clm_st_state = ?,
                    clm_st_reply_to = ? ,
                    clm_st_security = ? ");
            $stmt->execute(array(
                $_POST["host"], $_POST["username"], $_POST["password"], $_POST["port"],
                $_POST["from"], $_POST["fromname"], $valueRadio, $_POST["reply_to"] , $Secure
            ));

            if ($stmt->rowcount() > 0) {
                returnToBack("success update smtp", "success", "back");
            } else {
                returnToBack("failed update smtp", "danger", "back");
            }
        }
    } // post 

    breadcrumbs("smtp", "smtp");

?>
    <!-- Content -->
    <div class="container">

        <div class="card">
            <div class="card-body">
                <h4 class="box-title">smtp</h4>
            </div>
            <div class="card-body text-center">

                <?php if (isset($_SESSION['msg']) && !empty($_SESSION['msg'])) { ?>

                    <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                        <span class="badge badge-pill badge-danger">Error</span>
                        <?php echo $_SESSION['msg']; ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php unset($_SESSION['msg']);
                } ?>

                <form method="post" action="<?php echo $_SERVER["PHP_SELF"] ?>" enctype="multipart/form-data">

                    <?php $state = $get['clm_st_state']; ?>
                    <div class="btn-group btn-group-toggle mb-3" data-toggle="buttons">

                        <label class="btn btn-secondary <?php if ($state == "on") {
                                                            echo "active";
                                                        } else {
                                                            echo "karim";
                                                        } ?> ">
                            <input type="radio" name="optradio" id="on" value="on" autocomplete="off" <?php if ($state == "on") {
                                                                                                            echo 'checked';
                                                                                                        } ?>> On
                        </label>

                        <label class="btn btn-secondary <?php if ($state == "off") {
                                                            echo "active";
                                                        } else {
                                                            echo "karim";
                                                        }  ?>">
                            <input type="radio" name="optradio" id="off" value="off" autocomplete="off" <?php if ($state == "off") {
                                                                                                            echo 'checked';
                                                                                                        } ?>> Off
                        </label>
                    </div>



                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="host" class="control-label mb-1">Host</label>
                                <input type="text" id="host" value="<?php echo $get['clm_st_host']; ?>" name="host" class="form-control" placeholder="Host">
                                <small class="text-muted d-block">your smtp host that you will send from it / example => stmp.gmail.com</small>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="port" class="control-label mb-1">Port</label>
                                <input type="number" id="port" value="<?php echo $get['clm_st_port']; ?>" name="port" class="form-control" placeholder="Port">
                                <small class="text-muted d-block">your smtp port that you will send from it / example => 587</small>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                            <label for="Secure">Secure</label>
                            <select id="Secure" name="secure" class="form-control">

                            <option disabled>Please select</option>

                            <option <?php if ($get["clm_st_security"] == "tls") { echo "Selected"; } ?>  value="tls">tls</option>
                            <option <?php if ($get["clm_st_security"] == "ssl") { echo "Selected"; } ?>  value="ssl">ssl</option>
                         
                            </select>
                            <small class="text-muted d-block">example => tls</small>

                            </div>
                        </div>

                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="username" class="control-label mb-1">Email</label>
                                <input type="text" id="username" value="<?php echo $get['clm_st_username']; ?>" name="username" class="form-control" placeholder="Email">
                                    <small class="text-muted d-block">your smtp email that you will send from it / example => karim@gmail.com</small>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="password" class="control-label mb-1">Password</label>
                                <input type="text" id="password" value="<?php echo $get['clm_st_password']; ?>" name="password" class="form-control" placeholder="Password">
                                <small class="text-muted d-block">your smtp password that you will send from it/ example => karim123</small>
                            </div>
                        </div>
                        
                        <div class="col-md-6 col-sm-12">

                            <div class="form-group">
                                <label for="from" class="control-label mb-1">ReplyTo</label>
                                <input type="text" id="from" value="<?php echo $get['clm_st_reply_to']; ?>" name="reply_to" class="form-control" placeholder="ReplyTo">
                                <small class="text-muted d-block">Your email that the user will contact with you / example => karim@gmail.com</small>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">

                            <div class="form-group">
                                <label for="from" class="control-label mb-1">Email From</label>
                                <input type="text" id="from" value="<?php echo $get['clm_st_from']; ?>" name="from" class="form-control" placeholder="Email From">
                                <small class="text-muted d-block">your email that it will show to user / example => karim@gmail.com</small>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">

                            <div class="form-group">
                                <label for="fromname" class="control-label mb-1">FromName</label>
                                <input type="text" id="fromname" value="<?php echo $get['clm_st_fromname']; ?>" name="fromname" class="form-control" placeholder="FromName">
                                <small class="text-muted d-block">your name that it will show to user / example => karim</small>
                            </div>
                        </div>

                    </div>


                    <div>
                        <button type="submit" class="btn btn-lg btn-info btn-block">
                            <span>Update</span>
                        </button>
                    </div>

                </form>

            </div>
        </div> <!-- /.card -->

    </div>
    <!-- /.content -->


<?php require_once "includes/footer.php";
    ob_end_flush();
}
?>