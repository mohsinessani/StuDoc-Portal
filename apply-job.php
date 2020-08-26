<?php
	include 'config.php';
	session_start();
	if (empty($_SESSION['login_user'])){
		header("location: index.php");
		exit();
	}

	$user = $_SESSION['login_user'];

	if (($_GET['institute'] != "select-inst") && ($_GET['degree'] != "select-deg")){
		$inst = $_GET['institute'];
		$deg = $_GET['degree'];
		$query = "INSERT INTO has_job (student_id,job_id) VALUES ('$user','$deg')";
		$table = mysqli_query($connection,$query);

	}
	header("location: job.php?user=".$_SESSION['login_user']);
	mysqli_close($connection); // Closing Connection
?>
