<?php   
  require_once "includes/header.php"; 

 

 if(!isset($_SESSION['admin_id'])){

    header( "Location:index.php");
			exit;
}else{


    $stmt = $db->prepare("SELECT * from tbl_admin where clm_a_id = ? ");
    $stmt->execute(array($_SESSION['admin_id']));
    $fetch = $stmt->fetch();
    $oldImg = $fetch['clm_a_img'] ;

    $image = $fetch['clm_a_user'] . md5(time()) . "__profile.png" ;


    if($_SERVER["REQUEST_METHOD"] == "POST"){

        $username = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
        $pass = empty($_POST["password"]) ? $_POST["oldpassword"] : md5($_POST["password"])  ;
        
        
            if(isset($_POST['submit']))  {

                if($username==""){
                   $_SESSION['msg'] = "Please enter user name...";
                 }
       	 
                else
                { 


	    	if($_FILES['image']['name']!="" && $_FILES['image']['error'] == 0) {		

			    if($oldImg != "empty")
		        {
					 
					     unlink('images/avatar/'.$oldImg);
			     }

				   $pic1=$_FILES['image']['tmp_name'];
				   $tpath1='images/avatar/'.$image;
 				
					
                    copy($pic1,$tpath1);
                    
                    $stmt = $db->prepare("UPDATE tbl_admin SET clm_a_user = ? , clm_a_pass = ? , clm_a_img = ? WHERE `clm_a_id` =  ? ");
                    $stmt->execute(array($username,$pass,$image,$_SESSION['admin_id']));

                        $stmt = $db->prepare("SELECT * from tbl_admin where clm_a_id = ? ");
                        $stmt->execute(array($_SESSION['admin_id']));

                        if($stmt->rowcount() > 0){ 
                            // $stmt = $db->prepare("SELECT * from tbl_admin where clm_a_id = ? ");
                            // $stmt->execute(array($_SESSION['admin_id']));
    
                            // $fetch = $stmt->fetch();
    
                            // $_SESSION['admin_user']= $fetch['clm_a_user'];
                            // $_SESSION['admin_pass']= $fetch['clm_a_pass'];
                            // $_SESSION['admin_img']= $fetch['clm_a_img'];
                            unset($_SESSION['msg']);
                           
                            returnToBack("success update profile with image","success","back");
                           
    
                         }// row
                 }else{
                    $stmt = $db->prepare("UPDATE tbl_admin SET clm_a_user = ? , clm_a_pass = ? WHERE `clm_a_id` =  ? ");
                    $stmt->execute(array($username,$pass,$_SESSION['admin_id']));


                    if($stmt->rowcount() > 0){ 
                        // $stmt = $db->prepare("SELECT * from tbl_admin where clm_a_id = ? ");
                        // $stmt->execute(array($_SESSION['admin_id']));

                        // $fetch = $stmt->fetch();

                        // $_SESSION['admin_user']= $fetch['clm_a_user'];
                        // $_SESSION['admin_pass']= $fetch['clm_a_pass'];
                        unset($_SESSION['msg']);
                        
                        returnToBack("success update profile","success","back");
    
                     }// row
                }// file name
            }     // not empty
        } // submit 
        } // post 
        breadcrumbs("Profile","Profile");     

?>

  
        <!-- Content -->
        <div class="container">

                            <div class="card">
                                <div class="card-body">
                                    <h4 class="box-title">UpDate</h4>
                                </div>
                                <div class="card-body text-center">


                                <?php if(isset($_SESSION['msg'])){?>
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    <span class="badge badge-pill badge-danger">Error</span>
                                                    <?php echo $_SESSION['msg'] ; ?> 
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                <?php unset($_SESSION['msg']);}?>

                                       
                                                <form method="post" action="<?php echo $_SERVER["PHP_SELF"] ?>" enctype="multipart/form-data" >

                                                  <div class="img_box w-100% m-3">
                                                  <div class="row"><div class="col-12">


                                                     <div style="margin:auto;max-height: 400px;max-width:400px" class="p-3">
                                                     <?php   if($oldImg != "empty"){?>
                                                    <img class="rounded-circle w-50" type="image" id="profile-img" src="images/avatar/<?php echo $oldImg;?>" alt="profile image" />
                                                    <?php } else {?>
                                                    <img class=" rounded-circle w-50" type="image" id="profile-img" src="images/avatar/empty.png" alt="add image" />
                                                    <?php }?></div>

                                                    </div>
                                                      <div class="col-12 m-3">
                                                     <input class="form-control-file" accept="image/*" style="background: #d0d0e0;" type="file" name="image"   id="file-img">
                                                    </div>
                                                
                                                
                                                </div></div>

                                                    <div class="form-group">
                                                        <label for="name" class="control-label mb-1">Username</label>
                                                        <input type="text" id="name" value="<?php echo $fetch['clm_a_user']; ?>" name="username" class="form-control" placeholder="username">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="pass" class="control-label mb-1">Password</label>
                                                        <input type="password" id="pass"  name="password" class="form-control" placeholder="Password">
                                                        <input type="hidden" value="<?php echo $fetch['clm_a_pass']; ?>" name="oldpassword" >
                                                    </div>
                                                        <div>
                                                            <button name="submit" type="submit" class="btn btn-lg btn-info btn-block">
                                                                Update
                                                            </button>
                                                        </div>
                                                </form>
                                        
                                </div>
                            </div> <!-- /.card -->
    
        </div>

        <?php   require_once "includes/footer.php"; 
        ob_end_flush();
    }
     ?>