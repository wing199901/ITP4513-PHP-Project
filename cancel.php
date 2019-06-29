<?php

require('conn.php');

if (isset($_GET['orderID'])) {
    $sql = "UPDATE Part SET `status` = 4 WHERE orderID =  " . $_GET['orderID'];
    $rs = mysqli_query($conn, $sql);
    mysqli_free_result($rs);
    mysqli_close($conn);
    echo 'Canceled successfully.';
}
?>