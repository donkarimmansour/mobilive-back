<?php
$pageTitle = basename(__FILE__, ".php");
require_once "includes/header.php";


if (!isset($_SESSION['admin_id'])) {

    header("Location:index.php");
    exit;
} else {

?>
    <div class="container-fluid">
        <ol class="breadcrumb mb-4 mt-4">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
        <div class="row">
            <div class=" col-md-4 col-sm-12">
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body"><i class="fas fa-futbol"></i> Matches <?php countItems("tbl_matches", "clm_m_id"); ?></div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="matches.php">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class=" col-md-4 col-sm-12">
                <div class="card bg-warning text-white mb-4">
                    <div class="card-body"> <i class="fab fa-twitch"></i> Channels <?php countItems("tbl_channel", "clm_cn_id"); ?></div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="channels.php">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>

            <div class=" col-md-4 col-sm-12">
                <div class="card bg-success text-white mb-4">
                    <div class="card-body"><i class="far fa-newspaper"></i> News <?php countItems("tbl_news", "clm_nw_id"); ?></div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="news.php">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="card bg-secondary text-white mb-4">
                    <div class="card-body"><i class="far fa-comments"></i> Comments <?php countItems("tbl_chat_room", "clm_cr_id"); ?></div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="comments.php">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-12">
                <div class="card bg-danger text-white mb-4">
                    <div class="card-body"><i class="fa fa-users"></i> Users <?php countItems("tbl_users", "clm_u_id"); ?></div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="users.php">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>

        </div>


        <?php

        $stmt = $db->prepare("SELECT from_unixtime(UNIX_TIMESTAMP(clm_u_date),'%y') as year ,
                                from_unixtime(UNIX_TIMESTAMP(clm_u_date),'%M') as month ,
                                from_unixtime(UNIX_TIMESTAMP(clm_u_date),'%D') as day ,
                                clm_u_id ,clm_u_username , clm_u_email ,clm_u_img
                                FROM tbl_users WHERE  clm_u_id != -1 ORDER BY `clm_u_id` DESC LIMIT 10");

        $stmt->execute();
        $getAll = $stmt->fetchall();



        if (!empty($getAll)) {

        ?>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table mr-1"></i>
                    Latest Ten Users
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>UserName</th>
                                    <th>ID</th>
                                    <th>Avatar</th>
                                    <th>Email</th>
                                    <th>Date</th>
                                    <th>Modify</th>

                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>UserName</th>
                                    <th>ID</th>
                                    <th>Avatar</th>
                                    <th>Email</th>
                                    <th>Date</th>
                                    <th>Modify</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                $counter = 1;
                                foreach ($getAll as $get) {
                                ?>

                                    <tr>
                                        <td><?php echo $counter; ?>.</td>
                                        <td><?php echo $get["clm_u_username"]; ?></td>
                                        <td>#<?php echo $get["clm_u_id"]; ?></td>
                                        <td>
                                            <div class="round-img">
                                                <?php $img = $get["clm_u_img"] != "empty" ? $get["clm_u_img"] : "empty.png"; ?>
                                                <img style="width: 50px; height: 50px;" class="rounded-circle" src="images/img_user/<?php echo $img; ?>" alt="">
                                            </div>
                                        </td>
                                        <td><?php echo $get["clm_u_email"]; ?></td>
                                        <td>
                                            <span class="count"><?php echo $get["year"]; ?> </span>
                                            /<span> <?php echo $get["month"]  . " / " . $get["day"]; ?> </span>
                                        </td>
                                        <td>
                                            <a href="users.php?do=edit&id=<?php echo $get["clm_u_id"]; ?>"><span class="btn btn-success"><i class='fa fa-edit'></i> Edit</span></a>
                                            <a href="users.php?do=delete&id=<?php echo $get["clm_u_id"]; ?>"><span class="btn btn-danger confirm"><i class='fas fa-trash-alt'></i> Delete</span></a>
                                        </td>
                                    </tr>
                                <?php $counter++;
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        <?php } ?>

        <?php
        $stmt = $db->prepare("SELECT tbl_chat_room.* , tbl_users.*  , tbl_chat_room.clm_cr_user_id
                       FROM tbl_chat_room 
                       JOIN tbl_users
                       ON tbl_chat_room.clm_cr_user_id = tbl_users.clm_u_id 
                       ORDER BY clm_cr_id DESC LIMIT 10");

        $stmt->execute();
        $getAllComm = $stmt->fetchall();



        if (!empty($getAllComm)) {   ?>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title box-title">Latest Ten Comments</h4>
                            <div class="card-content pt-3">
                                <div>
                                    <ul style="list-style: none;">
                                        <?php

                                        foreach ($getAllComm as $getComm) {
                                        ?>
                                            <li class="mt-3">
                                              
                                                <div style=" display: flex;flex-wrap: wrap;">
                                                    <div>

                                                        <?php $img = $getComm["clm_u_img"] != "empty" ? $getComm["clm_u_img"] : "empty.png"; ?>
                                                        <img style="width: 50px; height: 50px;border-radius: 100%;" src="images/img_user/<?php echo $img; ?>" alt="Test">


                                                        <div style="font-size: 11px;padding-top: 5px;"><?php echo   $getComm["clm_cr_date"]  ?></div>
                                                    </div>

                                                    <div class="ml-2" style="overflow: auto;">
                                                        <div style="border-radius: 10px;background-color: #f1f2f7;font-size: 14px;color: #9aa0a4;padding: 20px 20px;">
                                                            <div style="    font-size: 16px;padding-bottom: 10px;">
                                                                <?php echo   $getComm["clm_u_username"]  ?>
                                                            </div>
                                                            <div style="word-wrap: break-word;overflow: auto;">
                                                                <?php
                                                             
                                                             
                                                             $msg = decodeEmoticons($getComm["clm_cr_msg"]);

                                                             if (strlen($msg) < 15) {
                                                                 echo $msg;
                                                             } else {
                                                                 echo substr($msg, 0, 15) . "..";
                                                             }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                   
                                                </div><!-- /.msg-received -->
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div><!-- /.messenger-box -->

                            </div>
                        </div> <!-- /.card-body -->
                    </div><!-- /.card -->

                </div>
            </div>
        <?php } ?>


    </div> <!-- /.content -->


<?php require_once "includes/footer.php";
}
ob_end_flush();
?>