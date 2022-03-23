<?php

use function PHPSTORM_META\type;

require_once "includes/header.php";

if (!isset($_SESSION['admin_id'])) {

    header("Location:index.php");
    exit;
} else {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $_SESSION['msg'] = "";
        if ($_POST["title"] == "") {
            $_SESSION['msg'] = "Please enter Title...";
        } elseif ($_POST["message"] == "") {
            $_SESSION['msg'] = "Please enter Message...";
        }
        elseif ($_POST["key"] == "") {
            $_SESSION['key'] = "Please enter Server key...";
        } else {


            define('App_Key', trim($_POST["key"]) );


            function sendNotif( $title , $message , $table , $id )
            {

                 $data = array("id" => $id , "table" => $table );
                 $notification = array();
                 $notification['title'] =  $title;
                 $notification["body"] =  $message;
                 $notification["sound"] =  "default";

                 $feilds = array('to' => "/topics/newUser", 'notification' => $notification , "data" => $data);
                

        
                $headers = array();
                $headers[] = "Authorization: Key=" . App_Key;
                $headers[] = 'Content-Type: application/json';

                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($feilds));
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                $result = curl_exec($ch);

                if (curl_errno($ch) || !isset(json_decode($result, JSON_UNESCAPED_SLASHES)["message_id"]))
                    returnToBack("failed push notification Error: " . curl_error($ch) . "<br>" . " Results : " . $result, "danger", "back");
                else returnToBack("success push notification" . "<br>" . " Results : " . $result, "success", "back");

                curl_close($ch);
            }


            // if($_POST["link"] != "") $notification ["link"] =  $_POST["link"] ;
            // if($_POST["icon"] != "") $notification ["icon"] =  $_POST["icon"] ;

            $data = json_decode($_POST["table"] , true)  ;
            sendNotif( $_POST["title"] , $_POST["message"] , $data["table"] , $data["id"]) ;

        }
    } // post 

    breadcrumbs("notification", "notification");

?>
    <!-- Content -->
    <div class="container">

        <div class="card">
            <div class="card-body">
                <h4 class="box-title">Notification</h4>
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


                    <div class="row" style="padding:10px">

                    
                        <div class="col-12">
                            <div class="form-group">
                                <label for="key" class="control-label mb-1">Server key</label>
                                <input type="text" id="key" value="<?php if (isset($_POST["key"])) echo $_POST["key"]; else echo "AAAAr6ZUZf4:APA91bEL7vClIt2CsY_QiCOiaEZtiNm7J3xNwZfih1xcEuseNa_TvdM0LoHaToRyme_27DtbOE_ExYMz3p6UL3ZjnCTZDwOpPScHVxINITlgsQlpHYnnyJ2tklRATvoBVpmASkvAyNOp" ;?>" name="key" class="form-control" placeholder="Server key...">
                            </div>
                        </div>



                        <div class="col-md-6 col-sm-12">
                            <div style="padding:10px;border-radius: 8px;background-color: #f8f9fa;border: 1px solid #ebedef;padding: 24px;">

                                <div class="form-group">
                                    <label for="title" class="control-label mb-1">Title</label>
                                    <input type="text" id="title" value="<?php if (isset($_POST["title"])) echo $_POST["title"]; ?>" name="title" class="form-control" placeholder="Title...">
                                </div>

                                <div class="form-group">
                                    <label for="message" class="control-label mb-1">Message</label>
                                    <textarea type="text" id="message" name="message" class="form-control" placeholder="Message.."><?php if (isset($_POST["message"])) echo $_POST["message"]; ?></textarea>
                                </div>


                                   <div class="form-group">
                                     <label for="table" class="control-label mb-1">Selector</label>
                                        <select name="table" id="table" class="form-control-lg form-control">
                                        <option value="<?php echo htmlspecialchars(json_encode(array('id' => '-1' , 'table' => '-1' )));  ?>" >Nothing</option>
                                        <?php

                                            $stmt = $db->prepare("SELECT tbl_matches.clm_m_id as `id` , CONCAT(tbl_matches.clm_m_host_name , ' Vs ' , tbl_matches.clm_m_guest_name) as `title` , 'match' as `table` 
                                            FROM tbl_matches
                                            
                                            UNION SELECT tbl_channel.clm_cn_link as `id` , tbl_channel.clm_cn_name as `title` , tbl_channel.clm_cn_type as `table` 
                                            FROM tbl_channel  WHERE tbl_channel.clm_cn_id != '-1'
                                            
                                            UNION SELECT tbl_news.clm_nw_id as `id` , tbl_news.clm_nw_title as `title` , 'news' as `table` 
                                            FROM tbl_news;");

                                            $stmt->execute();
                                            $count = $stmt->rowcount();
                                            $all = $stmt->fetchall();

                                                

                                                if ($count > 0) {
                                                    foreach ($all as $a) {
                                                ?>
                                                        <option value="<?php echo htmlspecialchars(json_encode(array('id' => $a["id"] , 'table' => $a["table"]))) ;  ?>"><?php echo $a["title"] ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                           
                                        </select>
                                    </div>

                

                                <!-- <div class="form-group">
                                    <label for="link" class="control-label mb-1">Link (optional)</label>
                                    <input type="text" id="link" value="<?php if (isset($_POST["link"])) echo $_POST["link"]; ?>" name="link" class="form-control" placeholder="Link...">
                                </div>

                                <div class="form-group">
                                    <label for="icon" class="control-label mb-1">Icon (optional)</label>
                                    <input type="text" id="icon" value="<?php if (isset($_POST["icon"])) echo $_POST["icon"]; ?>" name="icon" class="form-control" placeholder="Icon...">
                                </div> -->

                            </div>
                        </div>

                        <div class="col-md-6 col-sm-12">
                            <div style='padding: 10px;
                                font-family: Roboto, "Open Sans", Arial, Helvetica, sans-serif;
                                padding: 16px;
                                border-radius: 2px;
                                background-color: rgb(254, 254, 254);
                                box-shadow: rgba(0, 0, 0, 0.14) 0px 2px 2px 0px, rgba(0, 0, 0, 0.2) 0px 3px 1px -2px, rgba(0, 0, 0, 0.12) 0px 1px 5px 0px;
                                max-width: 500px;
                                transition: height 0.3s ease-out 0s;
                                box-sizing: content-box;'>

                                <div style="display: flex; align-items: center; ;line-height: 15px ">
                                    <img style="align-self: baseline;max-width: 30px;" src="https://i.ibb.co/y4gv3R8/download-1-removebg-preview-1.png" alt="notification png">
                                    <p style="align-self: baseline; margin-left: 10px;">test</p>
                                </div>

                                <div style="display: flex; align-items: flex-start;justify-content: flex-start; flex-direction: column;margin-top: 8px;height: 200px;">
                                    <h5 style="word-wrap: break-word;word-break: break-all;overflow: auto;" id="output-title">test</h5><br>
                                    <p style="word-wrap: break-word;word-break: break-all;overflow: auto;" id="output-message">test</p>
                                </div>

                            </div>
                        </div>

                        
                    </div>




                    <div>
                        <button type="submit" class="btn btn-lg btn-info btn-block">
                            <span>Push Notification</span>
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