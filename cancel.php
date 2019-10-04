<?php

require('conn.php');

if (isset($_GET['orderID'])) {
    $sql = "UPDATE Orders SET `status` = 4 WHERE orderID =  " . $_GET['orderID'];//change order status
    $rs = mysqli_query($conn, $sql);
    mysqli_free_result($rs);
    mysqli_close($conn);
    echo 'Canceled successfully.';
}
?>