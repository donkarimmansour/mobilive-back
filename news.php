<?php
require_once "includes/header.php";



if (!isset($_SESSION['admin_id'])) {

    header("Location:index.php");
    exit;
} else {

    breadcrumbs("ELEMENTS", "News");

    $do = isset($_GET["do"]) ? $_GET["do"] : "manage";

    if ($do == "manage") {

        $sort = "ASC";

        $arr_sort = array("DESC", "ASC");

        if (isset($_GET["sort"]) && in_array($_GET["sort"], $arr_sort)) {

            $sort = $_GET["sort"];
        }

        $stmt = $db->prepare("SELECT from_unixtime(UNIX_TIMESTAMP(clm_nw_date),'%y') as year ,
         from_unixtime(UNIX_TIMESTAMP(clm_nw_date),'%M') as month ,
        from_unixtime(UNIX_TIMESTAMP(clm_nw_date),'%D') as day ,
         clm_nw_id ,clm_nw_title , clm_nw_status ,clm_nw_img
         FROM tbl_news ORDER BY `clm_nw_id` $sort");

        $stmt->execute();
        $getAll = $stmt->fetchall();



        if (!empty($getAll)) {
?>



            <div class="container-fluid">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        News

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
                                        <th>Img</th>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Modify</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Img</th>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Status</th>
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

                                            <td>

                                                <div class="round-img" style="margin: auto;">
                                                    <?php $img = $get["clm_nw_img"] != "empty" ? $get["clm_nw_img"] : "empty.png"; ?>
                                                    <img  style="max-width: 80px;"  class="img-fluid rounded" src="images/img_news/<?php echo $img; ?>" alt="">
                                                </div>

                                            </td>

                                            <td> #<?php echo $get["clm_nw_id"]; ?> </td>
                                            <td> <span class="name">

                                                    <?php

                                                    $title = $get["clm_nw_title"];

                                                    if (strlen($title) < 20) {
                                                        echo $title;
                                                    } else {
                                                        echo substr($title, 0, 20) . "..";
                                                    }

                                                    ?> </span> </td>

                                            <td> <span class="product"><?php echo $get["clm_nw_status"]; ?> </span> </td>
                                            <td>
                                                <span class="count"><?php echo $get["year"]; ?> </span>
                                                /<span> <?php echo $get["month"]  . " / " . $get["day"]; ?> </span>
                                            </td>
                                            <td style="text-align: center;">
                                                <a href="?do=edit&id=<?php echo $get["clm_nw_id"]; ?>"><span class="btn btn-success"><i class='fa fa-edit'></i> Edit</span></a>
                                                <a href="?do=delete&id=<?php echo $get["clm_nw_id"]; ?>"><span class="btn btn-danger confirm"><i class='fas fa-trash-alt'></i> Delete</span></a>
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
                        <a style="color: #ffffff;" href="?do=add">Add New News</a>
                    </button>
                </div>


            </div>
            <!-- /.content -->





        <?php


        } else {
            btnAdd("Add New News");
        }
    } else if ($do == "edit") {
        // edit

        $newsId = isset($_GET["id"]) && is_numeric($_GET["id"]) ? intval($_GET["id"]) : 0;

        $count = checkItems("tbl_news", "clm_nw_id", $newsId);

        if ($count > 0) {
            $get = getItem("tbl_news", "clm_nw_id", $newsId);

        ?>

            <!-- Content -->
            <div class="container">

                <div class="card">
                    <div class="card-body">
                        <h4 class="box-title">Edit</h4>
                    </div>
                    <div class="card-body text-center">

                        <form method="post" action="?do=update" enctype="multipart/form-data">

                            <?php $img = $get["clm_nw_img"] != "empty" ? $get["clm_nw_img"] : "empty.png"; ?>

                            <div class="img_box w-100% m-3">
                                <div class="row">
                                    <div class="col-12">


                                        <div style="margin:auto;" class="p-3">
                                            <?php if ($img != "empty") { ?>
                                                <img  style="height: 300px;width:300px"  class="img-fluid rounded" type="image" id="profile-img" src="images/img_news/<?php echo $img; ?>" alt="profile image" />
                                            <?php } else { ?>
                                                <img  style="height: 300px;width:300px"  class="img-fluid rounded" type="image" id="profile-img" src="images/img_news/empty.png" alt="add image" />
                                            <?php } ?></div>

                                    </div>
                                    <div class="col-12 m-3">
                                        <input class="form-control-file" accept="image/*" style="background: #d0d0e0;" type="file" name="image" id="file-img">
                                    </div>


                                </div>
                            </div>


                            <input type="hidden" name="id" value="<?php echo  $newsId;  ?>">

                            <div class="form-group">
                                <label for="title" class="control-label mb-1">Title</label>
                                <input data-msgAr="عنوان" data-msgEng="Title" type="text" id="title" name="title" class="form-control auto_direction" placeholder="Title" value="<?php echo $get['clm_nw_title']; ?>">
                            </div>

                            <div class="form-group">
                                <label for="text">Text</label>
                                <textarea type="text" class="form-control auto_direction" name="text" id="text" data-msgAr="النص فقط" data-msgEng="only text" placeholder="only text" rows="10"><?php echo $get['clm_nw_desc']; ?></textarea>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="selectLg" class=" form-control-label">Status</label></div>
                                <div class="col-12 col-md-9">
                                    <select name="status" id="selectLg" class="form-control-lg form-control">
                                        <option disabled>Please select</option>

                                        <option value="draft" <?php if ($get["clm_nw_status"] == "draft") {
                                                                    echo "Selected";
                                                                } ?>>Draft</option>
                                        <option value="publish" <?php if ($get["clm_nw_status"] == "publish") {
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


        <?php
            /* end page html */  }
        /* end page edit */
    } elseif ($do == "update") {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $title = filter_var($_POST["title"], FILTER_SANITIZE_STRING);
            $text = filter_var($_POST["text"], FILTER_SANITIZE_STRING);
            $status = filter_var($_POST["status"], FILTER_SANITIZE_STRING);

            $newsid = $_POST["id"];



            if ($title == "") {

                returnToBack("Please enter title...", "danger", "back");
            } else if ($text == "") {
                returnToBack("Please enter text...", "danger", "back");
            } else {


                if ($_FILES['image']['name'] != "" && $_FILES['image']['error'] == 0) {

                    $get = getItem("tbl_news", "clm_nw_id", $newsid);

                    $image = md5(time()) . "__articale.png";
                    $oldImg = $get["clm_nw_img"];

                    if ($oldImg != "empty") {

                        unlink('images/img_news/' . $oldImg);
                    }

                    $pic1 = $_FILES['image']['tmp_name'];
                    $tpath1 = 'images/img_news/' . $image;


                    copy($pic1, $tpath1);

                    $stmt = $db->prepare("UPDATE tbl_news SET clm_nw_title = ? , clm_nw_desc = ? ,
                     clm_nw_img = ? , clm_nw_status = ?  WHERE clm_nw_id = ?");
                    $stmt->execute(array($title, $text, $image, $status, $newsid));

                    returnToBack("success update articale with image", "success", "back");
                } else {

                    $stmt = $db->prepare("UPDATE tbl_news SET clm_nw_title = ? , clm_nw_desc = ? ,
                         clm_nw_status = ?  WHERE clm_nw_id = ?");
                    $stmt->execute(array($title, $text, $status, $newsid));


                    returnToBack("success update articale", "success", "back");
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
                <div class="card-body text-center">
                    <div class="sufee-login d-flex align-content-center flex-wrap">
                        <div class="container">

                            <div class="login-content">
                                <div class="login-form">
                                    <form method="post" action="?do=insert" enctype="multipart/form-data">


                                        <div class="img_box w-100% m-3">
                                            <div class="row">
                                                <div class="col-12">


                                                    <div style="margin:auto" class="p-3">
                                                        <img  style="height: 300px;width:300px"  class="img-fluid rounded" type="image" id="profile-img" src="images/img_news/empty.png" alt="image" />
                                                    </div>

                                                </div>
                                                <div class="col-12 m-3">
                                                    <input class="form-control-file" accept="image/*" style="background: #d0d0e0;" type="file" name="image" id="file-img">
                                                </div>


                                            </div>
                                        </div>



                                        <div class="form-group">
                                            <label for="title" class="control-label mb-1">Title</label>
                                            <input data-msgAr="عنوان" data-msgEng="Title" type="text" id="title" name="title" class="form-control auto_direction" placeholder="Title">
                                        </div>

                                        <div class="form-group">
                                            <label for="text">Text</label>
                                            <textarea type="text" class="form-control auto_direction" name="text" id="text" data-msgAr="النص فقط" data-msgEng="only text" placeholder="only text" rows="10"></textarea>
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
                                            <button  type="submit" class="btn btn-lg btn-info btn-block">
                                                <span >Add</span>
                                            </button>
                                        </div>
                                    </form>


                                </div>
                            </div> <!-- /.card -->

                        </div>




                <?php


            } elseif ($do == "insert") {



                if ($_SERVER["REQUEST_METHOD"] == "POST") {

                    $title = filter_var($_POST["title"], FILTER_SANITIZE_STRING);
                    $text = filter_var($_POST["text"], FILTER_SANITIZE_STRING);
                    $status = filter_var($_POST["status"], FILTER_SANITIZE_STRING);

                    if ($title == "") {

                        returnToBack("Please enter title...", "danger", "back");
                    } else if ($text == "") {
                        returnToBack("Please enter text...", "danger", "back");
                    } else {
                        if ($_FILES['image']['name'] != "" && $_FILES['image']['error'] == 0) {

                            $image = md5(time()) . "__articale.png";

                            $pic1 = $_FILES['image']['tmp_name'];
                            $tpath1 = 'images/img_news/' . $image;


                            copy($pic1, $tpath1);

                            $stmt = $db->prepare("INSERT INTO tbl_news (clm_nw_title , clm_nw_desc , clm_nw_img , clm_nw_status ) VALUES (? , ? , ? ,? ) ");

                            $stmt->execute(array($title, $text, $image, $status));

                            returnToBack("success add articale with image", "success", "back");
                        } else {

                            $stmt = $db->prepare("INSERT INTO tbl_news (clm_nw_title , clm_nw_desc , clm_nw_img , clm_nw_status ) VALUES (? , ? , ? ,? ) ");
                            $stmt->execute(array($title, $text, "empty", $status));


                            returnToBack("success add articale", "success", "back");
                        }
                    }

                    /* POST */
                }

                /* end page insert */
            } else if ($do == "delete") {


                $newsId = isset($_GET["id"]) && is_numeric($_GET["id"]) ? intval($_GET["id"]) : 0;

                $count = checkItems("tbl_news", "clm_nw_id", $userId);
                if ($count > 0) {

                    $stmt = $db->prepare("DELETE FROM tbl_news WHERE clm_nw_id = :ui ");
                    $stmt->bindparam("ui", $newsId);
                    $stmt->execute();

                    returnToBack("this articale is deleted", "success", "back");

                    /* EMPTY*/
                }
                /* end page delete */
            }


            require_once "includes/footer.php";
        }
        ob_end_flush();
                ?>