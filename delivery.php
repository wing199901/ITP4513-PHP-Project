<?php

require('conn.php');

if (isset($_GET['orderID'])) {
    $sql = "UPDATE Orders SET `status` = 2 WHERE orderID =  " . $_GET['orderID'];
    $rs = mysqli_query($conn, $sql);
    mysqli_free_result($rs);
    $sql = "SELECT * FROM OrderPart WHERE orderID =  " . $_GET['orderID'];
    $rs = mysqli_query($conn, $sql);

    while($rc=mysqli_fetch_assoc($rs)){
        $sql="UPDATE Part SET stockQuantity = StockQuantity - $rc[quantity] WHERE partNumber = $rc[partNumber]";
        mysqli_query($conn, $sql);
    }
    mysqli_close($conn);
    echo 'Delivered successfully.';
}
