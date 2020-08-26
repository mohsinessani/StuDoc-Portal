<?php
	include 'config.php';
	session_start();
	if (empty($_SESSION['login_user'])){
		header("location: index.php");
		exit();
	}

	$user = $_SESSION['login_user'];

	if((isset($_FILES['fileToUpload']['name'])) && ($_POST['filename'] != ""))
		{
			$uploadOk=1;
			$fileName=$_FILES['fileToUpload']['name'];
			$fileName=str_replace(' ', '', $fileName);
			$errorMessage="";

			if($fileName != "") 
			{
				$targetDir = "docs/";
				$fileName = $targetDir . uniqid().basename($fileName);
				$fileSize = $_FILES['fileToUpload']['size'];
				$fileType = pathinfo($fileName, PATHINFO_EXTENSION);

				if($_FILES['fileToUpload']['size'] > 10000000)
				{
					$errorMessage = "Sorry, your file is too large";
					$uploadOk = 0;
				}

				if(strtolower($fileType) != "jpg" && strtolower($fileType) != "jpeg" && strtolower($fileType) != "png" && strtolower($fileType) != "pdf" && strtolower($fileType) != "docx" && strtolower($fileType) != "doc" && strtolower($fileType) != "pptx" && strtolower($fileType) != "ppt" && strtolower($fileType) != "xls" && strtolower($fileType) != "xlsx")
				{
					$errorMessage = "Sorry, Un-supported File Format";
					$uploadOk = 0;
				}

				if($uploadOk) 
				{
					if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $fileName)) 
					{
						//file uploaded okay
					}
					else 
					{
						//file did not upload
						$uploadOk = 0;
					}
				}

			}

			if($uploadOk) 
			{
				$fName=strip_tags($_POST['filename']);

				$check=mysqli_query($connection,"SELECT doc_name FROM has_document WHERE doc_name='$fName'");
				if(mysqli_num_rows($check) == 0)
				{
					echo $user.$fName.$fileName.$fileSize;
					$query=mysqli_query($connection,"INSERT INTO has_document VALUES('$user','','$fName','$fileName','$fileSize','pending')");
					$fileName="";
					$fName="";
					$fileSize="";
				}
			}
		}
		else 
		{
			$fileName="";
			echo '<div class="alert alert-danger alert-dismissible">
    				<button type="button" class="close" data-dismiss="alert">&times;</button>
    				<strong>Error!</strong>'." $errorMessage".'</div>';
		}

	header("location: document.php?user=".$_SESSION['login_user']);
	mysqli_close($connection); // Closing Connection
?>
