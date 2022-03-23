<?php require_once "includes/connect.php"; 
ob_start();
 session_start();

 if(isset($_SESSION['admin_id'])){

    header( "Location:home.php");
			exit;
}else{


if($_SERVER["REQUEST_METHOD"] == "POST"){

	$username = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
	$password = filter_var($_POST["password"] , FILTER_SANITIZE_STRING);
    $_SESSION['msg'] = "";
	  
	if($username=="")
	{
		$_SESSION['msg'] = "Please enter user name...";
		 
	}
	else if($password=="")
	{
        $_SESSION['msg'] = "Please enter password...";
	}	 
	else
	{
        $stmt = $db->prepare("SELECT * from tbl_admin where clm_a_user = ? and clm_a_pass= ? ");
        $stmt->execute(array($username,md5($password)));
		
		
		if($stmt->rowcount() > 0)
		{ 
			$fetch = $stmt->fetch();

			$_SESSION['admin_id'] = $fetch['clm_a_id'];
		    $_SESSION['admin_user']= $fetch['clm_a_user'];
		    // $_SESSION['admin_pass']= $fetch['clm_a_pass'];
		    $_SESSION['admin_img']= $fetch['clm_a_img'];
			  
			header( "Location:home.php");
			exit;
				
		}
		else
		{
			$_SESSION['msg'] = "Please enter correct user name and passwrod.."; 
			header("Location:index.php");
			exit;
			 
		}
	}
	
	
	
}

?> 

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Page Title - SB Admin</title>
        <link href="./assets/css/styles.css" rel="stylesheet" />
        <script src="./assets/css/all.min.css" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                                    <div class="card-body">

                                    <?php if(isset($_SESSION['msg'])){?>
                                    <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                        <span class="badge badge-pill badge-danger">Error</span>
                                                        <?php echo $_SESSION['msg'] ; ?> 
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                     <?php unset($_SESSION['msg']);}?>

                                    <form method="post" action="<?php echo $_SERVER["PHP_SELF"] ?>">
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputEmailAddress">Email</label>
                                                <input name="username" class="form-control py-4" id="inputEmailAddress" type="text" placeholder="Enter email address" />
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputPassword">Password</label>
                                                <input name="password" class="form-control py-4" id="inputPassword" type="password" placeholder="Enter password" />
                                            </div>
                                          
                                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a class="small" href="password.php">Forgot Password?</a>
                                                <input class="btn btn-primary" type="submit" value="Login">
                                            </div>
                                        </form>
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2020</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="./assets/js/scripts.js"></script>
    </body>
</html>

<?php
}ob_end_flush();
?>