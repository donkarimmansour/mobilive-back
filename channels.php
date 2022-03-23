<?php
require_once "includes/header.php";



if (!isset($_SESSION['admin_id'])) {

    header("Location:index.php");
    exit;
} else {

    breadcrumbs("ELEMENTS", "Channels");

    $do = isset($_GET["do"]) ? $_GET["do"] : "manage";

    if ($do == "manage") {

        $sort = "ASC";

        $arr_sort = array("DESC", "ASC");

        if (isset($_GET["sort"]) && in_array($_GET["sort"], $arr_sort)) {

            $sort = $_GET["sort"];
        }

        $stmt = $db->prepare("SELECT clm_cn_id ,clm_cn_name, clm_cn_logo ,clm_cn_status
         FROM tbl_channel WHERE  clm_cn_id != -1 ORDER BY `clm_cn_id` $sort");

        $stmt->execute();
        $getAll = $stmt->fetchall();



        if (!empty($getAll)) {
?>


            <div class="container-fluid">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Channels
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
                                        <th>#</th>
                                        <th>Logo</th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th style="text-align: center;">Modify</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Logo</th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th style="text-align: center;">Modify</th>
                                    </tr>
                                </tfoot>
                                <tbody>





                                    <?php
                                    $counter = 1;
                                    foreach ($getAll as $get) {
                                    ?>
                                        <tr>
                                            <td><?php echo $counter; ?>.</td>

                                            <td>

                                                <div class="round-img" style="max-width: 100px;">
                                                    <?php $img = $get["clm_cn_logo"] != "empty" ? $get["clm_cn_logo"] : "empty.png"; ?>
                                                    <img class="rounded-circle" src="images/logo_channel/<?php echo $img; ?>" alt="">
                                                </div>

                                            </td>

                                            <td> #<?php echo $get["clm_cn_id"]; ?> </td>
                                            <td>

                                                <?php

                                                $title = $get["clm_cn_name"];

                                                if (strlen($title) < 20) {
                                                    echo $title;
                                                } else {
                                                    echo substr($title, 0, 20) . "..";
                                                }

                                                ?> </td>

                                            <td> <?php echo $get["clm_cn_status"]; ?></td>

                                            <td style="text-align: center;">
                                                <a href="?do=edit&id=<?php echo $get["clm_cn_id"]; ?>"><span class="btn btn-success"><i class='fa fa-edit'></i> Edit</span></a>
                                                <a href="?do=delete&id=<?php echo $get["clm_cn_id"]; ?>"><span class="btn btn-danger confirm"><i class='fas fa-trash-alt'></i> Delete</span></a>
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
                        <a style="color: #ffffff;" href="?do=add">Add New Channel</a>
                    </button>
                </div>


            </div>
            <!-- /.content -->



        <?php


        } else {
            btnAdd("Add New Channel");
        }
    } else if ($do == "edit") {
        // edit

        $channelId = isset($_GET["id"]) && is_numeric($_GET["id"]) ? intval($_GET["id"]) : 0;

        $count = checkItems("tbl_channel", "clm_cn_id", $channelId);

        if ($count > 0) {
            $get = getItem("tbl_channel", "clm_cn_id", $channelId);

        ?>

            <!-- Content -->
            <div class="container">

                <div class="card">
                    <div class="card-body">
                        <h4 class="box-title">Edit</h4>
                    </div>
                    <div class="card-body text-center">

                        <form method="post" action="?do=update" enctype="multipart/form-data">

                            <?php $img = $get["clm_cn_logo"] != "empty" ? $get["clm_cn_logo"] : "empty.png"; ?>

                            <div class="img_box w-100% m-3">
                                <div class="row">
                                    <div class="col-12">


                                        <div style="margin:auto;" class="p-3">
                                            <?php if ($img != "empty") { ?>
                                                <img  style="height: 300px;width:300px"  class="img-fluid rounded" type="image" id="profile-img" src="images/logo_channel/<?php echo $img; ?>" alt="profile image" />
                                            <?php } else { ?>
                                                <img  style="height: 300px;width:300px"  class="img-fluid rounded" type="image" id="profile-img" src="images/logo_channel/empty.png" alt="add image" />
                                            <?php } ?></div>

                                    </div>
                                    <div class="col-12 m-3">
                                        <input class="form-control-file" accept="image/*" style="background: #d0d0e0;" type="file" name="image" id="file-img">
                                    </div>


                                </div>
                            </div>


                            <input type="hidden" name="id" value="<?php echo  $channelId;  ?>">

                            <div class="form-group">
                                <label for="name" class="control-label mb-1">Name</label>
                                <input data-msgAr="اسم" data-msgEng="name" type="text" id="name" name="name" class="form-control auto_direction" placeholder="name" value="<?php echo $get['clm_cn_name']; ?>">
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="selectLg" class=" form-control-label">Type</label></div>
                                <div class="col-12 col-md-9">
                                    <select name="type" id="selectLg" class="form-control-lg form-control">
                                        <option disabled>Please select</option>
                                        <option value="live_link" <?php if ($get["clm_cn_type"] == "live_link") {
                                                                        echo "Selected";
                                                                    } ?>>Live link</option>
                                        <option value="youtube" <?php if ($get["clm_cn_type"] == "youtube") {
                                                                    echo "Selected";
                                                                } ?>>Youtube Id (Not All Link)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="link" class="control-label mb-1">Link</label>
                                <input type="text" id="link" name="link" class="form-control" placeholder="link" value="<?php echo $get['clm_cn_link']; ?>">
                            </div>


                            <div class="row form-group">
                                <div class="col col-md-3"><label for="selectLg" class=" form-control-label">Status</label></div>
                                <div class="col-12 col-md-9">
                                    <select name="status" id="selectLg" class="form-control-lg form-control">
                                        <option disabled>Please select</option>

                                        <option value="draft" <?php if ($get["clm_cn_status"] == "draft") {
                                                                    echo "Selected";
                                                                } ?>>Draft</option>
                                        <option value="publish" <?php if ($get["clm_cn_status"] == "publish") {
                                                                    echo "Selected";
                                                                } ?>>Publish</option>

                                    </select>
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




        <?php
            /* end page html */  }
        /* end page edit */
    } elseif ($do == "update") {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $name = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
            $link = filter_var($_POST["link"], FILTER_SANITIZE_STRING);
            $status = filter_var($_POST["status"], FILTER_SANITIZE_STRING);
            $type = filter_var($_POST["type"], FILTER_SANITIZE_STRING);

            $channelId = $_POST["id"];



            if ($name == "") {

                returnToBack("Please enter name...", "danger", "back");
            } else if ($link == "") {
                returnToBack("Please enter link...", "danger", "back");
            } else {


                if ($_FILES['image']['name'] != "" && $_FILES['image']['error'] == 0) {

                    $get = getItem("tbl_channel", "clm_cn_id", $channelId);

                    $image = md5(time()) . "__channel.png";
                    $oldImg = $get["clm_cn_logo"];

                    if ($oldImg != "empty") {

                        unlink('images/logo_channel/' . $oldImg);
                    }

                    $pic1 = $_FILES['image']['tmp_name'];
                    $tpath1 = 'images/logo_channel/' . $image;


                    copy($pic1, $tpath1);

                    $stmt = $db->prepare("UPDATE tbl_channel SET clm_cn_name = ? , clm_cn_link = ? ,
                     clm_cn_logo = ? , clm_cn_status = ? , clm_cn_type = ? WHERE clm_cn_id = ?");
                    $stmt->execute(array($name, $link, $image, $status, $type, $channelId));

                    returnToBack("success update channel with image", "success", "back");
                } else {

                    $stmt = $db->prepare("UPDATE tbl_channel SET clm_cn_name = ? , clm_cn_link = ? ,
                         clm_cn_status = ? , clm_cn_type = ? WHERE clm_cn_id = ?");
                    $stmt->execute(array($name, $link, $status, $type, $channelId));


                    returnToBack("success update channel", "success", "back");
                }
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
                                    <form method="post" action="?do=insert" enctype="multipart/form-data">


                                        <div class="img_box w-100% m-3">
                                            <div class="row">
                                                <div class="col-12">


                                                    <div tyle="margin:auto;" class="p-3">
                                                        <img  style="height: 300px;width:300px"  class="img-fluid rounded" type="image" id="profile-img" src="images/logo_channel/empty.png" alt="image" />
                                                    </div>

                                                </div>
                                                <div class="col-12 m-3">
                                                    <input class="form-control-file" accept="image/*" style="background: #d0d0e0;" type="file" name="image" id="file-img">
                                                </div>


                                            </div>
                                        </div>




                                        <div class="form-group">
                                            <label for="name" class="control-label mb-1">Name</label>
                                            <input data-msgAr="اسم" data-msgEng="name" type="text" id="name" name="name" class="form-control auto_direction" placeholder="name">
                                        </div>

                                        <div class="row form-group">
                                            <div class="col col-md-3"><label for="selectLg" class=" form-control-label">Type</label></div>
                                            <div class="col-12 col-md-9">
                                                <select name="type" id="selectLg" class="form-control-lg form-control">
                                                    <option disabled>Please select</option>
                                                    <option value="live_link">Live link</option>
                                                    <option value="youtube">Youtube Id (Not All Link)</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="link" class="control-label mb-1">Link</label>
                                            <input type="text" id="link" name="link" class="form-control" placeholder="link">
                                        </div>

                                        <div class="row form-group">
                                            <div class="col col-md-3"><label for="selectLg" class=" form-control-label">Status</label></div>
                                            <div class="col-12 col-md-9">
                                                <select name="status" id="selectLg" class="form-control-lg form-control">
                                                    <option disabled>Please select</option>
                                                    <option value="draft">Draft</option>
                                                    <option value="publish">Publish</option>
                                                </select>
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




                <?php


            } elseif ($do == "insert") {



                if ($_SERVER["REQUEST_METHOD"] == "POST") {


                    $name = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
                    $link = filter_var($_POST["link"], FILTER_SANITIZE_STRING);
                    $status = filter_var($_POST["status"], FILTER_SANITIZE_STRING);
                    $type = filter_var($_POST["type"], FILTER_SANITIZE_STRING);

                    if ($name == "") {

                        returnToBack("Please enter title...", "danger", "back");
                    } else if ($link == "") {
                        returnToBack("Please enter text...", "danger", "back");
                    } else {
                        if ($_FILES['image']['name'] != "" && $_FILES['image']['error'] == 0) {

                            $image = md5(time()) . "__channel.png";

                            $pic1 = $_FILES['image']['tmp_name'];
                            $tpath1 = 'images/logo_channel/' . $image;


                            copy($pic1, $tpath1);

                            $stmt = $db->prepare("INSERT INTO tbl_channel (clm_cn_name , clm_cn_link , clm_cn_logo , clm_cn_status , clm_cn_type ) VALUES (? , ? , ? ,? ,?) ");

                            $stmt->execute(array($name, $link, $image, $status, $type));

                            returnToBack("success add channel with image", "success", "back");
                        } else {


                            $stmt = $db->prepare("INSERT INTO tbl_channel (clm_cn_name , clm_cn_link , clm_cn_logo , clm_cn_status , clm_cn_type) VALUES (? , ? , ? ,? ,?) ");

                            $stmt->execute(array($name, $link, "empty", $status, $type));



                            returnToBack("success add channel", "success", "back");
                        }
                    }

                    /* POST */
                }

                /* end page insert */
            } else if ($do == "delete") {


                $channelId = isset($_GET["id"]) && is_numeric($_GET["id"]) ? intval($_GET["id"]) : 0;

                $count = checkItems("tbl_channel", "clm_cn_id", $channelId);
                if ($count > 0) {

                    $stmt = $db->prepare("DELETE FROM tbl_channel WHERE clm_cn_id = :ui ");
                    $stmt->bindparam("ui", $channelId);
                    $stmt->execute();

                    returnToBack("this channel is deleted", "success", "back");

                    /* EMPTY*/
                }
                /* end page delete */
            }


            require_once "includes/footer.php";
        }
        ob_end_flush();
                ?>