<head>
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
  <style type="text/css">

    ol, ul{
      list-style: none;
    }
    .pro-bodys{
      padding: 0;
    }

    .pro-bodys form{
      margin-left: -6px;
    margin-top: 5px;
    }
    .pro-bodys ul li{
      background-color: rgb(245,245,245);
    max-width: auto;
    margin: 15px 0px;
    padding: 10px 20px;
    border: 1px solid rgb(235,235,235);
    border-left: 2px solid green;
    }
    .education-list{
      margin: 0;
    padding: 0;
    border: 0;
    font-size: 100%;
    font: inherit;
    vertical-align: baseline;
    }
    .btn{
      padding: 10px;
      margin: 5px;
      margin-right: 10px;
    }
  </style>
</head>
<?php

    include 'config.php';
    
    $query = "SELECT * FROM `has_document` where verification_status = 'pending'";
    $table = mysqli_query($connection,$query);
    while ( $row = mysqli_fetch_array( $table ))
    {

      $student_id = $row['student_id'];
      $doc_id = $row['doc_id'];
      $doc_name = $row['doc_name'];
      $file = $row['file'];
      $size = $row['size'];
      $status = $row['verification_status'];
      $val = "pending";

      $query1 = "SELECT * FROM `user` where id = '$student_id'";
      $table1 = mysqli_query($connection, $query1);
      $row1 = mysqli_fetch_array( $table1 );


      echo "
        <div class='pro-education-body pro-bodys'>
        <ul class='education-list'>
        <li>
          <p style='padding-bottom: 10px; font-size:18px; font-weight:bold'>".$row1['name']."</p>
          <p style='padding-bottom: 10px;'><span style='font-weight:bold;'>Document Name : </span>".$doc_name."</p>
          <p style='padding-bottom: 10px;'><span style='font-weight:bold;'>Size : </span>".($size/1000000)." Mb</p>
          <a href='".$file."'><button style='padding: 10px;'> Download Now! </button> </a><br>     
          <form method='post'>
          <button type='submit' name='approved' value='$doc_id' class='btn' style='background-color: green;'> Approve</button>
          <button type='submit' name='rejected' value='$doc_id' class='btn' style='background-color: red;'> Reject</button> 
          </form>
      </li>
      </div>
        ";

    }

    if ($_POST)
    {
      if (isset($_POST['approved']))
      {
        $val = "approved";
        $is = $_POST['approved'];
      }
      elseif (isset($_POST['rejected']))
      {
        $val = "rejected";
        $is = $_POST['rejected'];
      }

      $query2 = "UPDATE has_document SET verification_status='$val' WHERE doc_id=$is";
      $result2 = mysqli_query($connection,$query2);
      if (mysqli_query($connection, $query2))
      {
        header('Location: '.$_SERVER['REQUEST_URI']);
      }

    }

?>
