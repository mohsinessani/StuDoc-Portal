<option value="select-deg">Select Job</option>
<?php
	include 'config.php';
	session_start();
	error_reporting(0);
	$institute = $_GET['institute'];
	$query = "select * from job where company_id=".$institute;
	$table = mysqli_query($connection,$query);
		if($table){
			$rows=mysqli_num_rows($table);
			if($rows > 0){
				for($x = 0; $x<= $row; $x++){
					$row = mysqli_fetch_assoc($table);
					if ($row){
		?>
						<option value="<?php echo $row['job_id'];?>"><?php echo $row['job_title'];?></option>
		<?php							
					}
				}
			}
		}
	?>