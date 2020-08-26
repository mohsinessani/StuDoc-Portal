<?php
	include 'config.php';
	session_start();
	if (empty($_SESSION['login_user'])){
		header("location: index.php");
		exit();
	}

	$user = $_SESSION['login_user'];

	if (($_GET['institute'] != "") && ($_GET['jobtitle'] != "") && ($_GET['location'] != "") && ($_GET['description'] != "") && ($_GET['salary'] != "") && ($_GET['jobtype'] != "job-type"))
	{
		//$lastid+=1;
		$inst = $_GET['institute'];
		$jobtitle=$_GET['jobtitle'];
		$location=$_GET['location'];
		$description=$_GET['description'];
		$salary=$_GET['salary'];
		$jobtype=$_GET['jobtype'];	
		$query = "INSERT INTO `job` (`job_title`, `location`, `description`, `salary`, `job_type`, `company_id`) VALUES ('$jobtitle','$location','$description','$salary','$jobtype','$inst')";
		//$lastid = mysqli_insert_id($connection); 
		$table = mysqli_query($connection,$query);
	}
	header("location: company.php?user=".$_SESSION['login_user']);
	mysqli_close($connection); // Closing Connection
?>
