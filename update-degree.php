<?php
	include 'config.php';
	session_start();
	if (empty($_SESSION['login_user'])){
		header("location: index.php");
		exit();
	}

	$user = $_SESSION['login_user'];

	if (($_GET['institute'] != "") && ($_GET['name-of-degree'] != ""))
	{
		$inst = $_GET['institute'];
		$deg = $_GET['name-of-degree'];
		$query = "INSERT INTO degree (degree_name,institute_id) VALUES ('$deg','$inst')";
		$table = mysqli_query($connection,$query);

	}
	header("location: institute.php?user=".$_SESSION['login_user']);
	mysqli_close($connection); // Closing Connection
?>
