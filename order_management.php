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
            margin-top: 20px;
        }

        .hideItems {
            display: none;
            background-color: #ccc;
        }

        .delivery,
        .cancel {
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
                    $sql = "SELECT * FROM Orders, Dealer WHERE orderID LIKE '%$_POST[search]%'";
                } else {
                    $sql = "SELECT * FROM Orders, Dealer";
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
                        <td><?php echo $rc['orderID'] ?></td>
                        <td><?php echo $rc['dealerID'] ?></td>
                        <td><?php echo $rc['name'] ?></td>
                        <td><?php echo $rc['orderDate'] ?></td>
                        <td><?php echo $rc['deliveryAddress'] ?></td>
                        <td>$<?php $sql = "SELECT price FROM OrderPart WHERE orderID = $rc[orderID]";
                                $result = mysqli_query($conn, $sql);
                                $totalAmount = null;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $totalAmount += $row['price'];
                                }
                                echo $totalAmount;
                                //mysqli_free_result($result); 
                                ?></td>
                        <td id="<?php echo $status ?>"><?php echo $status ?></td>
                        <td><input class="grayButton" type="button" name="detail" value="Items" onclick="show('<?php echo $rc['orderID'] ?>');">
                            <button class="grayButton delivery">Ready to delivery</button>
                            <button class="grayButton cancel"> Cancel</button>
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
    $(".delivery").click(function() {
        var deliveryID = $(this).parents("tr").attr("id");

        var status = document.getElementById(deliveryID).cells[6].innerHTML;
        if (status == "Completed") {
            alert("This order already completed!");
        } else if (status == "Delivery") {
            alert("This order already Delivered!");
        } else if (status == "Canceled") {
            alert("This order has been already Canceled!");
        } else if (status == "In processing") {
            if (confirm('Are you sure this order is ready to delivery?')) {
                $.ajax({
                    url: 'delivery.php',
                    type: 'GET',
                    data: {
                        orderID: deliveryID
                    },
                    error: function() {
                        //alert('Something is wrong');

                        alert("Status change to Delivery successfully");
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
    $(".cancel").click(function() {
        var cancelID = $(this).parents("tr").attr("id");

        var status = document.getElementById(cancelID).cells[6].innerHTML;
        if (status == "Completed") {
            alert("This order already completed!");
        } else if (status == "Canceled") {
            alert("This order already Canceled!");
        } else {
            if (confirm('Are you sure you want to cancel this order?')) {
                $.ajax({
                    url: 'cancel.php',
                    type: 'GET',
                    data: {
                        orderID: cancelID
                    },
                    error: function() {
                        alert('Something is wrong');
                    },
                    success: function(data) {
                        alert("Status change to Canceled successfully");
                        document.location.reload();
                    }
                });
            }
        }
    });
</script>

</html>