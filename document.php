<?php
	error_reporting(0);
	include 'config.php';
	session_start();
	if (empty($_SESSION['login_user'])){
		header("location: index.php");
		exit();
	}
	
	if (is_numeric($_GET['user'])){
		$query = "select id,name,email_id,contact_no,img_url,user_type from user where id=".$_GET['user'];
	}
	else{
		$query = "select id,name,email_id,contact_no,img_url,user_type from user where name='".$_GET['user']."'";
	}

	$table = mysqli_query($connection,$query);
		if($table){
			$rows=mysqli_num_rows($table);
			if($rows == 1){
		    	$row = mysqli_fetch_assoc($table);
		    	$id=$row['id'];
		    	$dp = $row['img_url'];
		    	$fullname = $row['name'];
		    	$email = $row['email_id'];
		    	$contact = $row['contact_no'];
		    }
		}	
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Profile</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,700' rel='stylesheet' type='text/css'>
	<link href="https://fonts.googleapis.com/css?family=Fjalla+One|Maitree|Ropa+Sans" rel="stylesheet">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

	<link rel="stylesheet" href="css/reset.css"> <!-- CSS reset -->
	<link rel="stylesheet" href="css/style.css"> <!-- Resource style -->
	<link rel="stylesheet" href="css/media.css">
	<link rel="stylesheet" href="css/profile.css">
	<script src="js/modernizr.js"></script> <!-- Modernizr -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

</head>
<body onload="check()">
	<script type="text/javascript">
		function check(){
			$("span#msgcount").load("msg-counter.php");
		}

		function suggestions(){
			var input = $(".search").val();
			var url = "users.php?keyword="+input;
			$("datalist#searches").load(url);
		}

		function searched(){
			var name = $(".search").val();
			window.open("profile.php?user="+name,'_self');
		}
	</script>
	<header class="cd-main-header">
		<a href="document.php?user=<?php echo $_SESSION['login_user'];?>" class="cd-logo"><img src="images/logo.png" alt="Logo"></a>
		
		<div class="cd-search is-hidden">
				<input list="searches" class="search" placeholder="Search..." onkeyup="suggestions()" onchange="searched()">
				<datalist id="searches">
				</datalist>
		</div> <!-- cd-search -->

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
						<li><a href="settings.php">Edit Account</a></li>
						<li><a href="logout.php">Logout</a></li>
					</ul>
				</li>
			</ul>
		</nav>
	</header> <!-- .cd-main-header -->

	<main class="cd-main-content">
		<nav class="cd-side-nav">
			<ul>
				<li class="nav-dp"><a class="dp"><img src="<?php echo $_COOKIE['dp_url'];?>"></a></li>
				<li class="nav-name"><h1>@<?php echo $_COOKIE['user_name'];?></h1></li>
				<li class="cd-label">Main</li>
				<li class="profile">
					<a href="profile.php?user=<?php echo $_SESSION['login_user'];?>">Profile</a>
				</li>

				<li class="messages">
					<a href="inbox.php">Messages<span class="count" id="msgcount"></span></a>
				</li>

				<li class="documents active">
					<a href="document.php?user=<?php echo $_SESSION['login_user'];?>">Documents</a>
				</li>

			</ul>

			<ul>
				<li class="cd-label">Secondary</li>
				
				<li class="jobs">
					<a href="job.php?user=<?php echo $_SESSION['login_user'];?>">Jobs</a>
				</li>

				<li class="settings">
					<a href="settings.php">Settings</a>
				</li>
			</ul>
				<br><br>
				<center>
				<iframe width="120px" height="60px" scrolling="no" src="clock.html"></iframe>
				</center>
			</ul>
		</nav>

		<div class="content-wrapper">
			<br><br>
	            <div class="pro-education student">
    	        	<h1 class="heading">Uploaded Documents<button id="add-edu" class="add-button remove">+ Add New Document</button></h1>
    	        	<div class="pro-education-body pro-body">
    	        	<center>
	            	    <form id="form-edu" hidden="" target="_self" class="remove" action="upload-document.php" enctype="multipart/form-data" method="post">
	            	   		<input type="file" name="fileToUpload" id="fileToUpload">
	            	   		<br/>
	            	   		<input type="text" name="filename" placeholder="Enter Name of File">
	            	   		<br/><br/>
		                	&nbsp;<button id="item-submit-edu" class="edit-button">Upload</button>
		                	<button type="reset" id="cancel-edu" class="edit-button cancel">Cancel</button><br/><br/>
	    	            </form>
	    	            </center>
	               		<ul class="education-list">
	               		<?php
							$query = "SELECT * FROM `has_document` join `user` on (student_id = id) where student_id = ".$_GET['user'];
							$table = mysqli_query($connection,$query);
							if($table){
								$rows=mysqli_num_rows($table);
								if($rows > 0){
									for($x = 0; $x<= $row; $x++){
				    					$row = mysqli_fetch_assoc($table);
				    					if ($row){
						?>
											<li>
						<?php
												$inst_query = "select name from user where id = ".$row['student_id'];
												$inst_table = mysqli_query($connection, $inst_query);
												if ($inst_table){
													$inst_column = mysqli_fetch_assoc($inst_table);
													echo "<p style='padding-bottom: 10px; font-size:18px; font-weight:bold'>".$inst_column['name']."</p>";
												}

												$deg_query = "select doc_name,size,file,verification_status from has_document where doc_id = ".$row['doc_id'];
												$deg_table = mysqli_query($connection, $deg_query);
												if ($deg_table){
													$deg_column = mysqli_fetch_assoc($deg_table);
													echo "<p style='padding-bottom: 10px;'><span style='font-weight:bold;'>Document Name : </span>".$deg_column['doc_name']."</p>";
													echo "<p style='padding-bottom: 10px;'><span style='font-weight:bold;'>Size : </span>".(($deg_column['size'])/1000000)." Mb</p>";
													$vs=($deg_column['verification_status'] =="pending")?"<p style='padding-bottom: 10px;'><span style='font-weight:bold;'>Status : </span> <span style='color: red; font-weight: bold;'>".ucfirst($deg_column['verification_status'])."</span></p>":"<p style='padding-bottom: 10px;'><span style='font-weight:bold;'>Status : </span> <span style='color: green;font-weight: bold;'>".ucfirst($deg_column['verification_status'])."</span></p>";
													echo $vs;
													//echo "<p style='padding-bottom: 10px;'><span style='font-weight:bold;'>Status : </span>".ucfirst($deg_column['verification_status'])."</p>";
													echo "<a href='".$deg_column['file']."'><button style='padding: 10px;'> Download Now! </button> </a>";
												}
						?>
											</li>

						<?php
										}
				    				}
								}
							}
						?>
		                </ul>
	            	</div>    
	            </div>
            </div> <!-- profile-container -->
		</div> <!-- .content-wrapper -->
	</main> <!-- .cd-main-content -->
<script src="js/jquery.js"></script>
<script src="js/jquery.menu-aim.js"></script>
<script src="js/profile.js"></script> <!-- Resource jQuery -->
<script>
$(document).ready(function(){
	$("button#add-contact").hide();
	<?php
		if ($_GET['user'] != $_SESSION['login_user']){
			$_SESSION['added'] = 0;
	?>
			$(".remove").hide();
			$("button#add-contact").show();
	<?php
			$query = "select * from contact where user_id =".$_SESSION['login_user'];
			$table = mysqli_query($connection,$query);

			if($table){
				$rows=mysqli_num_rows($table);
				if($rows > 0){
				    for($x = 0; $x<= $row; $x++){
						$row = mysqli_fetch_assoc($table);
						if ($_GET['user'] == $row['contact_id']){
							?>
							$("button#add-contact").html("Added in Contact List");
							$("button#add-contact").val(1);
							$("button#add-contact").css({"background-color":"white","border":"1px solid #16b980", "color":"#16b980"});
							<?php
							$_SESSION['added'] = 1;
							break;
						}
					}
				}
			}
		}
	?>

	$("form#form-edu").hide();
	$("form#form-int").hide();
	$("form#form-ski").hide();
	$("button#cancel-edu").click(function(){
		$("form#form-edu").hide();
	});
	$("button#cancel-ski").click(function(){
		$("form#form-ski").hide();
	});
	$("button#cancel-int").click(function(){
		$("form#form-int").hide();
	});
	$("button#add-edu").click(function(){
		$("form#form-edu").toggle();
	});
	$("button#add-ski").click(function(){
		$("form#form-ski").toggle();
	});
	$("button#add-int").click(function(){
		$("form#form-int").toggle();
	});
});
</script>
</body>
</html>