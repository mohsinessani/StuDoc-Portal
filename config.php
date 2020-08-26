<?php
   	#define('DB_SERVER', 'localhost');
   	#define('DB_USERNAME', 'root');
   	#define('DB_PASSWORD', '');
   	#define('DB_DATABASE', 'istudent_db');
	//session_start();
   	$connection = mysqli_connect("localhost","root","","istudent_db");
   	if(!$connection)
   	{
		die("Connection failed: " . mysqli_connect_error());
   	}
?>