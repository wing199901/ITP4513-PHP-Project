<?php

require('conn.php');

if (isset($_GET['orderID'])) {//change order status
    $sql = "UPDATE Orders SET `status` = 2 WHERE orderID =  " . $_GET['orderID'];
    $rs = mysqli_query($conn, $sql);
    mysqli_free_result($rs);
    $sql = "SELECT * FROM OrderPart WHERE orderID =  " . $_GET['orderID'];
    $rs = mysqli_query($conn, $sql);

    while($rc=mysqli_fetch_assoc($rs)){
        $sql="UPDATE Part SET stockQuantity = StockQuantity - $rc[quantity] WHERE partNumber = $rc[partNumber]";//reduce the quantity of product
        mysqli_query($conn, $sql);
    }

    mysqli_free_result($rs);
    mysqli_close($conn);
    echo 'Delivery successfully.';
}
