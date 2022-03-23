<?php
require_once "includes/header.php";



if (!isset($_SESSION['admin_id'])) {

    header("Location:index.php");
    exit;
} else {

    breadcrumbs("ELEMENTS", "Matches");

    $do = isset($_GET["do"]) ? $_GET["do"] : "manage";

    if ($do == "manage") {

        $sort = "ASC";

        $arr_sort = array("DESC", "ASC");

        if (isset($_GET["sort"]) && in_array($_GET["sort"], $arr_sort)) {

            $sort = $_GET["sort"];
        }

        $stmt = $db->prepare("SELECT * FROM tbl_matches ORDER BY `clm_m_id` $sort");

        $stmt->execute();
        $getAll = $stmt->fetchall();



        if (!empty($getAll)) {
?>


            <div class="container-fluid">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>

                        Matches


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
                                        <th>ID</th>
                                        <th>Host Logo</th>
                                        <th>Host Name</th>
                                        <th>Time</th>
                                        <th>Guest Name</th>
                                        <th>Guest Logo</th>
                                        <th>Status</th>
                                        <th>Modify</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>ID</th>
                                        <th>Host Logo</th>
                                        <th>Host Name</th>
                                        <th>Time</th>
                                        <th>Guest Name</th>
                                        <th>Guest Logo</th>
                                        <th>Status</th>
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

                                            <td> #<?php echo $get["clm_m_id"]; ?> </td>

                                            <td>

                                                <div class="round-img">
                                                    <?php $img = $get["clm_m_host_logo"] != "empty" ? $get["clm_m_host_logo"] : "empty.png"; ?>
                                                    <img style="width: 50px;height: 50px;" class="rounded-circle" src="images/logo_team/<?php echo $img; ?>" alt="">
                                                </div>

                                            </td>

                                            <td>

                                                <?php

                                                $title = $get["clm_m_host_name"];

                                                if (strlen($title) < 15) {
                                                    echo $title;
                                                } else {
                                                    echo substr($title, 0, 15) . "..";
                                                }

                                                ?> </td>

                                            <td>
                                                <?php echo $get["clm_m_date"]; ?> </td>
                                            <td>

                                                <?php

                                                $title = $get["clm_m_guest_name"];

                                                if (strlen($title) < 15) {
                                                    echo $title;
                                                } else {
                                                    echo substr($title, 0, 15) . "..";
                                                }

                                                ?> </td>

                                            <td>

                                                <div class="round-img">
                                                    <?php $img = $get["clm_m_guest_logo"] != "empty" ? $get["clm_m_guest_logo"] : "empty.png"; ?>
                                                    <img style="width: 50px;height: 50px;" class="rounded-circle" src="images/logo_team/<?php echo $img; ?>" alt="">
                                                </div>

                                            </td>
                                            <td> <span class="product"><?php echo $get["clm_m_status"]; ?> </span> </td>

                                            <td style="text-align: center;">
                                                <a href="?do=edit&id=<?php echo $get["clm_m_id"]; ?>"><span class="btn btn-success"><i class='fa fa-edit'></i> Edit</span></a>
                                                <a href="?do=delete&id=<?php echo $get["clm_m_id"]; ?>"><span class="btn btn-danger confirm"><i class='fas fa-trash-alt'></i> Delete</span></a>
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
                        <a style="color: #ffffff;" href="?do=add">Add New Match</a>
                    </button>
                </div>


            </div>
            <!-- /.content -->



        <?php


        } else {
            btnAdd("Add New Match");
        }
    } else if ($do == "edit") {
        // edit

        $matchId = isset($_GET["id"]) && is_numeric($_GET["id"]) ? intval($_GET["id"]) : 0;

        $count = checkItems("tbl_matches", "clm_m_id", $matchId);

        if ($count > 0) {
            $get = getItem("tbl_matches", "clm_m_id", $matchId);

        ?>

            <!-- Content -->
            <div class="container">
                <div class="card">
                    <div class="card-body">
                        <h4 class="box-title">Edit</h4>
                    </div>
                    <div class="card-body text-center">

                        <form method="post" action="?do=update" enctype="multipart/form-data">

                            <?php $host_logo = $get["clm_m_host_logo"] != "empty" ? $get["clm_m_host_logo"] : "empty.png";
                            $guest_logo = $get["clm_m_guest_logo"] != "empty" ? $get["clm_m_guest_logo"] : "empty.png";
                            ?>

                            <div class="img_box w-100% m-3">
                                <div class="row">
                                    <div class="col-6">


                                        <div style="margin:auto;" class="p-3">
                                            <?php if ($host_logo != "empty") { ?>
                                                <img class="img-fluid rounded" type="image" id="profile-img" src="images/logo_team/<?php echo $host_logo; ?>" alt="profile image" />
                                            <?php } else { ?>
                                                <img class="img-fluid rounded" type="image" id="profile-img" src="images/logo_team/empty.png" alt="add image" />
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div style="margin:auto;" class="p-3">
                                            <?php if ($guest_logo != "empty") { ?>
                                                <img class="img-fluid rounded" type="image" id="profile_img" src="images/logo_team/<?php echo $guest_logo; ?>" alt="profile image" />
                                            <?php } else { ?>
                                                <img class="img-fluid rounded" type="image" id="profile_img" src="images/logo_team/empty.png" alt="add image" />
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="col-12 m-3">
                                        <label for="file-img" class="btn">Select host logo</label>
                                        <input class="form-control-file" accept="image/*" style="background: #d0d0e0;" type="file" name="host_logo" id="file-img">
                                    </div>

                                    <div class="col-12 m-3">
                                        <label for="file_img" class="btn">Select guest logo</label>
                                        <input class="form-control-file" accept="image/*" style="background: #d0d0e0;" type="file" name="guest_logo" id="file_img">
                                    </div>


                                </div>
                            </div>


                            <input type="hidden" name="id" value="<?php echo  $matchId;  ?>">

                            <div class="row form-group">

                                <div class="col col-6">
                                    <label for="host_name" class="control-label mb-1">host name</label>
                                    <input data-msgAr="اسم المضيف" data-msgEng="host name" type="text" id="host_name" name="host_name" class="form-control auto_direction" placeholder="host name" value="<?php echo $get['clm_m_host_name']; ?>"></div>
                                <div class="col col-6">
                                    <label for="guest_name" class="control-label mb-1">guest name</label>
                                    <input data-msgAr="اسم الضيف" data-msgEng="guest name" type="text" id="guest_name" name="guest_name" class="form-control auto_direction" placeholder="guest name" value="<?php echo $get['clm_m_guest_name']; ?>"></div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-sm-6"><label for="time" class="control-label mb-1">Time</label></div>
                                <div class="col col-sm-6"><input type="text" id="time" name="time" class="form-control text-center" placeholder="time" value="<?php echo $get['clm_m_date']; ?>"></div>
                            </div>


                            <div class="row form-group">
                                <div class="col col-md-3"><label for="selectLg" class=" form-control-label">Status</label></div>
                                <div class="col-12 col-md-9">
                                    <select name="status" id="selectLg" class="form-control-lg form-control">
                                        <option disabled>Please select</option>

                                        <option value="draft" <?php if ($get["clm_m_status"] == "draft") {
                                                                    echo "Selected";
                                                                } ?>>Draft</option>
                                        <option value="publish" <?php if ($get["clm_m_status"] == "publish") {
                                                                    echo "Selected";
                                                                } ?>>Publish</option>

                                    </select>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="selectLg" class=" form-control-label">Channel One</label></div>
                                <div class="col-12 col-md-9">
                                    <select name="channel_one" id="selectLg" class="form-control-lg form-control">
                                        <option disabled>Please select Channel</option>
                                        <?php


                                        $channels = getItems("tbl_channel", "*");
                                        $channelscount = checkItems("tbl_channel", "*");

                                        if ($channelscount > 0) {
                                            foreach ($channels as $channel) {

                                        ?>
                                                <option value="<?php echo $channel["clm_cn_id"] ?>" <?php if ($channel["clm_cn_id"] == $get["clm_m_cn_id_one"]) {
                                                                                                        echo "Selected";
                                                                                                    } ?>>
                                                    <?php echo $channel["clm_cn_name"] ?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="selectLg" class=" form-control-label">Channel Two</label></div>
                                <div class="col-12 col-md-9">
                                    <select name="channel_two" id="selectLg" class="form-control-lg form-control">
                                        <option disabled>Please select Channel</option>
                                        <?php


                                        $channels = getItems("tbl_channel", "*");
                                        $channelscount = checkItems("tbl_channel", "*");

                                        if ($channelscount > 0) {
                                            foreach ($channels as $channel) {
                                        ?>
                                                <option value="<?php echo $channel["clm_cn_id"] ?>" <?php if ($channel["clm_cn_id"] == $get["clm_m_cn_id_two"]) {
                                                                                                        echo "Selected";
                                                                                                    } ?>>
                                                    <?php echo $channel["clm_cn_name"] ?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="selectLg" class=" form-control-label">Channel Three</label></div>
                                <div class="col-12 col-md-9">
                                    <select name="channel_three" id="selectLg" class="form-control-lg form-control">
                                        <option disabled>Please select Channel</option>
                                        <?php


                                        $channels = getItems("tbl_channel", "*");
                                        $channelscount = checkItems("tbl_channel", "*");

                                        if ($channelscount > 0) {
                                            foreach ($channels as $channel) {
                                        ?>
                                                <option value="<?php echo $channel["clm_cn_id"] ?>" <?php if ($channel["clm_cn_id"] == $get["clm_m_cn_id_three"]) {
                                                                                                        echo "Selected";
                                                                                                    } ?>>
                                                    <?php echo $channel["clm_cn_name"] ?></option>
                                        <?php
                                            }
                                        }
                                        ?>
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

            $host_name = filter_var($_POST["host_name"], FILTER_SANITIZE_STRING);
            $guest_name = filter_var($_POST["guest_name"], FILTER_SANITIZE_STRING);
            $time = filter_var($_POST["time"], FILTER_SANITIZE_STRING);
            $status = filter_var($_POST["status"], FILTER_SANITIZE_STRING);
            $channel_one = filter_var($_POST["channel_one"], FILTER_SANITIZE_NUMBER_INT);
            $channel_two = filter_var($_POST["channel_two"], FILTER_SANITIZE_NUMBER_INT);
            $channel_three = filter_var($_POST["channel_three"], FILTER_SANITIZE_NUMBER_INT);

            $matchId = $_POST["id"];



            if ($host_name == "") {

                returnToBack("Please enter host name...", "danger", "back");
            } else if ($guest_name == "") {
                returnToBack("Please enter guest name...", "danger", "back");
            } else if ($time == "") {
                returnToBack("Please enter time...", "danger", "back");
            } else {

                if (
                    $_FILES['host_logo']['name'] != "" && $_FILES['host_logo']['error'] == 0
                    && $_FILES['guest_logo']['name'] != "" && $_FILES['guest_logo']['error'] == 0
                ) {

                    $get = getItem("tbl_matches", "clm_m_id", $matchId);

                    $hostimage = md5(time()) . "_host_match.png";
                    $guestimage = md5(time()) . "_guest_match.png";
                    $hostoldImg = $get["clm_m_host_logo"];
                    $guestoldImg = $get["clm_m_guest_logo"];

                    if ($hostoldImg != "empty") {

                        unlink('images/logo_team/' . $hostoldImg);
                    }
                    if ($guestoldImg != "empty") {

                        unlink('images/logo_team/' . $guestoldImg);
                    }

                    $Hpic1 = $_FILES['host_logo']['tmp_name'];
                    $Htpath1 = 'images/logo_team/' . $hostimage;

                    $Gpic1 = $_FILES['guest_logo']['tmp_name'];
                    $Gtpath1 = 'images/logo_team/' . $guestimage;


                    for ($i = 0; $i <= 1; $i++) {
                        if ($i == 0) copy($Hpic1, $Htpath1);
                        if ($i == 1) copy($Gpic1, $Gtpath1);
                    }

                    $stmt = $db->prepare("UPDATE tbl_matches SET clm_m_host_name = ? , clm_m_guest_name = ? ,
                            clm_m_date = ? , clm_m_status = ? , clm_m_cn_id_one = ? , 	clm_m_cn_id_two = ? , clm_m_cn_id_three = ?
                            , clm_m_host_logo = ? , clm_m_guest_logo = ? WHERE clm_m_id = ?");
                    $stmt->execute(array(
                        $host_name, $guest_name, $time, $status,
                        $channel_one, $channel_two, $channel_three, $hostimage, $guestimage, $matchId
                    ));

                    returnToBack("success update match with two logo", "success", "back");
                } else if ($_FILES['host_logo']['name'] != "" && $_FILES['host_logo']['error'] == 0 && $_FILES['guest_logo']['name'] == "") {

                    $get = getItem("tbl_matches", "clm_m_id", $matchId);

                    $image = md5(time()) . "_host_match.png";
                    $oldImg = $get["clm_m_host_logo"];

                    if ($oldImg != "empty") {

                        unlink('images/logo_team/' . $oldImg);
                    }

                    $pic1 = $_FILES['host_logo']['tmp_name'];
                    $tpath1 = 'images/logo_team/' . $image;


                    copy($pic1, $tpath1);

                    $stmt = $db->prepare("UPDATE tbl_matches SET clm_m_host_name = ? , clm_m_guest_name = ? ,
                                clm_m_date = ? , clm_m_status = ? , clm_m_cn_id_one = ? , 	clm_m_cn_id_two = ? , clm_m_cn_id_three = ?
                                , clm_m_host_logo = ? WHERE clm_m_id = ?");
                    $stmt->execute(array(
                        $host_name, $guest_name, $time, $status,
                        $channel_one, $channel_two, $channel_three, $image, $matchId
                    ));

                    returnToBack("success update match with host logo", "success", "back");
                } else if ($_FILES['guest_logo']['name'] != "" && $_FILES['guest_logo']['error'] == 0 && $_FILES['host_logo']['name'] == "") {

                    $get = getItem("tbl_matches", "clm_m_id", $matchId);

                    $image = md5(time()) . "_guest_match.png";
                    $oldImg = $get["clm_m_guest_logo"];

                    if ($oldImg != "empty") {

                        unlink('images/logo_team/' . $oldImg);
                    }

                    $pic1 = $_FILES['guest_logo']['tmp_name'];
                    $tpath1 = 'images/logo_team/' . $image;


                    copy($pic1, $tpath1);

                    $stmt = $db->prepare("UPDATE tbl_matches SET clm_m_host_name = ? , clm_m_guest_name = ? ,
                                clm_m_date = ? , clm_m_status = ? , clm_m_cn_id_one = ? , 	clm_m_cn_id_two = ? , clm_m_cn_id_three = ?
                                 , clm_m_guest_logo = ? WHERE clm_m_id = ?");
                    $stmt->execute(array(
                        $host_name, $guest_name, $time, $status,
                        $channel_one, $channel_two, $channel_three, $image, $matchId
                    ));

                    returnToBack("success update match with guest logo", "success", "back");
                } else {

                    $stmt = $db->prepare("UPDATE tbl_matches SET clm_m_host_name = ? , clm_m_guest_name = ? ,
                         clm_m_date = ? , clm_m_status = ? , clm_m_cn_id_one = ? , 	clm_m_cn_id_two = ? , clm_m_cn_id_three = ?
                         WHERE clm_m_id = ?");
                    $stmt->execute(array($host_name, $guest_name, $time, $status, $channel_one, $channel_two, $channel_three, $matchId));


                    returnToBack("success update match", "success", "back");
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

                    <form method="post" action="?do=insert" enctype="multipart/form-data">

                        <div class="img_box w-100% ">
                            <div class="row">

                                <div class="col-6">
                                    <div style="margin:auto;" >
                                        <img class="img-fluid rounded" type="image" id="profile-img" src="images/logo_team/empty.png" alt="add image" />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div style="margin:auto;" >
                                        <img class="img-fluid rounded" type="image" id="profile_img" src="images/logo_team/empty.png" alt="add image" />
                                    </div>
                                </div>

                                <div class="col-12 m-3">
                                    <label for="file-img" class="btn">Select host logo</label>
                                    <input class="form-control-file" accept="image/*" style="background: #d0d0e0;" type="file" name="host_logo" id="file-img">
                                </div>

                                <div class="col-12 m-3">
                                    <label for="file_img" class="btn">Select guest logo</label>
                                    <input class="form-control-file" accept="image/*" style="background: #d0d0e0;" type="file" name="guest_logo" id="file_img">
                                </div>


                            </div>
                        </div>


                        <div class="row form-group">

                            <div class="col col-6">
                                <div class="form-group">
                                    <label for="host_name" class="control-label mb-1">host name</label>
                                    <input data-msgAr="اسم المضيف" data-msgEng="host name" type="text" id="host_name" name="host_name" class="form-control auto_direction" placeholder="host name"></div>
                            </div>
                            <div class="col col-6">
                                <div class="form-group">
                                    <label for="guest_name" class="control-label mb-1">guest name</label>
                                    <input data-msgAr="اسم الضيف" data-msgEng="guest name" type="text" id="guest_name" name="guest_name" class="form-control auto_direction" placeholder="guest name"></div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col col-sm-6"><label for="time" class="control-label mb-1">Time</label></div>
                            <div class="col col-sm-6"><input type="text" id="time" name="time" class="form-control text-center" placeholder="time"></div>
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

                        <div class="row form-group">
                            <div class="col col-md-3"><label for="selectLg" class=" form-control-label">Channel One</label></div>
                            <div class="col-12 col-md-9">
                                <select name="channel_one" id="selectLg" class="form-control-lg form-control">
                                    <option disabled>Please select Channel</option>
                                    <?php


                                    $channels = getItems("tbl_channel", "*");
                                    $channelscount = checkItems("tbl_channel", "*");

                                    if ($channelscount > 0) {
                                        foreach ($channels as $channel) {

                                    ?>
                                            <option value="<?php echo $channel["clm_cn_id"] ?>">
                                                <?php echo $channel["clm_cn_name"] ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col col-md-3"><label for="selectLg" class=" form-control-label">Channel Two</label></div>
                            <div class="col-12 col-md-9">
                                <select name="channel_two" id="selectLg" class="form-control-lg form-control">
                                    <option disabled>Please select Channel</option>
                                    <?php


                                    $channels = getItems("tbl_channel", "*");
                                    $channelscount = checkItems("tbl_channel", "*");

                                    if ($channelscount > 0) {
                                        foreach ($channels as $channel) {
                                    ?>
                                            <option value="<?php echo $channel["clm_cn_id"] ?>">
                                                <?php echo $channel["clm_cn_name"] ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col col-md-3"><label for="selectLg" class=" form-control-label">Channel Three</label></div>
                            <div class="col-12 col-md-9">
                                <select name="channel_three" id="selectLg" class="form-control-lg form-control">
                                    <option disabled>Please select Channel</option>
                                    <?php


                                    $channels = getItems("tbl_channel", "*");
                                    $channelscount = checkItems("tbl_channel", "*");

                                    if ($channelscount > 0) {
                                        foreach ($channels as $channel) {
                                    ?>
                                            <option value="<?php echo $channel["clm_cn_id"] ?>">
                                                <?php echo $channel["clm_cn_name"] ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
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

            $host_name = filter_var($_POST["host_name"], FILTER_SANITIZE_STRING);
            $guest_name = filter_var($_POST["guest_name"], FILTER_SANITIZE_STRING);
            $time = filter_var($_POST["time"], FILTER_SANITIZE_STRING);
            $status = filter_var($_POST["status"], FILTER_SANITIZE_STRING);
            $channel_one = filter_var($_POST["channel_one"], FILTER_SANITIZE_NUMBER_INT);
            $channel_two = filter_var($_POST["channel_two"], FILTER_SANITIZE_NUMBER_INT);
            $channel_three = filter_var($_POST["channel_three"], FILTER_SANITIZE_NUMBER_INT);



            if ($host_name == "") {

                returnToBack("Please enter host name...", "danger", "back");
            } else if ($guest_name == "") {
                returnToBack("Please enter guest name...", "danger", "back");
            } else if ($time == "") {
                returnToBack("Please enter time...", "danger", "back");
            } else {

                if (
                    $_FILES['host_logo']['name'] != "" && $_FILES['host_logo']['error'] == 0
                    && $_FILES['guest_logo']['name'] != "" && $_FILES['guest_logo']['error'] == 0
                ) {

                    $hostimage = md5(time()) . "_host_match.png";
                    $guestimage = md5(time()) . "_guest_match.png";


                    $Hpic1 = $_FILES['host_logo']['tmp_name'];
                    $Htpath1 = 'images/logo_team/' . $hostimage;

                    $Gpic1 = $_FILES['guest_logo']['tmp_name'];
                    $Gtpath1 = 'images/logo_team/' . $guestimage;


                    for ($i = 0; $i <= 1; $i++) {
                        if ($i == 0) copy($Hpic1, $Htpath1);
                        if ($i == 1) copy($Gpic1, $Gtpath1);
                    }

                    $stmt = $db->prepare("INSERT INTO tbl_matches (clm_m_host_name , clm_m_guest_name ,
                                clm_m_date , clm_m_status  , clm_m_cn_id_one  , clm_m_cn_id_two , clm_m_cn_id_three 
                                , clm_m_host_logo , clm_m_guest_logo ) VALUES (?,?,?,?,?,?,?,?,?)");
                    $stmt->execute(array(
                        $host_name, $guest_name, $time, $status,
                        $channel_one, $channel_two, $channel_three, $hostimage, $guestimage
                    ));

                    returnToBack("success add match with two logo", "success", "back");
                } else if ($_FILES['host_logo']['name'] != "" && $_FILES['host_logo']['error'] == 0 && $_FILES['guest_logo']['name'] == "") {


                    $image = md5(time()) . "_host_match.png";

                    $pic1 = $_FILES['host_logo']['tmp_name'];
                    $tpath1 = 'images/logo_team/' . $image;


                    copy($pic1, $tpath1);


                    $stmt = $db->prepare("INSERT INTO tbl_matches (clm_m_host_name , clm_m_guest_name ,
                                clm_m_date , clm_m_status  , clm_m_cn_id_one  , clm_m_cn_id_two , clm_m_cn_id_three 
                                , clm_m_host_logo , clm_m_guest_logo ) VALUES (?,?,?,?,?,?,?,?,?)");
                    $stmt->execute(array(
                        $host_name, $guest_name, $time, $status,
                        $channel_one, $channel_two, $channel_three, $image, "empty"
                    ));

                    returnToBack("success add match with host logo", "success", "back");
                } else if ($_FILES['guest_logo']['name'] != "" && $_FILES['guest_logo']['error'] == 0 && $_FILES['host_logo']['name'] == "") {

                    $image = md5(time()) . "_guest_match.png";

                    $pic1 = $_FILES['guest_logo']['tmp_name'];
                    $tpath1 = 'images/logo_team/' . $image;


                    copy($pic1, $tpath1);

                    $stmt = $db->prepare("INSERT INTO tbl_matches (clm_m_host_name , clm_m_guest_name ,
                                    clm_m_date , clm_m_status  , clm_m_cn_id_one  , clm_m_cn_id_two , clm_m_cn_id_three 
                                    , clm_m_host_logo , clm_m_guest_logo ) VALUES (?,?,?,?,?,?,?,?,?)");
                    $stmt->execute(array(
                        $host_name, $guest_name, $time, $status,
                        $channel_one, $channel_two, $channel_three, "empty", $image
                    ));

                    returnToBack("success add match with guest logo", "success", "back");
                } else {

                    $stmt = $db->prepare("INSERT INTO tbl_matches (clm_m_host_name , clm_m_guest_name ,
                            clm_m_date , clm_m_status  , clm_m_cn_id_one  , clm_m_cn_id_two , clm_m_cn_id_three 
                            , clm_m_host_logo , clm_m_guest_logo ) VALUES (?,?,?,?,?,?,?,?,?)");
                    $stmt->execute(array(
                        $host_name, $guest_name, $time, $status,
                        $channel_one, $channel_two, $channel_three, "empty", "empty"
                    ));


                    returnToBack("success add match", "success", "back");
                }
            }

            /* POST */
        }

        /* end page insert */
    } else if ($do == "delete") {


        $matchId = isset($_GET["id"]) && is_numeric($_GET["id"]) ? intval($_GET["id"]) : 0;

        $count = checkItems("tbl_matches", "clm_m_id", $matchId);
        if ($count > 0) {

            $stmt = $db->prepare("DELETE FROM tbl_matches WHERE clm_m_id = :ui ");
            $stmt->bindparam("ui", $matchId);
            $stmt->execute();

            returnToBack("this match is deleted", "success", "back");

            /* EMPTY*/
        }
        /* end page delete */
    }


    require_once "includes/footer.php";
}
ob_end_flush();
?>