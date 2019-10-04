<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Account Information</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon" />
    <link href="css/font.css" rel="stylesheet" type="text/css" />
    <link href="css/index.css" rel="stylesheet" type="text/css" />
    <link href="css/table.css" rel="stylesheet" type="text/css" />
    <link href="css/button.css" rel="stylesheet" type="text/css" />

    <style>
        body {
            background-color: #f3f3f3;
        }

        table {
            width: 80%;
        }

        th {
            text-align: center;
        }

        td {
            text-align: left;
        }

        input {
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            resize: vertical;
            float: right;
            border-style: none;
            text-align: right;
        }

        #address {
            width: 100%;
        }

        #main {
            text-align: center;
            width: auto;
            height: auto;
            margin-top: 28px;
        }

        #update {
            margin-top: 10px;
            margin-right: 10%;
        }
    </style>

    <script>
        function setColor(n, id) {
            if (n == true)
                document.getElementById(id).style.backgroundColor = "#ddd";
            else
                document.getElementById(id).style.backgroundColor = "white";

        }
    </script>
</head>

<body class="font">
    <center>
        <h1><img src="images/gear.png" width=32px> Spare Order System</h1>
    </center>
    <br>
    <ul>
        <li><a href="dealer_index.php">Home</a></li>
        <li><a href="make_order.php">Make Order</a></li>
        <li><a href="order_record.php">Order Record</a></li>
        <li><a class="active" href="acc_info.php">Account Info</a></li>
        <li><a href="index.php" onclick="return confirm('Are you sure you want to sign out?')">Log Out</a></li>
    </ul>
    <div id="main">
        <?php
        session_start();
        $dealerID = $_SESSION['loginName'];//get dealerID
        require_once('conn.php');
        $sql = "select * from Dealer where dealerID='$dealerID'";
        $rs = mysqli_query($conn, $sql);
        $rc = mysqli_fetch_assoc($rs);
        //main form
        $form = <<<EOD
        <form method="POST" action="$_SERVER[PHP_SELF]" onsubmit="return confirm('Are you sure to update your personal information?')"  >
            <table align="center">
                <tr>
                    <th colspan="2" class="text=center">Account Information</th>
                <tr onmouseover="setColor(true, 'accountId')" onmouseout="setColor(false,'accountId')">
                    <td>Account ID</td>
                    <td><input type="text" name="accountId" id="accountId" readonly="readonly" value="%s" disabled>
                    </td>
                </tr>
                <tr>
                    <td>Name</td>
                    <td><input type="text" name="name" value="%s" pattern="^[A-Za-z ]*$" required></td>
                </tr>
                <tr>
                    <td>Phone Number</td>
                    <td><input type="text" name="tel" value="%s" pattern="^[0-9]{8}$" required></td>
                </tr>
                <tr>
                    <td>Address</td>
                    <td><input type="text" name="address" id="address" value="%s" required></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type="password" name="password" style="border-style:none" pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Za-z]).*$" title="Use 8 or more characters with a mix of letters, numbers & symbols"></td>
                </tr>
                <tr>
                    <td>Re-type Password</td>
                    <td><input type="password" name="rePassword" pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Za-z]).*$" title="Use 8 or more characters with a mix of letters, numbers & symbols" ></td>
                </tr>
            </table>
            <input type="submit" class="whiteButton" name="update" id="update" value="Update" ">
        </form>
EOD;
        printf($form, $dealerID, $rc['name'], $rc['phoneNumber'], $rc['address']);//insert from info 
        if (isset($_POST['update'])) {
            extract($_POST);
            $sql = "update Dealer set name='$name',  phoneNumber='$tel', address='$address'";
            if (!empty($password) && !empty($rePassword)) {//check password validity
                if ($password != $rePassword)
                    echo "<script>alert('Those passwords didn\'t match. Try again.');window.location.href='acc_info.php';</script>";
                $sql .= ",password='$password'";
            } else if (empty($password) && !empty($rePassword) || !empty($password) && empty($rePassword)) {
                echo "<script>alert('Both password must be entered.');window.location.href='acc_info.php';</script>";
            }
            $sql.="where dealerID='$dealerID'";
            require_once('conn.php');
            mysqli_query($conn, $sql);
            mysqli_free_result($rs);
            mysqli_close($conn);
            echo "<script>alert('Account information are updated');window.location.href('acc_info.php')</script>";
        }
        ?>
    </div>
</body>

</html>