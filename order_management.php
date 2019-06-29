<!DOCTYPE html>
<html>

<head>
    <title>Order Management</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon" />
    <link href="css/font.css" rel="stylesheet" type="text/css" />
    <link href="css/index.css" rel="stylesheet" type="text/css" />
    <link href="css/table.css" rel="stylesheet" type="text/css" />
    <link href="css/button.css" rel="stylesheet" type="text/css" />
    <link href="css/all.css" rel="stylesheet" type="text/css" />

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
            margin-top: 20px;
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
</head>

<body class="font">
    <center>
        <h1><img src="images/gear.png" width=32px> Spare Order System</h1>
    </center>
    <br>
    <ul>
        <li><a href="admin_index.php">Home</a></li>
        <li><a href="part_info.php">Part Info</a></li>
        <li><a class="active" href="order_management.php">Order Management</a></li>
        <li><a href="index.php" onclick="return confirm('Are you sure you want to sign out?')">Log Out</a></li>
        </div>
        </li>
    </ul>

    <div>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div id="headerButton">
                <input type="text" placeholder="Search Order" name="search" id="search">
                <button type="submit"><i class="fa fa-search"></i></button><br><br>
            </div>
            <table align="center">
                <tr>
                    <th>Order ID</th>
                    <th>Dealer ID</th>
                    <th>Dealer Name</th>
                    <th>Order Date</th>
                    <th>Address</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Management</th>
                </tr>
                <?php
                require_once('conn.php');
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $sql = "SELECT * FROM Orders WHERE orderID LIKE '%$_POST[search]%'";
                    $rs = mysqli_query($conn, $sql);
                    while ($rc = mysqli_fetch_assoc($rs)) {
                        switch ($rc['status']) {
                            case '1';
                                $status = "In processing";
                                break;
                            case '2':
                                $status = "Delivery";
                                break;
                            case '3':
                                $status = "Completed";
                                break;
                            case '4':
                                $status = "Canceled";
                                break;
                            default:
                                $status = "";
                        }
                        echo "<tr>
                                <td><a>$rc[partNumber]</a></td>
                                <td>$rc[partName]</td>
                                <td>$rc[stockQuantity]</td>
                                <td>$rc[stockPrice]</td>
                                <td>$status</td>
                                <td>$rc[email]</td>
                                <td><button class='grayButton edit'>Edit</button>
                                <button class='grayButton remove'>Remove</button>
                                </td>
                            </tr>";
                    }
                } else {
                    $sql = "SELECT * FROM Orders, Dealer";
                    $rs = mysqli_query($conn, $sql);

                    while ($rc = mysqli_fetch_assoc($rs)) {

                        switch ($rc['status']) {
                            case '1';
                                $status = "In processing";
                                break;
                            case '2':
                                $status = "Delivery";
                                break;
                            case '3':
                                $status = "Completed";
                                break;
                            case '4':
                                $status = "Canceled";
                                break;
                            default:
                                $status = "";
                        }
                        ?>
                        <tr id="<?php echo $rc['orderID'] ?>">
                            <td><?php echo $rc['orderID'] ?></td>
                            <td><?php echo $rc['dealerID'] ?></td>
                            <td><?php echo $rc['name'] ?></td>
                            <td><?php echo $rc['orderDate'] ?></td>
                            <td><?php echo $rc['deliveryAddress'] ?></td>
                            <td>$200</td>
                            <td><?php echo $status ?></td>
                            <td><input class="grayButton" type="button" name="detail" value="Items" onclick="show('hideItems');">
                                <input class="grayButton" type="button" name="delivered" value="Ready to delivery" onclick="return confirm('Are you sure this order is ready to delivery?')">
                                <input class="grayButton" type="button" name="cancel" value="Cancel" onclick="return confirm('Are you sure you want to cancel this order?')">
                            </td>
                        </tr>
                    <?php }
                    mysqli_free_result($rs);
                    mysqli_close($conn);
                    ?><tr class="hideItems">
                        <td colspan="2">Part Number: 100001</td>
                        <td colspan="2">Part Name: part1</td>
                        <td colspan="2">Quantity: 10</td>
                        <td colspan="2">Price: $10</td>
                    </tr>
                <?php
                }
                ?>
            </table>
            <br>
        </form>
    </div>
</body>

</html>