<?php

use function PHPSTORM_META\type;

require_once "includes/header.php";

if (!isset($_SESSION['admin_id'])) {

    header("Location:index.php");
    exit;
} else {

        $stmt = $db->prepare("SELECT * FROM tbl_html");
        $stmt->execute();
        $get = $stmt->fetch();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $_SESSION['msg'] = "";
        $Subject =  filter_var($_POST["Subject"], FILTER_SANITIZE_STRING);

        if ($Subject == "") {
            $_SESSION['msg'] = "Please enter Subject...";
        }
        else if ($_POST["html"] == "") {
            $_SESSION['msg'] = "Please enter html code...";
        } else {

            $stmt = $db->prepare("UPDATE tbl_html SET clm_subject = ? , clm_html = ? ");
            $stmt->execute(array($Subject , base64_encode($_POST["html"]) ));

            if ($stmt->rowcount() > 0) {
                returnToBack("success update message", "success", "back");
            } else {
                returnToBack("failed update message", "danger", "back");
            }
        }
    } // post 

    breadcrumbs("Message", "Html");

?>
    <!-- Content -->
    <div class="container">

        <div class="card">
            <div class="card-body">
                <h4 class="box-title">Message</h4>
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

                <form method="post" action="<?php echo $_SERVER["PHP_SELF"] ?>">

                    <p> These codes will be changed by user data : 
                    (/newCode) => New Password 
                   |  (/username) => Username 
                   |  (/email) => Email Address 
                     | (/img) => Link Image Profile 

                    <div class="form-group">
                        <label for="Subject" class="control-label mb-1">Subject</label>
                        <input type="text" id="Subject" name="Subject" class="form-control" placeholder="Subject.." value="<?php echo $get['clm_subject'];?>" />
                    </div>

                    <div class="form-group">
                        <label for="html" class="control-label mb-1">Html</label>
                        <textarea rows="10"id="html" name="html" class="form-control" placeholder="Html.."><?php echo base64_decode($get['clm_html']);?></textarea>
                    </div>



                    <div>
                        <button type="submit" class="btn btn-lg btn-info btn-block">
                            <span>Update Message</span>
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