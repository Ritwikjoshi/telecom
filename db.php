<?php

    $db = mysqli_init();
    $db->ssl_set( "telecom/certificates/5e4da5640f0d5a-key.pem", "telecom/certificates/5e4da5640f0d5a-cert.pem ", " telecom/certificates/cleardb-ca.pem ", null, null);
    $connection->real_connect("127.0.0.1:22", "ritwik", "", "telecom");

	if (!$connection)
	{
		die("Database Connection Failed" . mysqli_error($connection));
	}
	$select_db = mysqli_select_db('register');
	if (!$select_db)
	{
		die("Database Selection Failed" . mysqli_error($connection));
	}
?>
