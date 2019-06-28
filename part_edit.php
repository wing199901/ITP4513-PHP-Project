<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Part Editing</title>
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
    </script>
</head>

<body class="font">
    <center>
        <h1><img src="images/gear.png" width=32px> Spare Order System</h1>
    </center>
    <br>
    <ul>
        <li><a href="admin_index.html">Home</a></li>
        <li><a class="active" href="part_info.php">Part Info</a></li>
        <li><a href="order_management.html">Order Management</a></li>
        <li><a href="index.html" onclick="return confirm('Are you sure you want to sign out?')">Log Out</a></li>
    </ul>
    <div id="main">
        <form method="POST" action="$_SERVER[PHP_SELF]">
            <table align="center">
                <tr>
                    <th colspan="2" class="text=center">Part Editing</th>
                <tr onmouseover="setColor(true, 'partNumber')" onmouseout="setColor(false,'partNumber')">
                    <td>Part Number</td>
                    <td><input type="text" name="partNumber" id="partNumber" readonly="readonly" value="100001"
                            disabled>
                    </td>
                </tr>
                <tr onmouseover="setColor(true, 'partName')" onmouseout="setColor(false,'partName')">
                    <td>Part Name</td>
                    <td><input type="text" name="partName" id="partName" value="part01" readonly="readonly" disabled></td>
                </tr>
                <tr>
                    <td>Stock Quantity</td>
                    <td><input type="text" name="qty" value="2000"></td>
                </tr>
                <tr>
                    <td>Stock Price</td>
                    <td><input type="text" name="price" value="$10"></td>
                </tr>

            </table>
            <div id="divButton">
                <input type="submit" class="whiteButton" name="edit" id="edit" value="Edit" onclick="return confirm('Are you sure you want to edit part?')">
                <input type="button" class="whiteButton" name="cancel" id="cancel" value="Cancel"
                    onclick="window.location.href='part_info.html'">
            </div>
        </form>
    </div>
</body>

</html>