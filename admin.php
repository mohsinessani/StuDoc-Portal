<?php
  error_reporting(0);
  include 'config.php';
  session_start(); 
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

  <style type="text/css">
    table {
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
  border: 1px solid #ddd;
}

th, td {
  text-align: left;
  padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}
  </style>

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
          <a href="verify.php">Verify Documents</a>
        </li>
      </ul>
        <br><br>
        <center>
        <iframe width="120px" height="60px" scrolling="no" src="clock.html"></iframe>
        </center>
      </ul>
    </nav>

    <div class="content-wrapper">
      <div class="profile-container">
        <div class="info-box">
          <img id="pro-timeline" src="images/pro-timeline.jpg"></img>
          <div class="pro-title">
                  <center><img class="profile-image" src="images/avatar-01.jpg">
                   <p id="pro-name" style="font-weight: bold;">List of Registered Students</p></center>
                </div>
              <div class="pro-education student">
                <div style="overflow-x:auto;">
  <table>
    <tr>
      <th>Roll No.</th>
      <th>Name</th>
      <th>Username</th>
      <th>E-Mail</th>
      <th>Contact No.</th>
      <th>Image URL</th>
      <th>Edit Details</th>
    </tr>
    <?php 
      $query=mysqli_query($connection,"SELECT * FROM user WHERE user_type='student'");
      while($row=mysqli_fetch_array($query))
      {
    ?>
    <tr>
      <td><?php echo $row['id']; ?></td>
      <td><?php echo $row['name']; ?></td>
      <td><?php echo $row['user_name']; ?></td>
      <td><?php echo $row['email_id']; ?></td>
      <td><?php echo $row['contact_no']; ?></td>
      <td><?php echo $row['img_url']; ?></td>
      <td><a href="adminsetting.php?user=<?php echo $row['id'];?>">Edit Info</a></td>
    </tr>
    <?php 
  }
    ?>
  </table>
</div>
              </div>  
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