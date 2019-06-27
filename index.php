<!doctype html>
<html>

<head>
	<meta charset="UTF-8">
	<title>Login</title>
	<link rel="icon" href="favicon.ico" type="image/x-icon" />
	<link href="css/font.css" rel="stylesheet" type="text/css" />
	<link href="css/button.css" rel="stylesheet" type="text/css" />
	<style>
		a:active {
			background-color: #a9c4f5;
			border: 10px;
			border-radius: 2px;
		}

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
			padding-bottom: 60px;
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
			margin: 10px;
		}

		#pwd {
			margin-bottom: 10px;
		}

		#remember {
			width: auto;
			margin: 0px;
			padding: 0px;
			size: 20px;
			margin-left: 40px;
		}

		#login {
			width: 120px;
		}

		#divRemember {
			float: left;
		}

		#divCreate {
			float: right;
			width: 200px;
		}

		#divSubmit {
			float: right;
			width: 200px;
		}

		a {
			color: cornflowerblue;
			text-decoration: none;
		}

		#divAdminLogin,
		#divDealerLogin {
			float: right;
			width: 200px;
		}
	</style>
</head>

<body class=font>
	<?php
	if (isset($_POST['loginName'])) {
		if ($_POST['loginName'] != "" && $_POST['pwd'] != "") {
			extract($_POST);
			if (strstr($loginName, "@") == false) {
				require_once('conn.php');
				$sql = "SELECT dealerID FROM Dealer where dealerID = '$loginName'";
				$rs = mysqli_query($conn, $sql);
				$rc = mysqli_fetch_assoc($rs);
				if (mysqli_num_rows($rs) == 1 && $loginName == $rc['dealerID']) {
					$sql = sprintf("SELECT password FROM Dealer where dealerID = '%s'", $loginName);
					$rs = mysqli_query($conn, $sql);
					$rc = mysqli_fetch_assoc($rs);
					if ($pwd == $rc['password']) {
						mysqli_free_result($rs);
						mysqli_close($sql);
						header("Location:dealer_index.html");
					}else{
						mysqli_free_result($rs);
						mysqli_close($sql);
						echo "<script>alert('Wrong username or password. Please try again');window.location.href='index.php';</script>";
					}
				} else {
					mysqli_free_result($rs);
					mysqli_close($sql);
					echo "<script>alert('Wrong username or password. Please try again');window.location.href='index.php';</script>";
				}
			} else {//here
				require_once('conn.php');
				$sql = "SELECT email FROM Administrator where email = '$loginName'";
				$rs = mysqli_query($conn, $sql);
				$rc = mysqli_fetch_assoc($rs);
				if (mysqli_num_rows($rs) == 1 && $loginName == $rc['email']) {
					$sql = sprintf("SELECT password FROM Administrator where email = '%s'", $loginName);
					$rs = mysqli_query($conn, $sql);
					$rc = mysqli_fetch_assoc($rs);
					if ($pwd == $rc['password']) {
						mysqli_free_result($rs);
						mysqli_close($sql);
						header("Location:admin_index.html");
					}else{
						mysqli_free_result($rs);
						mysqli_close($sql);
						echo "<script>alert('Wrong username or password. Please try again');window.location.href='index.php';</script>";
					}
				}
			}
		} else {
			mysqli_free_result($rs);
			mysqli_close($sql);
			echo "<script>alert('Please enter your username and password.');window.location.href='index.php';</script>";
		}
	} else {
		$login = <<<EOD
	<h1><img src="images/gear.png" width=32px> Spare Order System</h1>
	<div id="main">
		<form method="POST" action="$_SERVER[PHP_SELF]">
			<h2>Sign In</h2>
			<input type="text" name="loginName" placeholder="DealerID or Email">
			<input type="text" name="pwd" placeholder="Password" id="pwd">
			<div id="divRemember"><input type="checkbox" id="remember"> Remember Me </div>
			<div id="divCreate"><a href="create_account.html">Create Account</a></div>
			<div id="divSubmit"><input type="submit"
						value="Login" id="login" class="whiteButton">
						<br/>
				<a href="admin_index.html">Admin Login</a>
				<a href="dealer_index.html">Dealer Login</a></div>

			<br /><br />
		</form>
	</div>
EOD;

		echo $login;
	}
	?>
</body>

</html>