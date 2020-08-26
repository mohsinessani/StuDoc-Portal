<?php
	session_start();
	$user=$_GET['user'];

	error_reporting(0);
  	include 'config.php';

  	$query=mysqli_query($connection,"SELECT * FROM user WHERE id='$user'");
  	$row=mysqli_fetch_array($query);

  	$_SESSION['name'] = $row['name'];
    $_SESSION['user_name'] = $row['user_name'];
    $_SESSION['email_id'] = $row['email_id'];
    $_SESSION['contact'] = $row['contact_no'];
    $_SESSION['dp_url'] = $row['img_url'];

  	if ($_SERVER["REQUEST_METHOD"] == "POST"){ 
  		if (!empty($_POST['full_name']) && $_POST['full_name'] != $_SESSION['name']){
  			$full_name = $_POST['full_name'];
  			$full_name = filter_var($full_name, FILTER_SANITIZE_STRING);
  			$query = "update user set name='".$full_name."' where id=".$user;
  		}

  		if (!empty($_POST['user_name']) && $_POST['user_name'] != $_SESSION['user_name']){
  			$user_name = $_POST['user_name'];
  			$user_name = filter_var($user_name, FILTER_SANITIZE_STRING);
  			$query = "update user set user_name='".$user_name."' where id=".$user;
  		}

  		if (!empty($_POST['contact']) && $_POST['contact'] != $_SESSION['contact']){
  			$contact = $_POST['contact'];
  			$query = "update user set contact_no='".$contact."' where id=".$user;
  		}

  		if (!empty($_POST['email']) && $_POST['email'] != $_SESSION['email_id']){
  			$email = $_POST['email'];
  			if(filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE) {
    			throw new Exception("Invalid Email");
  			}
  			$query = "update user set email_id='".$email."' where id=".$user;
  		}
		
		  if (!empty($_POST['password'])){
 			$password = $_POST['password'];
  			$query = "update user set password='".$password."' where id=".$user;
  		}

		  if (!empty($_POST['dp_url']) && $_POST['dp_url'] != $_SESSION['dp_url']){
			$dp_url = $_POST['dp_url'];
			$imgExts = array("gif", "jpg", "jpeg", "png", "tiff", "tif");
			$urlExt = pathinfo($dp_url, PATHINFO_EXTENSION);
			 if (in_array($urlExt, $imgExts)) {
    			$query = "update user set img_url='".$dp_url."' where id=".$user;	
			 }
			 else{
				echo "<script>alert('URL is not of an image.')</script>";
			 }
			
		}  		
  	if (mysqli_query($connection, $query)) { 
    		header('Location: '.$_SERVER['REQUEST_URI']);
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
    <a href="admin.php" class="cd-logo"><img src="images/logo.png" alt="Logo"></a>
    
    <a href="#" class="cd-nav-trigger">Menu<span></span></a>

    <nav class="cd-nav">
      <ul class="cd-top-nav">
        <!--<li><a href="#">Privacy Policy</a></li>-->
        <li class="has-children account">
          <a href="#">
            <img src="images/avatar-01.jpg">
            Account
          </a>
          <ul>
            <li><a href="logout.php">Logout</a></li>
          </ul>
        </li>
      </ul>
    </nav>
  </header> <!-- .cd-main-header -->

	<main class="cd-main-content">
    <nav class="cd-side-nav">

      <ul>
        <li class="nav-dp"><a class="dp"><img src="images/avatar-01.jpg"></a></li>
        <li class="nav-name"><h1>Administrator</h1></li>
        <li class="cd-label">Main</li>
        <li class="profile active">
          <a href="admin.php">Students</a>
        </li>

        <li class="messages">
          <a href="admininstitute.php">Institutes</span></a>
        </li>

        <li class="has-children documents">
          <a href="admincompany.php">Companies</a>
        </li>
      </ul>

      <ul>
        <li class="cd-label">Secondary</li>
        
        <li class="jobs">
          <a href="notices.php">Notices</a>
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
  				<h1 class="heading"><?php echo $row['name'];?>'s Settings</h1>
  				<center>
  				<form method="post" autocomplete="off">
  				<table class="setting_table">
  					<tr class="row-1" onclick="edit_setting(1)">
  						<td class="col-1">Full Name</td>
  						<td class="col-2"><input type="text" minlength="3" maxlength="30" id="full_name" name="full_name" hidden="" value="<?php echo $row['name'];?>"><p><?php echo $row['name'];?></p></td>
  						<td class="col-3"><a>Edit</a></td>
  					</tr>

  					<tr class="row-2" onclick="edit_setting(2)">
   						<td class="col-1">User Name</td>
  						<td class="col-2"><input type="text" minlength="4" maxlength="20" id="user_name" name="user_name" hidden="" value="<?php echo $row['user_name'];?>"><p><?php echo $row['user_name'];?></p></td>
  						<td class="col-3"><a>Edit</a></td>
  					</tr>
  					<tr class="row-3" onclick="edit_setting(3)">
  						<td class="col-1">Contact No</td>
  						<td class="col-2"><input type="text" id="contact" name="contact" hidden="" value="<?php echo $row['contact_no'];?>"><p><?php echo $row['contact_no'];?></p></td>
  						<td class="col-3"><a>Edit</a></td>
  					</tr>
  					<tr class="row-4" onclick="edit_setting(4)">
  						<td class="col-1">Email Address</td>
  						<td class="col-2"><input type="email" id="email" name="email" hidden="" value="<?php echo $row['email_id'];?>"><p><?php echo $row['email_id'];?></p></td>
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