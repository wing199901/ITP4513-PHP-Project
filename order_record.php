<!doctype html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Order Record</title>
  <link rel="icon" href="favicon.ico" type="image/x-icon" />
  <link href="css/font.css" rel="stylesheet" type="text/css" />
  <link href="css/index.css" rel="stylesheet" type="text/css" />
  <link href="css/table.css" rel="stylesheet" type="text/css" />
  <link href="css/button.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <style>
    table {
      width: 99%;
    }

    input[type=text] {
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    div {
      width: auto;
      height: auto;
      text-align: center;
    }

    #headerButton {
      float: left;
      margin-left: 1%;
    }

    .hideItems {
      display: none;
      background-color: #ccc;
    }
  </style>

  <script>
    function show(hideItems) {
      for (var i = 0; i < document.getElementsByClassName(hideItems).length; i++) {
        if (document.getElementsByClassName(hideItems)[i].style.display == 'table-row') {
          document.getElementsByClassName(hideItems)[i].style.display = 'none';
        } else {
          document.getElementsByClassName(hideItems)[i].style.display = 'table-row';
        }
      }
    }
  </script>
</head>

<body class="font">
  <center>
    <h1><img src="images/gear.png" width=32px> Spare Order System</h1>
  </center>
  <br>
  <ul>
    <li><a href="dealer_index.php">Home</a></li>
    <li><a href="make_order.php">Make Order</a></li>
    <li><a class="active" href="order_record.php">Order Record</a></li>
    <li><a href="acc_info.php">Account Info</a></li>
    <li><a href="index.php" onclick="return confirm('Are you sure you want to sign out?')">Log Out</a></li>
  </ul>
  <br>

  <div>
    <form method="POST" action="$_SERVER[PHP_SELF]">
      <div id="headerButton">
        <input type="text" placeholder="Search Order" name="search" id="search">
        <button type="submit"><i class="fa fa-search"></i></button><br><br>
      </div>
      <table align="center">
        <tr>
          <th>Order ID</th>
          <th>Address</th>
          <th>Order Date</th>
          <th>Status</th>
          <th>Amount</th>
          <th>Management</th>
        </tr>
        <tr>
          <td><a>100001</a></td>
          <td>LWL IVE</td>
          <td>2019-6-20</td>
          <td>In processing</td>
          <td>$100</td>
          <td><input class="grayButton" type="button" name="detail" value="Items" onclick="show('hideItems');">
            <input type="button" onclick="return confirm('Are you sure you received your item(s)?')" class="grayButton" name="Received" id="Received" value="Confirm">
            <input class="grayButton" type="button" value="Cancel" onclick="return confirm('Are you sure you want to cancel this order?')">
          </td>
        </tr>
        <tr class="hideItems">
          <td colspan="2">Part Number: 100001</td>
          <td colspan="2">Part Name: part1</td>
          <td colspan="1">Quantity: 10</td>
          <td colspan="1">Price: $10</td>
        </tr>
        <tr class="hideItems">
          <td colspan="2">Part Number: 100002</td>
          <td colspan="2">Part Name: part2</td>
          <td colspan="1">Quantity: 10</td>
          <td colspan="1">Price: $10</td>
        </tr>
      </table>
      <br>
    </form>
  </div>
</body>

</html>