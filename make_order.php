<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Make Order</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon"/>
    <link href="css/font.css" rel="stylesheet" type="text/css"/>
    <link href="css/index.css" rel="stylesheet" type="text/css"/>
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
        <li><a href="record.html">Order Record</a>
        </li>
        <li><a href="acc_info.html">Account Info</a>
        </li>
        <li><a href="login.html" onclick="return confirm('Are you sure you want to sign out?')">Log Out</a>
        </li>
        </div>
        </li>
    </ul>
    <br>

    <?php
    require_once( 'conn.php' );
    $sql = "SELECT * FROM Part WHERE stockStatus = 1 AND stockQuantity > 0 ";
    $rs = mysqli_query( $conn, $sql );

    echo '<form method="POST" action="$_SERVER[PHP_SELF]">';
    echo '<table border="1"><tr>
            <th>Part Number</th><th>Email</th><th>Part Name</th><th>Quantity</th><th>Price</th><th>Status</th>';
    while ( $rc = mysqli_fetch_assoc( $rs ) )
        printf( '<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td</tr>', $rc[ 'partNumber' ], $rc[ 'email' ], $rc[ 'partName' ], $rc[ 'stockQuantity' ], $rc[ 'stockPrice' ], $rc[ 'stockStatus' ] );
    echo '</table>';
    mysqli_free_result( $rs );
    mysqli_close( $conn );
    ?>

</body>

</html>