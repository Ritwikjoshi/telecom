<?php
	require('db.php');
	session_start();
	$username = $_SESSION['username'];
	$section = $_SESSION['section']; 
	$password = $_SESSION['password'];
	$deactive="UPDATE `users` SET online=0 WHERE username='$username' and password='".md5($password)."'";
	$activestatus=mysql_query($deactive);
	if(session_destroy()) // Destroying All Sessions
	{
		header("Location: login.php"); // Redirecting To Home Page
	}
?>