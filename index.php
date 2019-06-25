<?php
    require_once('conn.php');
    $username = $_POST['username'];
    $password = $_POST['pwd'];

    if(strstr($_POST['username'],"@")==false){  //DealerID login
        $sql = "SELECT dealerID FROM Dealer where dealerID = '$username'";
        $rs = mysqli_query($conn, $sql);
        if($rs === FALSE) { 
            printf("Error: %s\n", mysqli_error($conn));
            exit();
        }
        $rc = mysqli_fetch_assoc($rs);
        if($_POST['username']==$rc['dealerID']){
            $sql = sprintf("SELECT password FROM Dealer where dealerID = '%s'",$_POST['username']);
            $rs = mysqli_query($conn, $sql);
            $rc = mysqli_fetch_assoc($rs);
            if($_POST['pwd']==$rc['password']){
                header("Location:dealer_index.html");
            }else{
                echo '<script>return confirm("")</script>';
            }
        }else{
            echo "";
            }

        
    }else{                                      //Email login
        $sql = "SELECT email FROM Administrator";
        $rs = mysqli_query($conn, $sql);

        header("Location:admin_index.html");
    }

    
    
    
    
?>