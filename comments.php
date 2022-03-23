<?php
require_once "includes/header.php";



if (!isset($_SESSION['admin_id'])) {

    header("Location:index.php");
    exit;
} else {

    breadcrumbs("Users", "Comments");

    $do = isset($_GET["do"]) ? $_GET["do"] : "manage";

    if ($do == "manage") {

        $sort = "ASC";

        $arr_sort = array("DESC", "ASC");

        if (isset($_GET["sort"]) && in_array($_GET["sort"], $arr_sort)) {

            $sort = $_GET["sort"];
        }

        $stmt = $db->prepare("SELECT from_unixtime(UNIX_TIMESTAMP(clm_cr_date),'%y') as year ,
       from_unixtime(UNIX_TIMESTAMP(clm_cr_date),'%M') as month ,
       from_unixtime(UNIX_TIMESTAMP(clm_cr_date),'%D') as day , 
       clm_cr_msg , clm_cr_id , clm_cr_id , clm_cr_user_id , 
       clm_cr_match_id , clm_u_username 
       FROM tbl_chat_room 
       JOIN tbl_users 
       ON tbl_chat_room.clm_cr_user_id = tbl_users.clm_u_id
       ORDER BY clm_cr_id $sort");

        $stmt->execute();
        $getAll = $stmt->fetchall();



        if (!empty($getAll)) {
?>


            <div class="container-fluid">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Comments


                        <span style="float: right;"> <a href=""> <a href=""></a></a>
                            <a style="<?php if (isset($_GET["sort"])  && $_GET["sort"] == "ASC") {
                                            echo "font-weight: bold;color:black;";
                                        } else {
                                            echo "font-weight: 400;color:#6c757d;";
                                        } ?> ?>" href="?sort=ASC">Asc</a><span> / </span>
                            <a style="<?php if (isset($_GET["sort"])  && $_GET["sort"] == "DESC") {
                                            echo "font-weight: bold;color:black;";
                                        } else {
                                            echo "font-weight: 400;color:#6c757d;";
                                        } ?> ?>" href="?sort=DESC">Desc</a>
                        </span>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th class="serial">#</th>
                                        <th>UserName</th>
                                        <th>ID</th>
                                        <th>Match</th>
                                        <th>Comment</th>
                                        <th>Date</th>
                                        <th style="text-align: center;">Modify</th>
                                    </tr>
                                </thead>
                                <tbody>





                                    <?php
                                    $counter = 1;
                                    foreach ($getAll as $get) {
                                    ?>

                                        <tr>
                                            <td><?php echo $counter; ?>.</td>

                                            <td> <a style="color:black;" href="users.php?do=edit&id=<?php echo $get["clm_cr_user_id"]; ?>"><?php echo $get["clm_u_username"]; ?> </a> </td>
                                            <td> #<?php echo $get["clm_cr_id"]; ?> </td>
                                          
                                            <td> #<a style="color:black;" href="matches.php?do=edit&id=<?php echo $get["clm_cr_match_id"]; ?>"><?php echo $get["clm_cr_match_id"]; ?></a> </td>
                                            <td> <?php

                                                    $msg = decodeEmoticons($get["clm_cr_msg"]);

                                                    if (strlen($msg) < 15) {
                                                        echo $msg;
                                                    } else {
                                                        echo substr($msg, 0, 15) . "..";
                                                    }

                                                    ?> </td>
                                            <td>
                                                <span class="count"><?php echo $get["year"]; ?> </span>
                                                /<span> <?php echo $get["month"]  . " / " . $get["day"]; ?> </span>
                                            </td>
                                            <td style="text-align: center;">
                                                <a href="?do=edit&id=<?php echo $get["clm_cr_id"]; ?>"><span class="btn btn-success"><i class='fa fa-edit'></i> Edit</span></a>
                                                <a href="?do=delete&id=<?php echo $get["clm_cr_id"]; ?>"><span class="btn btn-danger confirm"><i class='fas fa-trash-alt'></i> Delete</span></a>
                                            </td>
                                        </tr>
                                    <?php $counter++;
                                    } ?>



                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <div>
                    <button type="button" class="btn btn-primary btn-lg btn-block">
                        <a style="color: #ffffff;" href="?do=add">Add New Comment</a>
                    </button>
                </div>


            </div>
            <!-- /.content -->




        <?php


        } else {

            btnAdd("Add New Comment");
        }
    } else if ($do == "edit") {
        // edit

        $commId = isset($_GET["id"]) && is_numeric($_GET["id"]) ? intval($_GET["id"]) : 0;
        $count = checkItem("tbl_chat_room", "clm_cr_id", $commId);

        if ($count > 0) {
            $get = getItem("tbl_chat_room", "clm_cr_id", $commId);
        ?>

            <!-- Content -->
            <div class="container">
            
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="box-title">Edit</h4>
                                    </div>
                                    <div class="card-body text-center">
                                                        <form method="post" action="?do=update">
                                                            <input type="hidden" name="id" value="<?php echo  $commId;  ?>">

                                                            <div class="form-group">
                                                                <label for="comment">Comment</label>
                                                                <textarea type="text" class="form-control auto_direction" name="comment" id="comment" rows="10"><?php 
                                                                  echo decodeEmoticons($get["clm_cr_msg"])    ;  ?></textarea>
                                                            </div>

                                                            <div>
                                                                <button  type="submit" class="btn btn-lg btn-info btn-block">
                                                                    <span >UpDate</span>
                                                                </button>
                                                            </div>
                                                         </form>
                                                   

                                    </div>
                                </div> <!-- /.card -->
             
            </div>
        


        <?php
            /* end page html */  }


        /* end page edit */
    } elseif ($do == "update") {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $comment = filter_var($_POST["comment"], FILTER_SANITIZE_STRING);
            $commid = $_POST["id"];

            if ($comment == "") {

                returnToBack("Please enter comment...", "danger", "back");
            } else {

                $stmt = $db->prepare("UPDATE tbl_chat_room SET clm_cr_msg = ? WHERE clm_cr_id = ?");
                $stmt->execute(array($comment, $commid));

                returnToBack("success", "success", "back");
            }
        }

        /* end page uploade */
    } elseif ($do == "add") {
        ?>

        <!-- Content -->
        <div class="container">
            
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="box-title">Add</h4>
                                </div>
                                <div class="card-body-- text-center">
                                    <div class="sufee-login d-flex align-content-center flex-wrap">
                                        <div class="container">

                                            <div class="login-content">
                                                <div class="login-form">
                                                    <form method="post" action="?do=insert">


                                                        <div class="form-group">
                                                            <label for="comment">Comment</label>
                                                            <textarea type="text" class="form-control auto_direction" name="comment" id="comment" rows="10"></textarea>
                                                        </div>

                                                        <div class="row form-group">
                                                            <div class="col col-md-3"><label for="selectLg" class=" form-control-label">Select User</label></div>
                                                            <div class="col-12 col-md-9">
                                                                <select name="user" id="selectLg" class="form-control-lg form-control">
                                                                    <option disabled>Please select</option>
                                                                    <?php


                                                                    $users = getItems("tbl_users", "*");
                                                                    $userscount = checkItems("tbl_users", "*");

                                                                    if ($userscount > 0) {
                                                                        foreach ($users as $user) {
                                                                            echo "<option value='" . $user["clm_u_id"] . "'>" . $user["clm_u_username"] . "</option>";
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row form-group">
                                                            <div class="col col-md-3"><label for="selectLg" class=" form-control-label">Select Match</label></div>
                                                            <div class="col-12 col-md-9">
                                                                <select name="match" id="selectLg" class="form-control-lg form-control">
                                                                    <option disabled>Please select</option>
                                                                    <?php

                                                                    $count = checkItems("tbl_matches", "*");

                                                                    if ($count > 0) {

                                                                        $matches = getItems("tbl_matches", "*");

                                                                        foreach ($matches as $match) {
                                                                            echo "<option value='" . $match["clm_m_id"] . "'>" . $match["clm_m_host_name"] . " Vs " . $match["clm_m_guest_name"] . "</option>";
                                                                        }
                                                                    }
                                                                    ?>

                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <button  type="submit" class="btn btn-lg btn-info btn-block">
                                                                <span >Add</span>
                                                            </button>
                                                        </div>
                                                    </form>
                                            
                                </div>
                            </div> <!-- /.card -->
                       
        </div>
        <!-- /.content -->


<?php  } elseif ($do == "insert") {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $comment = $_POST["comment"];
            $user = $_POST["user"];
            $match = $_POST["match"];


            if ($comment == "") {
                returnToBack("Please enter comment...", "danger", "back");
            } else {
                $stmt = $db->prepare("INSERT INTO tbl_chat_room (clm_cr_msg , clm_cr_user_id , clm_cr_match_id  ) VALUES (? , ? , ? ) ");
                $stmt->execute(array($comment, $user, $match));
                returnToBack("success", "success", "back");



                /* else */
            }

            /* POST */
        }


        /* end page insert */
    } else if ($do == "delete") {


        $commId = isset($_GET["id"]) && is_numeric($_GET["id"]) ? intval($_GET["id"]) : 0;

        $count =  checkItem("tbl_chat_room", "clm_cr_id", $commId);

        if ($count > 0) {

            $stmt = $db->prepare("DELETE FROM tbl_chat_room WHERE clm_cr_id = :ui ");
            $stmt->bindparam("ui", $commId);
            $stmt->execute();


            returnToBack("this comment is deleted", "success", "back");
            /* EMPTY*/
        }
        /* end page delete */
    }


    require_once "includes/footer.php";
}
ob_end_flush();
?>