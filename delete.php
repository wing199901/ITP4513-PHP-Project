<?php

require('conn.php');

if (isset($_GET['orderID'])) {//delete order
    $sql = "DELETE FROM OrderPart WHERE orderID =  " . $_GET['orderID'];//delete orderPart
    mysqli_query($conn, $sql);
    $sql = "DELETE FROM Orders WHERE orderID =  " . $_GET['orderID'];//delete order
    mysqli_query($conn, $sql);
    mysqli_close($conn);
    echo 'Cancel successfully.';
}
?>