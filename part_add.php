<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Part Adding</title>
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
            border-style: none;
        }

        input[type=text] {
            float: right;
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

        #divButton {
            margin-top: 10px;
            margin-right: 10%;
            float: right;
            text-align: right;
        }

        #divStatus {
            float: right;
        }
    </style>
    <script>
        function setColor(n, id) {
            if (n == true)
                document.getElementById(id).style.backgroundColor = "#ddd";
            else
                document.getElementById(id).style.backgroundColor = "white";

        }

        function InputFieldValidations(theForm) {

            if (theForm.partName.value == "") {
                alert("Please Enter the Part Name.");
                theForm.partName.focus();
                return (false);
            }

            if (theForm.qty.value == "") {
                alert("Please Enter the Part Quantity.");
                theForm.qty.focus();
                return (false);
            }

            if (theForm.price.value == "") {
                alert("Please Enter the Part Price.");
                theForm.price.focus();
                return (false);
            }
            return true;
        }
    </script>
</head>

<body class="font">
    <center>
        <h1><img src="images/gear.png" width=32px> Spare Order System</h1>
    </center>
    <br>
    <ul>
        <li><a href="admin_index.php">Home</a></li>
        <li><a class="active" href="part_info.php">Part Info</a></li>
        <li><a href="order_management.php">Order Management</a></li>
        <li><a href="index.php" onclick="return confirm('Are you sure you want to sign out?')">Log Out</a></li>
    </ul>
    <div id="main">
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return InputFieldValidations(this)">
            <table align="center">

                <?php
                session_start();
                $email = $_SESSION['loginName'];

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    require_once('conn.php');
                    $name = $_POST['partName'];
                    $sql = "INSERT INTO Part(email, partName, stockQuantity, stockPrice, stockStatus) VALUES('$email', '$_POST[partName]', $_POST[qty], $_POST[price], 1)";

                    if (mysqli_query($conn, $sql)) {
                        echo "<script>alert('Record was updated successfully.');</script>";
                        $sql = "SELECT * FROM Part WHERE partName = '$name'";
                        $rs = mysqli_query($conn, $sql);
                        while ($rc = mysqli_fetch_assoc($rs)) {
                            printf(
                                "<script>alert('Result:\\nPart Number: %s\\nPart Name: %s\\nPart Quantity: %s\\nPart Price: %s');window.location.href='part_info.php';</script>",
                                $rc['partNumber'],
                                $rc['partName'],
                                $rc['stockQuantity'],
                                $rc['stockPrice']
                            );
                        }
                        mysqli_free_result($rs);
                        mysqli_close($conn);
                    } else {
                        $sql = "SELECT MAX(partNumber) AS max_number FROM Part ";
                        $rs = mysqli_query($conn, $sql);
                        while ($rc = mysqli_fetch_assoc($rs)) {
                            $sql = "ALTER TABLE Part AUTO_INCREMENT = $rc[max_number]";
                            mysqli_query($conn, $sql);
                        }
                        mysqli_free_result($rs);
                        mysqli_close($conn);
                        echo "<script>alert('Part Name was been used. Please try again');window.location.href='part_add.php';</script>";
                    }
                }
                ?>
                <tr>
                    <th colspan="2" class="text=center">Part Adding</th>
                </tr>
                <tr onmouseover="setColor(true, 'partNumber')" onmouseout="setColor(false,'partNumber')">
                </tr>
                <tr>
                    <td>Part Name</td>
                    <td><input type="text" name="partName"></td>
                </tr>
                <tr>
                    <td>Stock Quantity</td>
                    <td><input type="text" name="qty" pattern="^[\d]*$"></td>
                </tr>
                <tr>
                    <td>Stock Price</td>
                    <td><input type="text" name="price" pattern="^[\d]*$"></td>
                </tr>

            </table>
            <div id="divButton">
                <input type="submit" class="whiteButton" name="add" id="add" value="Add" onclick="return confirm('Are you sure you want to add part?')">
                <input type="button" class="whiteButton" name="cancel" id="cancel" value="Cancel" onclick="window.location.href='part_info.html'">
            </div>
        </form>
    </div>
</body>

</html>