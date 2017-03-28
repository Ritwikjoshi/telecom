<?php include("auth/auth.php");
	require('db.php');
 //include auth.php file on all secure pages ?>
<?php
 /*
 	$currenttime = time(); // Checking the time now when home page starts.

        if ($currenttime > $_SESSION['expiretime'])
       	{
           	session_destroy();
           	echo "<script type='text/javascript'>
           		alert('Your session has expired....nPlease login again');
           		</script>";
           		*/
?>
	<html>
		<head>
           	<script type="text/javascript">
           		//alert("Your session has expired....\nPlease login again");
           		function destr(x)
           		{
           			window.location = "logout.php";
           		}
           	</script>
        </head>
    </html>
<?php
		//header("Location: index.php");
       	//}
	$username=$_SESSION['username'];
	$password=$_SESSION['password'];
	$username=implode(" ", $username);
	$username = stripslashes($username);
	$username = mysqli_real_escape_string($connection, $username);
	$password = stripslashes($password);
	$password = mysqli_real_escape_string($connection, $password);

	$queryforrights = "SELECT rights FROM `adminlogin` WHERE username='$username' and password='".$password."'";
	$temprights = mysqli_query($connection, $queryforrights) or die(mysqli_error($connection));
	$rights=$temprights->fetch_assoc();
	$rights=implode(" ", $rights);


	if ($rights=="admin") {
		header("Location: admin/masteradmin.php");
	}
	elseif ($rights=="regional") {
		header("Location: admin/regionaladmin.php");
	}
	elseif ($rights=="zonal") {
		header("Location: admin/zonaladmin.php");
	}
	elseif($rights=="admin_head")
	{
		header("Location: admin/adminhead.php");	
	}
	else
	{
		echo"<h1>No rights found</h1>";
	}

?>
