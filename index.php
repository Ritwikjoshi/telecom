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
	require('db.php');//
	session_start();
	$time = time();
	$_SESSION['starttime'] = $time;//saving start time into $_SESSION['starttime']
	$_SESSION['expiretime'] = $time + (.5 * 60);//setting session expire time after 5 mins of starttime
	
	if (isset($_POST['username']))// If form submitted, insert values into the database.
	{
		$username = $_POST['username'];
		$section = $_POST['section']; 
		$password = $_POST['password'];
		$username = stripslashes($username);
		$username = mysql_real_escape_string($username);
		$password = stripslashes($password);
		$password = mysql_real_escape_string($password);
		//Checking is user existing in the database or not
		$query = "SELECT * FROM `users` WHERE username='$username' and password='".md5($password)."' and section='".$section."'";
		$result = mysql_query($query) or die(mysql_error());
		$rows = mysql_num_rows($result);
		if($rows==1)
		{
			$onlinestatus="SELECT online FROM `users` WHERE username='$username' and password='".md5($password)."'";
			if($onlinestatus==0)
			{
				$_SESSION['username'] = $username;
				$_SESSION['section'] = $section;
				$_SESSION['password'] = $password;
				$active="UPDATE `users` SET online=1 WHERE username='$username' and password='".md5($password)."'";
				$activestatus=mysql_query($active);
				header("Location: index.php"); // Redirect user to index.php
			}
			elseif ($onlinestatus==1)
			{
				echo"You have reached maximum login limit...!";
			}

		}
		else
		{
			echo "<div id='dashboard' align='center'><br/><h3>Username/password is incorrect.</h3><br/>Click here to <a href='login.php'>Login</a></div>";
		}
	}
	else
	{
	?>
	</br></br>
		<div id="loginmain" class="form" align="center">
		
			<h1 align="center" >Log In</h1>
				<table>
				<form action="" method="post" name="login" align="center">
				<tr><td><input type="text" name="username" pattern="[A-Za-z_s]*" placeholder="Username" id="user" title="Please enter a valid username" onfocus="setStyle(this.id)" onblur="setDef(this.id)" required autofocus/></tr></td>
				<tr><td><input type="text" name="section"  pattern="[A-Ga-gs]*" maxlength="1" placeholder="Section" title="Section should be between A to G" id="section" style='text-transform:uppercase' onfocus="setStyle(this.id)" onblur="setDef(this.id)"  required /></tr></td>
				<tr><td><input type="password" name="password" placeholder="Password" id="pass" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" onfocus="setStyle(this.id)" onblur="setDef(this.id)" required /></tr></td><br/>
				</table>
				<input name="submit" type="submit" value="Login" title="Click here to Login" />
				</form>
			<br>
			
			<h4 align="center ">Not registered yet? <a href='registration.php'>Register Here</a></h4>
			<br>
			<h6 align="center ">&copy Section-D(IBM) Batch:2019</h6>
		</div>
	
<?php } ?>
	<!--</div>-->
	</body>
</html>
