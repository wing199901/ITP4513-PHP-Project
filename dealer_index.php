<!DOCTYPE html>
<html>

<head>
  <title>Index</title>
  <link rel="icon" href="favicon.ico" type="image/x-icon" />
  <link href="css/font.css" rel="stylesheet" type="text/css" />
  <link href="css/index.css" rel="stylesheet" type="text/css" />
  <script src="js/jquery.min.js"></script>
</head>

<body class="font">
  <center>
    <h1><img src="images/gear.png" width=32px> Spare Order System</h1>
  </center>
  <br>
  <ul>
    <li><a class="active" href="dealer_index.html">Home</a></li>
    <li><a href="make_order.php">Make Order</a></li>
    <li><a href="order_record.html">Order Record</a></li>
    <li><a href="acc_info.php">Account Info</a></li>
    <li><a href="index.php" onclick="return confirm('Are you sure you want to sign out?')">Log Out</a></li>
    </div>
    </li>
  </ul>
  <?php
  // if (isset($_POST['loginName'])) {
  // echo $_POST['loginName'];
  //}
  session_start();
  $dealerID = $_SESSION['loginName'];
  printf("<h1 style='text-align: center;font-size: 50px;margin-top:200px;color: grey;'>Welcome %s</h1>",$dealerID);
  ?>
  
  <br>

</body>

</html>