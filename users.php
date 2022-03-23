<?php  

$pageTitle = basename(__FILE__,".php");
require_once "includes/header.php"; 

 if(!isset($_SESSION['admin_id'])){

    header( "Location:index.php");
			exit;
}else{

     breadcrumbs("Users","Users");

    $do = isset($_GET["do"]) ? $_GET["do"] : "manage";

    if($do == "manage"){ 
    
        $sort = "ASC" ;

        $arr_sort = array("DESC" , "ASC");
     
     if(isset($_GET["sort"]) && in_array($_GET["sort"], $arr_sort)){
     
        $sort = $_GET["sort"];
     }
       
        $stmt = $db->prepare("SELECT from_unixtime(UNIX_TIMESTAMP(clm_u_date),'%y') as year ,
         from_unixtime(UNIX_TIMESTAMP(clm_u_date),'%M') as month ,
        from_unixtime(UNIX_TIMESTAMP(clm_u_date),'%D') as day ,
         clm_u_id ,clm_u_username , clm_u_email ,clm_u_img
         FROM tbl_users WHERE  clm_u_id != -1 ORDER BY `clm_u_id` $sort");
       
        $stmt->execute();
        $getAll = $stmt->fetchall();
       
        
    
       if(!empty($getAll)){
       ?>

<div class="container-fluid">
<div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table mr-1"></i>
                   
                        Users 
                        <span style="float: right;"> 
                            <a style="<?php if(isset($_GET["sort"])  && $_GET["sort"] == "ASC"){ echo "font-weight: bold;color:black;" ;} else { echo "font-weight: 400;color:#6c757d;" ;} ?>" 
                            href="?sort=ASC">Asc</a><span> / </span>
                            <a style="<?php if(isset($_GET["sort"])  && $_GET["sort"] == "DESC"){ echo "font-weight: bold;color:black;" ;} else { echo "font-weight: 400;color:#6c757d;" ;}?>" 
                             href="?sort=DESC">Desc</a>
                        </span>
                             
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



  
                <div>
                  <button type="button" class="btn btn-primary btn-lg btn-block">
                     <a style="color: #ffffff;" href="?do=add">Add New Member</a>
                  </button>
                </div>

            
        </div>
        <!-- /.content -->
       

   

  <?php
        
        
    }
    else{ 
        btnAdd("Add New Member");

      }
  
  }
  else if($do == "edit"){
    // edit
     
     $userId = isset($_GET["id"]) && is_numeric($_GET["id"]) ? intval($_GET["id"]) : 0 ;
     $count = checkItems("tbl_users","clm_u_id",$userId);
     
     if($count > 0){
        $get = getItem("tbl_users","clm_u_id",$userId);
    

    ?>
    
    <div class="container">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="box-title">Edit</h4>
                                </div>
                                <div class="card-body text-center">

                                                <form method="post" action="?do=update" enctype="multipart/form-data">
                                                <input type="hidden" name="id" value="<?php echo  $userId;  ?>">

                                                
                                                <?php   $img = $get["clm_u_img"] != "empty" ? $get["clm_u_img"] : "empty.png" ; ?>

                                                <div class=" w-100% m-3">
                                                <div class="row"><div class="col-12">


                                                <div style="margin:auto;max-height: 400px;max-width:400px" class="p-3">
                                                <?php   if($img != "empty"){?>
                                                <img class="rounded-circle w-50" type="image" id="profile-img" src="images/img_user/<?php echo $img;?>" alt="profile image" />
                                                <?php } else {?>
                                                <img class=" rounded-circle w-50" type="image" id="profile-img" src="images/img_user/empty.png" alt="add image" />
                                                <?php }?></div>

                                                </div>
                                                <div class="col-12 m-3">
                                                <input accept="image/*" class="form-control-file" style="background: #d0d0e0;" type="file" name="image"   id="file-img">
                                                </div>


                                                </div></div>

                                                        
                                                    <div class="form-group">
                                                        <label for="name" class="control-label mb-1">Username</label>
                                                        <input type="text" id="name" value="<?php echo $get['clm_u_username']; ?>" name="username" class="form-control" placeholder="username">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="pass" class="control-label mb-1">Password</label>
                                                        <input type="password" id="pass" value="" name="password" class="form-control" placeholder="Password">
                                                        <input type="hidden" id="oldpass" value="<?php echo $get['clm_u_password']; ?>" name="oldpassword" class="form-control" placeholder="Password">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="email" class="control-label mb-1">Email</label>
                                                        <input type="email" id="email" value="<?php echo $get['clm_u_email']; ?>" name="email" class="form-control" placeholder="email">
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
    
    
    /* end page edit */  }     
        
    elseif($do == "update"){
  
        if($_SERVER["REQUEST_METHOD"] == "POST"){

            $username = filter_var($_POST["username"] , FILTER_SANITIZE_STRING);
            $password = filter_var($_POST["password"] , FILTER_SANITIZE_STRING);
            $email = filter_var($_POST["email"] , FILTER_SANITIZE_EMAIL);

            $userid = $_POST["id"];

            $pass = empty($_POST["password"]) ? $_POST["oldpassword"] : md5($_POST["password"]) ;

              
            if($username=="")
            {
                returnToBack("Please enter username...","danger","back");
              
            }
            else if($email=="") 
            {
                returnToBack("Please enter email...","danger","back");
             
            }
 
            else
            {
            
                    $stmt = $db->prepare("SELECT * FROM tbl_users WHERE clm_u_username = ? AND clm_u_id != ?");
                    $stmt->execute(array($username,$userid));
                    $check = $stmt->rowcount();
                    
                    if($check == 0 ){ 
                        if($_FILES['image']['name']!="" && $_FILES['image']['error'] == 0) {

                            $get = getItem("tbl_users","clm_u_id",$userid);

                                $image = $get['clm_u_username'] . md5(time()) . "__profile.png" ;
                                $oldImg = $get["clm_u_img"] ;
            
                                 if($oldImg != "empty")
                                 {
                                     
                                         unlink('images/img_user/'.$oldImg);
                                 }
                
                                   $pic1=$_FILES['image']['tmp_name'];
                                   $tpath1='images/img_user/'.$image;
                                 
                                    
                                    copy($pic1,$tpath1);
                                    
                         $stmt = $db->prepare("UPDATE tbl_users SET clm_u_username = ? , clm_u_password = ? ,
                         clm_u_email = ? , clm_u_img = ?  WHERE clm_u_id = ? ");
                         $stmt->execute(array($username,$pass,$email,$image,$userid));
                       
                          
                         returnToBack("success update profile with image","success","back");
            
                        }
                        else{

                         $stmt = $db->prepare("UPDATE tbl_users SET clm_u_username = ? , clm_u_password = ? ,
                         clm_u_email = ?  WHERE clm_u_id = ?");
                         $stmt->execute(array($username,$pass,$email,$userid));
    
                      
                         returnToBack("success update profile","success","back");
                        
                        }

                    /* chech name */}
                    else{
    
                        returnToBack("This Name Is Exists","danger","back");
                       
                       
                    } 
      
             }


   }
              
/* end page uploade */  }  
elseif($do == "add"){  
            ?>
            
              <!-- Content -->
        <div class="container">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="box-title">Add</h4>
                                </div>
                                <div class="card-body text-center">
                                
                                                <form method="post" action="?do=insert">
                        
                                                    <div class="form-group">
                                                        <label for="name" class="control-label mb-1">Username</label>
                                                        <input type="text" id="name"  name="username" class="form-control" placeholder="username">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="pass" class="control-label mb-1">Password</label>
                                                        <input type="password" id="pass"  name="password" class="form-control" placeholder="Password">
                                                
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="email" class="control-label mb-1">Email</label>
                                                        <input type="email" id="email" name="email" class="form-control" placeholder="email">
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


    
 <?php  }
         
         elseif($do == "insert"){

            if($_SERVER["REQUEST_METHOD"] == "POST"){

                $username = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
                $password = filter_var($_POST["password"] , FILTER_SANITIZE_STRING);
                $email = filter_var($_POST["email"] , FILTER_SANITIZE_EMAIL);
    
                  
                if($username=="")
                {
                    returnToBack("Please enter email...","danger","back");
                   
                }
                else if($password=="")
                {
    
                    returnToBack("Please enter password...","danger","back");
                
                }
                else if($email=="")
                {
    
                    returnToBack("Please enter email...","danger","back");
                
                }
     
                else
                {
    
                    $check = checkItem("tbl_users","clm_u_username",$username);
                    
                    if($check == 0 ){

                        $stmt = $db->prepare("INSERT INTO tbl_users (clm_u_username , clm_u_password , clm_u_email , clm_u_img ) VALUES (? , ? , ? ,? ) ");
                        $stmt->execute(array($username,md5($password),$email,"empty"));
    
                        returnToBack("success","success","back");
    
    
                    /* chech name */}
                    else{
    
                        returnToBack("This Name Is Exists","danger","back");
         
         /* CHECK */}
         
         /* EMPTY*/}
         
           /* POST */}
           
         
 /* end page insert */  }
        
 else if($do == "delete"){
 
 
    $userId = isset($_GET["id"]) && is_numeric($_GET["id"]) ? intval($_GET["id"]) : 0 ;

    $count = checkItems("tbl_users","clm_u_id",$userId);

    if($count > 0){

    $stmt = $db->prepare("DELETE FROM tbl_users WHERE clm_u_id = :ui ");
    $stmt->bindparam("ui" , $userId);
    $stmt->execute();
 
    returnToBack("this user is deleted","success","back");

   /* EMPTY*/}
 /* end page delete */  }
        
        
        require_once "includes/footer.php";
     }
     ob_end_flush();
     ?>