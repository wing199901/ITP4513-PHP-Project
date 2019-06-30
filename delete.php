<?php

require('conn.php');

if (isset($_GET['orderID'])) {
    $sql = "DELETE FROM OrderPart WHERE orderID =  " . $_GET['orderID'];
    mysqli_query($conn, $sql);
    $sql = "DELETE FROM Orders WHERE orderID =  " . $_GET['orderID'];
    mysqli_query($conn, $sql);
    mysqli_close($conn);
    echo 'Cancel successfully.';
}
?>