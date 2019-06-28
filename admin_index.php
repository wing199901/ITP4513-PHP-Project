<!DOCTYPE html>
<html>

<head>
  <title>Index</title>
  <link rel="icon" href="favicon.ico" type="image/x-icon" />
  <link href="css/font.css" rel="stylesheet" type="text/css" />
  <link href="css/index.css" rel="stylesheet" type="text/css" />
</head>

<body class="font">
  <center>
    <h1><img src="images/gear.png" width=32px> Spare Order System</h1>
  </center>
  <br>
  <ul>
    <li><a class="active" href="admin_index.php">Home</a></li>
    <li><a href="part_info.php">Part Info</a></li>
    <li><a href="order_management.php">Order Management</a></li>
    <li><a href="index.php" onclick="return confirm('Are you sure you want to sign out?')">Log Out</a></li>
    </div>
    </li>
  </ul>
  <?php
  session_start();
  $email = $_SESSION['loginName'];
  require_once('conn.php');
  $sql = "SELECT firstName,lastName FROM Administrator where email = '$email'";
  $rs = mysqli_query($conn, $sql);
  $rc = mysqli_fetch_assoc($rs);
  printf("<h1 style='text-align: center;font-size: 50px;margin-top:200px;color: grey;'>Welcome %s</h1>", $rc['lastName'] . " " . $rc['firstName']);
  mysqli_free_result($rs);
  mysqli_close($conn);
  ?>
</body>

</html>