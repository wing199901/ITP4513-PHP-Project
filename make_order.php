<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Make Order</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon" />
    <link href="css/font.css" rel="stylesheet" type="text/css" />
    <link href="css/index.css" rel="stylesheet" type="text/css" />
    <link href="css/table_make_order.css" rel="stylesheet" type="text/css" />
    <link href="css/button.css" rel="stylesheet" type="text/css" />

    <script type="text/javascript" src="js/jquery-1.10.1.js"></script>

    <style>
        input[type=text] {
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        div {
            text-align: center;
            width: auto;
            height: auto;
        }

        div .submit {
            float: inherit;
        }

        table {
            table-layout: fixed;
            border-collapse: collapse;

        }

        td {
            word-wrap: break-word;
        }

        thead,
        tbody tr {
            display: table;
            width: 850px;
            table-layout: fixed;

        }

        tbody {
            text-align: left;
            height: 400px;
            overflow-y: scroll;
            display: block;
        }
    </style>
</head>

<body class="font">
    <center>
        <h1><img src="images/gear.png" width=32px> Spare Order System</h1>
    </center>
    <br>
    <ul>
        <li><a href="dealer_index.php">Home</a>
        </li>
        <li><a class="active" href="make_order.php">Make Order</a>
        </li>
        <li><a href="order_record.php">Order Record</a>
        </li>
        <li><a href="acc_info.php">Account Info</a>
        </li>
        <li><a href="index.php" onclick="return confirm('Are you sure you want to sign out?')">Log Out</a>
        </li>
    </ul>
    <br>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return confirm('Are you sure you want to place order?');">
        <div>
            <table align="center" id="myTable">
                <thead>
                    <tr>
                        <th style="width: 110px;">Part Number</th>
                        <th style="width: 150px;">Email</th>
                        <th style="width: 90px;">Part Name</th>
                        <th style="width: 90px;">Quantity</th>
                        <th style="width: 90px;">Price</th>
                        <th style="width: 90px;">Status</th>
                        <th style="width: 170px;">Purchase</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    session_start();
                    $dealerID = $_SESSION['loginName'];
                    require_once('conn.php');
                    $sql = "SELECT * FROM Dealer WHERE dealerID='$dealerID'";
                    $rs = mysqli_query($conn, $sql);
                    $rc = mysqli_fetch_assoc($rs);
                    $address = $rc['address'];
                    $sql = "SELECT * FROM Part WHERE stockStatus = 1 AND stockQuantity > 0 ";
                    $rs = mysqli_query($conn, $sql);
                    if (isset($_POST['submit'])) {
                        $confirm_message = "Thank you for your order\\nOrderID: %s\\nDelivery Address: $_POST[address]\\nPurchasing List:\\n";
                        $itemsCount = 0;
                        $totalAmount = 0;
                        $sql_items = "INSERT INTO OrderPart VALUES";
                        while ($rc = mysqli_fetch_assoc($rs)) {
                            if ($_POST[$rc['partNumber']] != "") {
                                if ($_POST[$rc['partNumber']] > $rc['stockQuantity']) {
                                    echo "<script>alert('Your purchasing quantity of $rc[partName] is over our stock.');window.location.href='make_order.php';</script>";
                                }
                                $confirm_message .= "Item: $rc[partName] ";
                                $tmp = "$rc[partNumber]";
                                $confirm_message .= "x $_POST[$tmp]\\n";
                                if ($itemsCount++ == 0) {
                                    $sql_items .= "(%1\$s,$rc[partNumber],$_POST[$tmp]," . $rc['stockPrice'] * $_POST[$tmp] . ")";
                                } else {
                                    $sql_items .= ",(%1\$s,$rc[partNumber],$_POST[$tmp]," . $rc['stockPrice'] * $_POST[$tmp] . ")";
                                }
                                $totalAmount += $rc['stockPrice'] * $_POST[$tmp];
                            }
                        }
                        if ($itemsCount == 0) {
                            echo "<script>alert('Your purchasing list is empty.');window.location.href='make_order.php';</script>";
                        } else {
                            $sql = "INSERT INTO Orders (dealerID,orderDate,deliveryAddress, status) values('$dealerID',curdate(),'$_POST[address]',1)";
                            mysqli_query($conn, $sql) or die($conn);
                            $sql = "SELECT max(orderID) AS max_orderID from Orders where dealerID='$dealerID'";
                            $rs = mysqli_query($conn, $sql) or die($conn);
                            $orderID = mysqli_fetch_assoc($rs)['max_orderID'];
                            $confirm_message .= "Total amount: $$totalAmount";
                            $sql_items = sprintf($sql_items, $orderID);
                            mysqli_query($conn, $sql_items) or die($conn);
                            printf("<script>alert('$confirm_message');window.location.href='make_order.php';</script>", $orderID);
                        }
                    }
                    while ($rc = mysqli_fetch_assoc($rs)) {
                        $form = "<tr>
                            <td style='width: 110px;'>$rc[partNumber]</td>
                            <td style='width: 150px;'>$rc[email]</td>
                            <td style='width: 90px;'>$rc[partName]</td>
                            <td style='width: 90px;'>$rc[stockQuantity]</td>
                            <td style='width: 90px;'>$rc[stockPrice]</td>
                            <td style='width: 90px;'>Status</td>
                            <td style='width: 170px;'><input type='text' name='$rc[partNumber]' id='$rc[partNumber]' pattern='^[0-9]*$' title='please enter the quantity of part'></td>
                            </tr>";
                        echo $form;
                    }
                    mysqli_free_result($rs);
                    mysqli_close($conn);
                    ?>
                </tbody>
            </table>
        </div><br>
        <div class='submit'>Delivery Address:<input type='text' name='address' value='<?php echo htmlspecialchars("$address"); ?>'>&emsp;
            <input class='whiteButton' type='submit' name='submit'>&emsp;
            <input class='whiteButton' type='reset'></div>
    </form>
</body>

</html>