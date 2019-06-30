<!doctype html>
<html>

<head>
	<meta charset="UTF-8">
	<title>Login</title>
	<link rel="icon" href="favicon.ico" type="image/x-icon" />
	<link href="css/font.css" rel="stylesheet" type="text/css" />
	<link href="css/button.css" rel="stylesheet" type="text/css" />
	<script src="js/jquery-3.4.1.min.js"></script>
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
		if (!empty($_POST['loginName']) && !empty($_POST['pwd'])) {
			extract($_POST);
			if (!empty($remember)) {
				setcookie("loginName", $loginName, time() + (7 * 24 * 60 * 60));
			} else {
				if (isset($_COOKIE["loginName"])) {
					setcookie("loginName", "", time() - 60);
				}
			}
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
						mysqli_close($conn);
						session_start();
						session_unset();
						$_SESSION['loginName'] = $loginName;
						header("Location:dealer_index.php");
					} else {
						mysqli_free_result($rs);
						mysqli_close($conn);
						echo "<script>alert('Wrong username or password. Please try again');window.location.href='index.php';</script>";
					}
				} else {
					mysqli_free_result($rs);
					mysqli_close($conn);
					echo "<script>alert('Wrong username or password. Please try again');window.location.href='index.php';</script>";
				}
			} else { //here
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
						mysqli_close($conn);
						session_start();
						session_unset();
						$_SESSION['loginName'] = $loginName;
						header("Location:admin_index.php");
					} else {
						mysqli_free_result($rs);
						mysqli_close($conn);
						echo "<script>alert('Wrong username or password. Please try again');window.location.href='index.php';</script>";
					}
				} else {
					mysqli_free_result($rs);
					mysqli_close($conn);
					echo "<script>alert('Wrong username or password. Please try again');window.location.href='index.php';</script>";
				}
			}
		} else {
			echo "<script>alert('Please enter your username and password.');window.location.href='index.php';</script>";
		}
	} else {
		$login = <<<EOD
	<h1><img src="images/gear.png" width=32px> Spare Order System</h1>
	<div id="main">
		<form method="POST" action="$_SERVER[PHP_SELF]" id="loginForm" name="loginForm">
			<h2>Sign In</h2>
			<input type="text" name="loginName" placeholder="DealerID or Email" value="%s">
	<input type="password" name="pwd" placeholder="Password" id="pwd">
	<div id="divRemember"><input type="checkbox" id="remember" name="remember" %s> Remember Me </div>
	<div id="divCreate"><a href="create_account.php">Create Account</a></div>
	<div id="divSubmit"><input type="submit" value="Login" id="login" class="whiteButton">
	</form>
	</div>
EOD;
		printf($login, (isset($_COOKIE["loginName"])) ? $_COOKIE["loginName"] : "", (isset($_COOKIE["loginName"])) ? "checked" : "");
	}
	?>
</body>

</html>