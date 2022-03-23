<?php
// number of items
function countItems($from, $select)
{
    global $db;
    $stmt = $db->prepare("SELECT COUNT($select) FROM $from");
    $stmt->execute();
    echo $stmt->fetchcolumn();
}


// change title of page
function getTitle()
{
    global $pageTitle;

    echo $pageTitle;
}
// breadcrumbs
function breadcrumbs($Ptitle, $Ctitle)
{
?>
    <div class="container-fluid">
        <ol class="breadcrumb mb-4 mt-4">
            <li class="breadcrumb-item">Dashboard</li>
            <li class="breadcrumb-item"><?php echo $Ptitle; ?></li>
            <li class="breadcrumb-item active"><?php echo $Ctitle; ?></li>
        </ol>
    </div>
<?php
}
// add add btn when ther is no data
function btnAdd($text)
{

?>

    <div class="container-fluid">
        <div class="row">


            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                            <span class="badge badge-pill badge-danger">Error</span>
                            <?php echo  "There Is Not Any Data "; ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div>
                            <button type="button" class="btn btn-primary btn-lg btn-block">
                                <a style="color: #ffffff;" href="?do=add"><?php echo $text; ?></a>
                            </button>
                        </div>
                    </div>

                </div> <!-- /.card -->
            </div> <!-- /.col-12 -->


    </div>
    </div>

<?php
}



// // go back
function returnToBack($msg, $class, $url = null, $sec = 3)
{
    if ($url == null) {

        $url = "home.php";
        $name = "Home";
    } else {

        if (isset($_SERVER["HTTP_REFERER"])) {
            $url = $_SERVER["HTTP_REFERER"];
            $name = "Back";
        } else {
            $url = "home.php";
            $name = "Home";
        }
    }

?>
    <div class="content">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">

                        <div class="sufee-alert alert with-close alert-<?php echo $class ?> alert-dismissible fade show">

                            <span class="badge badge-pill badge-<?php echo $class ?>"><?php echo $class ?></span>

                            <div><?php echo $msg; ?> </div>
                            <div>you will be redirected in <?php echo $sec ?> seconds To <?php echo $name ?></div>

                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                    </div>
                </div> <!-- /.card -->
            </div> <!-- /.col-lg-8 -->
        </div>
    </div>
    <!-- /.content -->
<?php


    header("Refresh: $sec; url=$url");
    exit();
}

// count item by where
function checkItem($from, $select, $value)
{
    global $db;
    $stmt = $db->prepare("SELECT * FROM $from WHERE $select = ? ");
    $stmt->execute(array($value));
    $count = $stmt->rowcount();
    return $count;
}
// count items
function checkItems($from, $select)
{
    global $db;
    $stmt = $db->prepare("SELECT $select FROM $from");
    $stmt->execute();
    $count =  $stmt->rowcount();
    return $count;
}
// get item by where
function getItem($from, $select, $value)
{
    global $db;
    $stmt = $db->prepare("SELECT * FROM $from WHERE $select = ? LIMIT 1");
    $stmt->execute(array($value));
    $fetch = $stmt->fetch();
    return $fetch;
}


// get items
function getItems($from, $select)
{
    global $db;
    $stmt = $db->prepare("SELECT $select FROM $from");
    $stmt->execute();
    $fetchall = $stmt->fetchall();
    return $fetchall;
}

//Convert Emoji from Unicode in PHP
function decodeEmoticons($src) {
    $result = preg_replace("/\\\\u([0-9A-F]{1,4})/i", "&#x$1;", $src);
    $result = mb_convert_encoding($result, "UTF-16", "HTML-ENTITIES");
    $result = mb_convert_encoding($result, 'utf-8', 'utf-16');
    return $result;
}
// check email
// function email_check($email){
//     $exp = "/^[a-z\'0-9]+([._-][a-z\'0-9]+)*@([a-z0-9]+([._-][a-z0-9]+))+$/";
//     if(preg_match($exp,$email)){
//          $domin = explode("@",$email)[1] ;
//         if( checkdnsrr($domin))
//         {return true;}
//         else
//         {return false;}

//     }
//     else{return false;}    
// }


?>