<?php 
session_start();

require_once('inc/config.php');

if(isset($_POST['login']))
{
	if(!empty($_POST['email']) && !empty($_POST['password']))
	{
		$email 		= trim($_POST['email']);
		$password 	= trim($_POST['password']);
		
		$md5Password = md5($password);
	
		
		$sql = "select * from tbl_users where email = '".$email."' and password = '".$md5Password."'";
		$rs = mysqli_query($conn,$sql);
		$getNumRows = mysqli_num_rows($rs);
		//$row = mysqli_fetch_assoc($rs);
		
		if($getNumRows == 1)
		{
			$getUserRow = mysqli_fetch_assoc($rs);
			unset($getUserRow['password']);
			
			$_SESSION = $getUserRow;
						
			header('location:main/dashboard');
			exit;
		}
		else
		{
			$errorMsg = "Wrong email or password";
		}
	}
}

if(isset($_GET['logout']) && $_GET['logout'] == true)
{
	session_destroy();
	header("location:index");
	exit;
}


if(isset($_GET['lmsg']) && $_GET['lmsg'] == true)
{
	$errorMsg = "Login required to access dashboard";
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Vehicle management system | m-vehicle</title>
  <!-- Bootstrap core CSS-->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template-->
  <link href="assets/css/sb-admin.css" rel="stylesheet">
</head>

<body style="background-color: lightgray;">
  <div class="container">

    <div class="card card-login mx-auto mt-5" style="border: 1px solid lightblue;">
      <div class="card-header bg-info" style="color: white;">Login Panel</div>
      <div class="card-body">
		<?php 
			if(isset($errorMsg))
			{
				echo '<div class="alert alert-danger">';
				echo $errorMsg;
				echo '</div>';
				unset($errorMsg);
			}
		?>
        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
          <div class="form-group">
            <label for="exampleInputEmail1"><small><b>Email address</b></small></label>
            <input class="form-control" id="exampleInputEmail1" name="email" type="email" placeholder="Enter your email." required>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1"><small><b>Password</b></small></label>
            <input class="form-control" id="exampleInputPassword1" name="password" type="password" placeholder="Enter your Password." required>
          </div>
          <br>
          <button class="btn btn-info btn-block" type="submit" name="login" style="border-radius: 10px;">Login</button>
        </form>
       
      </div>
    </div>
    <?php require_once('layouts/footer.php'); ?> 
  </div>
  <!-- Bootstrap core JavaScript-->
  <script src="assets/vendor/jquery/jquery.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>
</body>

</html>