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
    <link href="css/all.css" rel="stylesheet" type="text/css" />

    <script src="js/jquery.min.js"></script>

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

        .receive,
        .delete {
            padding: 12px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
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
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
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
                <?php
                session_start();
                $email = $_SESSION['loginName'];
                require_once('conn.php');
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $sql = "SELECT * FROM Orders, Dealer WHERE orderID LIKE '%$_POST[search]%' AND Orders.dealerID = '$email'";
                } else {
                    $sql = "SELECT * FROM Orders, Dealer WHERE Orders.dealerID = '$email'";
                }

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
                        <td><a><?php echo $rc['orderID'] ?></a></td>
                        <td><?php echo $rc['deliveryAddress'] ?></td>
                        <td><?php echo $rc['orderDate'] ?></td>
                        <td id="<?php echo $status ?>"><?php echo $status ?></td>
                        <td>$<?php $sql = "SELECT price FROM OrderPart WHERE orderID = $rc[orderID]";
                                $result = mysqli_query($conn, $sql);
                                $totalAmount = null;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $totalAmount += $row['price'];
                                }
                                echo $totalAmount;
                                //mysqli_free_result($result); 
                                ?></td>
                        <td><input class="grayButton" type="button" name="detail" value="Items" onclick="show('<?php echo $rc['orderID'] ?>');">
                            <button class="grayButton receive">Confirm Received</button>
                            <button class="grayButton delete">Cancel</button>
                        </td>
                    </tr>
                    <?php
                    $sql = "SELECT * FROM OrderPart WHERE orderID = $rc[orderID]";
                    $rs_hide = mysqli_query($conn, $sql);

                    while ($rc_hide = mysqli_fetch_assoc($rs_hide)) {
                        ?>
                        <tr class="hideItems <?php echo $rc['orderID'] ?>">
                            <td colspan="2">Part Number: <?php echo $rc_hide['partNumber'] ?></td>
                            <td colspan="2">Part Name: <?php $sql = "SELECT partName FROM Part WHERE partNumber = $rc_hide[partNumber]";
                                                        $result = mysqli_query($conn, $sql);
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            echo $row['partName'];
                                                        }
                                                        //mysqli_free_result($result); 
                                                        ?></td>
                            <td colspan="2">Quantity: <?php echo $rc_hide['quantity'] ?></td>
                            <td colspan="2">Price: $<?php echo $rc_hide['price'] ?></td>
                        </tr>
                    <?php
                    }
                    //mysqli_free_result($rs);
                }
                //mysqli_close($conn);
                ?>
            </table>
            <br>
        </form>
    </div>
</body>
<script type="text/javascript">
    $(".receive").click(function() {
        var receiveID = $(this).parents("tr").attr("id");

        var status = document.getElementById(receiveID).cells[3].innerHTML;
        if (status == "Completed") {
            alert("This order already completed!");
        } else if (status == "In processing") {
            alert("This order is in processing!");
        } else if (status == "Canceled") {
            alert("This order has been already Canceled!");
        } else if (status == "Delivery") {
            if (confirm('Are you sure you received those item(s)?')) {
                $.ajax({
                    url: 'delivery.php',
                    type: 'GET',
                    data: {
                        orderID: receiveID
                    },
                    error: function() {
                        alert('Something is wrong');

                        //alert("Status change to Delivery successfully");
                    },
                    success: function(data) {
                        alert("Status change to Delivery successfully");
                        document.location.reload();
                    }
                });
            }
        }
    });
</script>
<script type="text/javascript">
    $(".delete").click(function() {
        var deleteID = $(this).parents("tr").attr("id");

        var status = document.getElementById(deleteID).cells[3].innerHTML;
        if (status == "Completed") {
            alert("This order already completed!");
        } else if (status == "Canceled") {
            alert("This order already Canceled!");
        } else if (status == "Delivery") {
            alert("This order already Delivered!");
        } else {
            if (confirm('Are you sure you want to cancel this order?')) {
                $.ajax({
                    url: 'delete.php',
                    type: 'GET',
                    data: {
                        orderID: deleteID
                    },
                    error: function() {
                        alert('Something is wrong');
                    },
                    success: function(data) {
                        alert("Order Cancel successfully");
                        document.location.reload();
                    }
                });
            }
        }
    });
</script>

</html>