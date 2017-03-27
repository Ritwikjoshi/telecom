<html>
	<head>
		<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
		<title>Register Here</title>
		<link rel="stylesheet" href="css/style.css" />
			<script type="text/javascript">
				function setStyle(x)
				{
					document.getElementById(x).style.background="#ffcc66";
				}
				function setDef(x)
				{
					document.getElementById(x).style.background="white";
				}

				function hideinfo()
				{
					document.getElementById("info").style.display="none";
				}

				function strength()
				{

					var tooweak = "Too Weak";
					var weak = "Weak";
					var medium = "Intermediate";
					var strong = "Strong";
					var toostrong = "Too Strong";
					var password;
					var pass;
					var strength = 0;
					var regex = /\d+/g;

					password = document.getElementById("pass").value;
					var length = password.length;
					var numbers = password.match(regex);
					var info = document.getElementById("info").value;
					if (info.length > 0 )
					{
						document.getElementById("info").style.display="";
					}
					
					//alert(info.length);

					if (length>7)
					{
						if(strength < 10)
						strength = strength + 2;
					}
					if (password.match(/[a-z]/))
					{
						if(strength < 10)					// a A 2 @ a a 2
						strength = strength + 2;
					}
					if (password.match(/[A-Z]/))
					{
						if(strength < 10)
						strength = strength + 2;
					}
					if (numbers>0)
					{
						if(strength < 10)
						{	
						strength = strength + 2;
						}
					}
					if (password.match(/[_\W]/))
					{
						if(strength < 10)
						strength = strength + 2;
					}

					if (strength == 0)
					{
						document.getElementById("info").style.display="none";
					}
					if (strength == 2)
					{
						document.getElementById("pass").style.backgroundColor="#ff3300";
						document.getElementById("info").value = tooweak;
					}
					else if (strength == 4)
					{
						document.getElementById("pass").style.backgroundColor="#ffcc66";
						document.getElementById("info").value = weak;
					}
					else if (strength == 6)
					{

						document.getElementById("pass").style.backgroundColor="#ccff66";
						document.getElementById("info").value = medium;
					}
					else if (strength == 8)
					{
						document.getElementById("pass").style.backgroundColor="#ccff99";
						document.getElementById("info").value = strong;
					}
					else if (strength == 10)
					{
						document.getElementById("pass").style.backgroundColor="#66ff66";
						document.getElementById("info").value = toostrong;
					}
					
					
				}

				function match()
				{
					password = document.getElementById("pass").value;
					confirm = document.getElementById("confirm").value;
					if(password != confirm)
					{
						alert("Password matched");
					}
				}
				
			</script>
<script type="text/javascript" src="strength.js"></script>

	</head>
	<body onload="hideinfo()">

<?php
	require('db.php');
	// If form submitted, insert values into the database.
	if (isset($_POST['username']))
	{
		$username = $_POST['username'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$section = $_POST['section'];
		$confirm = $_POST['confirm'];
		
		if($password!=$confirm)
		{
?>

<html>
	<script>
		alert('Password Mismatch\nConfirm password correctly');	
		window.setTimeout(function(){ document.location = "registration.php"; },0);	
	</script>
</html>

<?php
		}
	
	$check="SELECT * FROM `users` WHERE username ='".$username."'";
	$duplicate=mysql_query($check);
	$no=mysql_num_rows($duplicate);
	
	$check1="SELECT * FROM `users` WHERE email ='".$email."'";
	$duplicate1=mysql_query($check1);
	$no1=mysql_num_rows($duplicate1);
	
	
	$username = stripslashes($username);
	$username = mysql_real_escape_string($username);
	$email = stripslashes($email);
	$email = mysql_real_escape_string($email);
	$password = stripslashes($password);
	$password = mysql_real_escape_string($password);
	$trn_date = date("Y-m-d H:i:s");
	$query = "INSERT into `users` (username, password, email,section, trn_date) VALUES ('$username', '".md5($password)."', '$email','$section', '$trn_date')";
	
	
		if(($no>0))
		{
			echo "<div class='form' id='form'><br/><h3>Username already registered.</h3><br>Click here to <a href='registration.php'>register with another Username</a></div>";
		}
		elseif($no1>0)
		{
			echo "<div class='form' id='form'><br/><h3>E-mail already registered.</h3><br>Click here to <a href='registration.php'>register with another Username</a></div>";
		}
		else
		{
		$result = mysql_query($query);
			if($result)
			{
				mkdir('C:/xampp/htdocs/My Project/uploads/'.$section.'/'.$username, 0777);
				echo "<br>";
				echo "<div class='form' id='form'><br/><h3>You are registered successfully.</h3>Click here to <a href='login.php'>Login</a></div>";
			}
		}
	
	
	}
	else
	{
?>
	<div class="form" id="login">
		<h2 align="center">Registration Form</h2><br>
		<span>* Set your username in format of firstname_lastname</span>
			<form name="registration" action="" method="post" align="center">
				<input type="text" pattern="[A-Za-zs]+_+[A-Za-zs]*" name="username" placeholder="Username" id="user" title="Enter Username in the format of Firstname_Lastname" onfocus="setStyle(this.id)" onblur="setDef(this.id)" required autofocus/>

				<input type="email" name="email" placeholder="Email" id="mail" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" onfocus="setStyle(this.id)" onblur="setDef(this.id)" required/>

				<input type="password" name="password" placeholder="Password" id="pass" title="Strong password should contain at least one number and one uppercase and lowercase letter and a special character, and at least 8 or more characters"  onblur="setDef(this.id);hideinfo()" onkeyup="strength()" required />
				</br>

				<input type="checkbox" onchange="document.getElementById('pass').type = this.checked ? 'text' : 'password'" id="showpass" class="showpass"><span font-size="25%"> Show password</span>
				</br>

				<input type="text" id="info" placeholder="" display="none" disabled/><!--pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"-->

				<input type="password" name="confirm" placeholder="Confirm Password" id="confirm" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" onfocus="setStyle(this.id)" onblur="setDef(this.id);match()" required /><!--pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"-->

				<input type="text" name="section"  pattern="[A-Ga-gs]*" maxlength="1" placeholder="Section" id="section" title="Section should be between A to G" style='text-transform: uppercase;' onfocus="setStyle(this.id)" onblur="this.value=this.value.toUpperCase(),setDef(this.id)"  required />

				<input type="submit" name="submit" value="Register" title="Click here to register" />
			</form>
		<br>
		<div class="register" id="register"><h4>Problems in registering?</h4>Click here to <a href='instructions.php'>read instructions</a><br>Click here to <a href='login.php'>Go to login page</a></div> 
	</div>
	
<?php 
	}
?>

	</body>
</html>