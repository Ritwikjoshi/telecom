<html>
	<head>
		<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
		<title>Login</title>
		
			<script type="text/javascript">
				function setStyle(x)
				{
					document.getElementById(x).style.background="#ffff99";
				}
				function setDef(x)
				{
					document.getElementById(x).style.background="white";
				}
				function popup()
				{
					warning.style.display='block';
					text("Some error").fadeIn();
					setTimeout(function()
					{
					warning.style.display='none';
					},2000);
				}
			</script>
			
		<link rel="stylesheet" href="css/style.css" />
		
	</head>
	<body>
	<!--<div id="back">--> 
<?php
	require('db.php');
	session_start();
	$time = time();
	$_SESSION['starttime'] = $time;//saving start time into $_SESSION['starttime']
	$_SESSION['expiretime'] = $time + (.5 * 60);//setting session expire time after 5 mins of starttime
	
	if (isset($_POST['email']))// If form submitted, insert values into the database.
	{
		$email = $_POST['email'];
		$password = $_POST['password'];
		$email = stripslashes($email);
		$email = mysqli_real_escape_string($connection,$email);
		$password = stripslashes($password);
		$password = mysqli_real_escape_string($connection,$password);
		//Checking is user existing in the database or not
		$query = "SELECT * FROM `adminlogin` WHERE email='$email' and password='".$password."'";
		$result = mysqli_query($connection,$query) or die(mysqli_error($connection));
		$rows = mysqli_num_rows($result);
		if($rows==1)
		{
			$onlinestatus="SELECT online FROM `adminlogin` WHERE email='$email' and password='".$password."'";
			if($onlinestatus==0)
			{
				$queryforname="SELECT username FROM `adminlogin` WHERE email='$email' and password='".$password."'";
				$tempusername=mysqli_query($connection,$queryforname) or die(mysqli_error($connection));
				$username=$tempusername->fetch_assoc();
				$_SESSION['username'] = $username;
				$_SESSION['password'] = $password;
				$active="UPDATE `adminlogin` SET online=1 WHERE username='$username' and password='".$password."'";
				$activestatus=mysqli_query($connection,$active);
				header("Location: rightscheck.php"); // Redirect user to index.php
			}
			elseif ($onlinestatus==1)
			{
				echo"Sorry!<br>You have reached maximum login limit...!";
			}

		}
		else
		{
			echo "<div id='dashboard' align='center'><br/><h3>Email/password is incorrect.</h3><br/>Click here to <a href='login.php'>Login</a></div>";
		}
	}
	else
	{
	?>
	</br></br>
		<div id="loginmain" class="form" align="center">
		
			<h3 align="center" >Admin Login</h3>
				<table>
				<form action="" method="post" name="login" align="center">
				<tr><td><input type="email" name="email" placeholder="Email" id="mail" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" onfocus="setStyle(this.id)" onblur="setDef(this.id)" required autofocus/></tr></td>
				
				<tr><td><input type="password" name="password" placeholder="Password" id="pass" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" onfocus="setStyle(this.id)" onblur="setDef(this.id)" required /></tr></td><br/>
				</table>
				<input name="submit" type="submit" value="Login" title="Click here to Login" />
				</form>
			<br>
			<br>
			<h6 align="center ">Not an admin? <a href='index.php'>Go Here</a></h6>
			<br>
			<h6 align="center ">&copy Telecom:2017</h6>
		</div>
	
<?php } ?>
	<!--</div>-->
	</body>
</html>