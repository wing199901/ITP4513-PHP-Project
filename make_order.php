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

        thead {
            display: block;
        }

        tbody {
            height: 400px;
            overflow-y: scroll;
            display: block;
        }
    </style>

    <script type="text/javascript">
        $(function() {
            var colNumber = 7 //number of table columns

            for (var i = 0; i < colNumber; i++) {
                var thWidth = $("#myTable").find("th:eq(" + i + ")").width();
                var tdWidth = $("#myTable").find("td:eq(" + i + ")").width();
                if (thWidth < tdWidth)
                    $("#myTable").find("th:eq(" + i + ")").width(tdWidth);
                else
                    $("#myTable").find("td:eq(" + i + ")").width(thWidth);
            }
        });
    </script>
</head>

<body class="font">
    <center>
        <h1><img src="images/gear.png" width=32px> Spare Order System</h1>
    </center>
    <br>
    <ul>
        <li><a href="dealer_index.html">Home</a>
        </li>
        <li><a class="active" href="make_order.html">Make Order</a>
        </li>
        <li><a href="order_record.html">Order Record</a>
        </li>
        <li><a href="acc_info.html">Account Info</a>
        </li>
        <li><a href="index.html" onclick="return confirm('Are you sure you want to sign out?')">Log Out</a>
        </li>
    </ul>
    <br>


    <?php
    require_once('conn.php');
    $sql = "SELECT * FROM Part WHERE stockStatus = 1 AND stockQuantity > 0 ";
    $rs = mysqli_query($conn, $sql);

    echo '<form method="POST" action="$_SERVER[PHP_SELF]">';
    echo '<div>
            <table align="center" id="myTable">
            <thead><tr>
            <th>Part Number</th>
            <th>Email</th>
            <th>Part Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Status</th>
            <th>Purchase</th>
            </thead>
            <tbody>';
    while ($rc = mysqli_fetch_assoc($rs)) {
        printf(
            '<tr><td>%s</td>
            <td>%s</td>
            <td>%s</td>
            <td>%s</td>
            <td>%s</td>
            <td>Available</td>
            <td><input type="text" name="%s" id="purchase"></td></tr>',
            $rc['partNumber'],
            $rc['email'],
            $rc['partName'],
            $rc['stockQuantity'],
            $rc['stockPrice'],
            $rc['partNumber']
        );
    }
    echo '</tbody></table></div><br>
            <div class="submit">Delivery Address:<input type="text" name="Address" value="My address">&emsp;
            <input class="whiteButton" type="submit" onclick="return confirm("Are you sure you want to place order?")">&emsp;
            <input class="whiteButton" type="reset"></div>
            </form>';

    if (isset($_POST[$rc['partNumber']])) {

        while ($rc = mysqli_fetch_assoc($rs)) { }

        $_POST[$rc['partNumber']] != "";
    }

    mysqli_free_result($rs);
    mysqli_close($conn);
    ?>


</body>

</html>