<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Create Account</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon" />
    <link href="css/font.css" rel="stylesheet" type="text/css" />
    <link href="css/button.css" rel="stylesheet" type="text/css" />
    <style>
        h1 {
            text-align: center;
        }

        body {
            background-color: white;
        }

        #main {
            text-align: center;
            background-color: #F3F3F3;
            width: 500px;
            height: auto;
            margin: 0 auto;
            border: 3px #F3F3F3 solid;
            border-radius: 10px;
            margin-top: 100px;
            padding-bottom: 50px;
        }

        h2 {
            color: grey
        }

        input {
            font-size: 25px;
            border: 10px;
            border-radius: 5px;
            width: 400px;
            padding: 10px;
            margin: -5px;
        }

        p {
            text-align: left;
            margin-left: 45px;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        #name,
        #pwd {
            width: 180px;
            float: left;
            margin-left: 40px;
            margin-bottom: 10px;
        }

        #tel,
        #confirmPwd {
            width: 180px;
            float: right;
            margin-right: 40px;
            margin-bottom: 10px;
        }

        #register {
            width: 120px;
        }

        #divSubmit {
            float: right;
            width: 200px;
            margin-top: 15px;
        }

        [name=hint] {
            font-size: 12px;
        }

        li {
            display: inline-block;
            margin-bottom: 20px;
        }

        .left {
            float: left;
            margin-left: 45px;

        }

        .right {
            float: right;
            margin-right: 130px;
        }

        .right_confirm {
            float: right;
            margin-right: 175px;
        }
        a {
			color: cornflowerblue;
			text-decoration: none;
            float: right;
            margin-top:15px;
            margin-right: 45px;
		}
    </style>
</head>

<body class=font>
    <?php
    if (isset($_POST['accountId'])) {
        extract($_POST);
        require_once('conn.php');
        $sql =  "select dealerID from Dealer where dealerID='$accountId'";
        $rs =  mysqli_query($conn, $sql);
        if (mysqli_num_rows($rs) == 0) {//checking dealerId is unique
            mysqli_free_result($rs);
            if ($pwd == $confirmPwd) {//comfirm password
                $sql = "INSERT INTO Dealer VALUES ('$accountId','$pwd','$name','$tel','$address')";
                mysqli_query($conn, $sql);
                mysqli_close($conn);
                header("location: index.php");
            } else {
                mysqli_close($conn);
                echo "<script>alert('Those passwords didn\'t match. Try again.');</script>";
            }
        } else {
            mysqli_free_result($rs);
            mysqli_close($conn);
            echo "<script>alert('That accountID is taken. Try another.');</script>";
        }
    }
    ?>
    <h1><img src="images/gear.png" width=32px> Spare Order System</h1>
    <div id="main">
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <h2>Create your Dealer Account</h2>
            <p>Account ID</p>
            <input type="text" name="accountId" id="accountId" pattern="^[0-9A-Za-z.]{8,}$" title="You can use letters, number&periods at least 8 charchers." required>//limited format 
            <p name="hint">You can use letters, number&periods at least 8 charchers</p>
            <li class="left">Your Name</li>
            <li class="right">Phone Number</li><br /><br />
            <input type="text" name="name" id="name" pattern="^[A-Za-z ]*$" required>
            <input type="text" name="tel" id="tel" pattern="^[0-9]{8}$" required>
            <p>Address</p>
            <input type="text" name="address" id="address" required><br /><br />
            <li class="left">Password</li>
            <li class="right_confirm">Confirm</li><br />
            <input type="password" name="pwd" id="pwd" pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Za-z]).*$" title="Use 8 or more characters with a mix of letters, numbers & symbols" required>
            <input type="password" name="confirmPwd" id="confirmPwd" pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Za-z]).*$" title="Use 8 or more characters with a mix of letters, numbers & symbols" required><br /><br /><br />
            <p name="hint">Use 8 or more characters with a mix of letters, numbers & symbols</p>
            <div id="divSubmit"><input type="submit" value="Register" id="register" class="whiteButton"><br/><a href="index.php">Previous</a></div>
            <br /><br />
        </form>
    </div>

</body>

</html>