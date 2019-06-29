<?php

require('conn.php');

if (isset($_GET['partNumber'])) {
    $sql = "UPDATE Part SET stockStatus = 2 WHERE partNumber =  " . $_GET['partNumber'];
    $rs = mysqli_query($conn, $sql);
    mysqli_free_result($rs);
    mysqli_close($conn);
    echo 'Removed successfully.';
}
?>