<?php
	session_start();
	if (empty($_SESSION['login_user'])){
		header("location: index.php");
		exit();
	}

	error_reporting(0);
  	include 'config.php';

  	if(isset($_FILES['fileToUpload']['name']))
		{
			$uploadOk=1;
			$fileName=$_FILES['fileToUpload']['name'];
			$fileName=str_replace(' ', '', $fileName);
			$errorMessage="";

			if($fileName != "") 
			{
				$targetDir = "profile/";
				$fileName = $targetDir . uniqid().basename($fileName);
				$fileType = pathinfo($fileName, PATHINFO_EXTENSION);

				if($_FILES['fileToUpload']['size'] > 10000000)
				{
					$errorMessage = "Sorry, your file is too large";
					$uploadOk = 0;
				}

				if(strtolower($fileType) != "jpg" && strtolower($fileType) != "jpeg" && strtolower($fileType) != "png")
				{
					$errorMessage = "Sorry, only JPG , PNG, and JPEG file format supported";
					$uploadOk = 0;
				}

				if($uploadOk) 
				{
					if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $fileName)) 
					{
						//file uploaded okay
						$uploadOk=1;
					}
					else 
					{
						//file did not upload
						$uploadOk = 0;
					}
				}

			if($uploadOk) 
			{
					$query2 = "update user set img_url='".$fileName."' where id=".$_SESSION['login_user'];
					$exe=mysqli_query($connection,$query2);
					$_SESSION['dp_url']=$fileName;
			}

			}


  			//$query = "update user set img_url='".$fileName."' where id=".$_SESSION['login_user'];
  		}

  	if ($_SERVER["REQUEST_METHOD"] == "GET"){ 
  		if (!empty($_GET['full_name']) && $_GET['full_name'] != $_SESSION['name'] ){
  			$full_name = $_GET['full_name'];
  			$full_name = filter_var($full_name, FILTER_SANITIZE_STRING);
  			$query = "update user set name='".$full_name."' where id=".$_SESSION['login_user'];
  		}

  		else if (!empty($_GET['user_name']) && $_GET['user_name'] != $_SESSION['user_name']){
  			$user_name = $_GET['user_name'];
  			$user_name = filter_var($user_name, FILTER_SANITIZE_STRING);
  			$query = "update user set user_name='".$user_name."' where id=".$_SESSION['login_user'];
  		}

  		else if (!empty($_GET['contact']) && $_GET['contact'] != $_SESSION['contact']){
  			$contact = $_GET['contact'];
  			$query = "update user set contact_no='".$contact."' where id=".$_SESSION['login_user'];
  		}

  		else if (!empty($_GET['email']) && $_GET['email'] != $_SESSION['email_id']){
  			$email = $_GET['email'];
  			if(filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE) {
    			throw new Exception("Invalid Email");
  			}
  			$query = "update user set email_id='".$email."' where id=".$_SESSION['login_user'];
  		}
		
		else if (!empty($_GET['password'])){
 			$password = $_GET['password'];
  			$query = "update user set password='".$password."' where id=".$_SESSION['login_user'];
  		}
			  		
  		if (mysqli_query($connection, $query)) { 
       		$_SESSION['name'] = $_GET['full_name'];
    		$_SESSION['user_name'] = $_GET['user_name'];
    		$_SESSION['email_id'] = $_GET['email'];
    		$_SESSION['contact'] = $_GET['contact'];
		} 
  	}
?>	

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Settings</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,700' rel='stylesheet' type='text/css'>
	<link href="https://fonts.googleapis.com/css?family=Fjalla+One|Maitree|Ropa+Sans" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">


	<link rel="stylesheet" href="css/reset.css"> <!-- CSS reset -->
	<link rel="stylesheet" href="css/style.css"> <!-- Resource style -->
	<link rel="stylesheet" href="css/media.css">
	<script src="js/modernizr.js"></script> <!-- Modernizr -->
</head>
<body>
	<header class="cd-main-header">
		<a href="institute.php?user=<?php echo $_SESSION['login_user'];?>" class="cd-logo"><img src="images/logo.png" alt="Logo"></a>

		<a href="#" class="cd-nav-trigger">Menu<span></span></a>

		<nav class="cd-nav">
			<ul class="cd-top-nav">
				<!--<li><a href="#">Privacy Policy</a></li>-->
				<li class="has-children account">
					<a href="#">
						<img src="<?php echo $_SESSION['dp_url'];?>">
						Account
					</a>
					<ul>
						<li><a href="institutesettings.php">Edit Account</a></li>
						<li><a href="logout.php">Logout</a></li>
					</ul>
				</li>
			</ul>
		</nav>
	</header> <!-- .cd-main-header -->

	<main class="cd-main-content">
		<nav class="cd-side-nav">
			<ul>
				<li class="nav-dp"><a class="dp"><img src="<?php echo $_SESSION['dp_url'];?>"></a></li>
				<li class="nav-name"><h1>@<?php echo $_COOKIE['user_name'];?></h1></li>
				<li class="cd-label">Main</li>
				<li class="profile">
					<a href="institute.php?user=<?php echo $_SESSION['login_user'];?>">Profile</a>
				</li>

			</ul>

			<ul>
				<li class="cd-label">Secondary</li>

				<li class="settings active">
					<a href="institutesettings.php">Settings</a>
				</li>
			</ul>
				<br><br>
				<center>
				<iframe width="120px" height="60px" scrolling="no" src="clock.html"></iframe>
				</center>
			</ul>
		</nav>

		<div class="content-wrapper">

  			<div class="setting-container">
  				<h1 class="heading">Institute Account Settings</h1>
  				<center>
  					<table class="setting_table">
  						<tr class="row-6">
  						<td class="col-1">Profile Picture</td>
  						<td class="col-2">
  							<form method="post" enctype="multipart/form-data">
  								<input type="file" name="fileToUpload" id="fileToUpload">
  								<input type="submit" name="upload" value="Upload Now">
  							</form>
  						</td>
  					</tr>
  					</table>
  				<form method="get" autocomplete="off">
  				<table class="setting_table">
  					<tr class="row-1" onclick="edit_setting(1)">
  						<td class="col-1">Full Name</td>
  						<td class="col-2"><input type="text" minlength="3" maxlength="30" id="full_name" name="full_name" hidden="" value="<?php echo $_SESSION['name'];?>"><p><?php echo $_SESSION['name'];?></p></td>
  						<td class="col-3"><a>Edit</a></td>
  					</tr>

  					<tr class="row-2" onclick="edit_setting(2)">
   						<td class="col-1">User Name</td>
  						<td class="col-2"><input type="text" minlength="4" maxlength="20" id="user_name" name="user_name" hidden="" value="<?php echo $_SESSION['user_name'];?>"><p><?php echo $_SESSION['user_name'];?></p></td>
  						<td class="col-3"><a>Edit</a></td>
  					</tr>
  					<tr class="row-3" onclick="edit_setting(3)">
  						<td class="col-1">Contact No</td>
  						<td class="col-2"><input type="text" id="contact" name="contact" hidden="" value="<?php echo $_SESSION['contact'];?>"><p><?php echo $_SESSION['contact'];?></p></td>
  						<td class="col-3"><a>Edit</a></td>
  					</tr>
  					<tr class="row-4" onclick="edit_setting(4)">
  						<td class="col-1">Email Address</td>
  						<td class="col-2"><input type="email" id="email" name="email" hidden="" value="<?php echo $_SESSION['email_id'];?>"><p><?php echo $_SESSION['email_id'];?></p></td>
  						<td class="col-3"><a>Edit</a></td>
  					</tr>
  					<tr class="row-5" onclick="edit_setting(5)">
  						<td class="col-1">Password</td>
  						<td class="col-2"><input type="password" minlength="4" maxlength="32" id="password" name="password" hidden="" value="" autocomplete="off" autosave="off"><p>**********</p></td>
  						<td class="col-3"><a>Edit</a></td>
  					</tr>  					
  				</table>
  				<button class="action-btn save" type="submit" value="submit" hidden="">Save Changes</button>
  				<button class="action-btn cancel" type="reset" hidden="">Cancel</button>
  				</form>
  				</center>
  			</div>
  			<script type="text/javascript">
  				function edit_setting($n){
  					$("table tr td input").hide();
					$("table tr:nth-child("+$n+") td input").show().focus();
					$("table tr td p").show();
					$("table tr td a").show();
					$("table tr:nth-child("+$n+") td p").hide();
					$("table tr:nth-child("+$n+") td a").hide();
					$("button").show();
				}
  			</script>
		</div> <!-- .content-wrapper -->
	</main> <!-- .cd-main-content -->
	<script src="js/jquery.js"></script>
	<script src="js/jquery.menu-aim.js"></script>
	<script src="js/profile.js"></script> <!-- Resource jQuery -->
</body>
</html>