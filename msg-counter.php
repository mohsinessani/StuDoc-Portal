<?php
	include 'config.php';
	include 'login.php';
	error_reporting(0);
	$query="SELECT * FROM chat WHERE sent_to =".$_SESSION['login_user'];
	$table = mysqli_query($connection,$query);
	if($table){
		echo $rows=mysqli_num_rows($table);
	}
?>