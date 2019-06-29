<!DOCTYPE html>
<html>

<head>
    <title>Part Information</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon" />
    <link href="css/font.css" rel="stylesheet" type="text/css" />
    <link href="css/index.css" rel="stylesheet" type="text/css" />
    <link href="css/table.css" rel="stylesheet" type="text/css" />
    <link href="css/button.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="js/jquery.min.js"></script>
    <script src="js/jquery.redirect.js"></script>

    <style>
        table {
            width: 80%;
        }

        input[type=text] {
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        div {
            width: auto;
            height: auto;
            text-align: center;
        }

        #headerButton {
            float: left;
            margin-left: 10%;
        }

        .edit,
        .remove {
            padding: 12px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }
    </style>
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
    <br>

    <div>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div id="headerButton">
                <input class="whiteButton" type="button" name="add" id="add" value="+Add" onclick="window.location.href='part_add.php'">
                <input type="text" placeholder="Search Part" name="search" id="search">
                <button type="submit" name="submit"><i class="fa fa-search"></i></button><br><br>

            </div>
            <table align="center">
                <tr>
                    <th>Part Number</th>
                    <th>Part Name</th>
                    <th>Quantity</th>
                    <th>Stock Price</th>
                    <th>Stock Status</th>
                    <th>Last Edit</th>
                    <th>Management</th>
                </tr>
                <?php

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    require_once('conn.php');
                    $sql = "SELECT * FROM Part WHERE partNumber LIKE '%$_POST[search]%' OR partName LIKE '%$_POST[search]%'";
                    $rs = mysqli_query($conn, $sql);
                    while ($rc = mysqli_fetch_assoc($rs)) {
                        $status = "";
                        if ($rc['stockStatus'] == '1') {
                            $status = "Available";
                        } else {
                            $status = "Unavailable";
                        }
                        echo "<tr>
                                <td><a>$rc[partNumber]</a></td>
                                <td>$rc[partName]</td>
                                <td>$rc[stockQuantity]</td>
                                <td>$rc[stockPrice]</td>
                                <td>$status</td>
                                <td>$rc[email]</td>
                                <td><button class='grayButton edit'>Edit</button>
                                <button class='grayButton remove'>Remove</button>
                                </td>
                            </tr>";
                    }
                } else {
                    require_once('conn.php');
                    $sql = "SELECT * FROM Part";
                    $rs = mysqli_query($conn, $sql);

                    while ($rc = mysqli_fetch_assoc($rs)) {

                        $status = "";
                        if ($rc['stockStatus'] == '1') {
                            $status = "Available";
                        } else {
                            $status = "Unavailable";
                        }
                        ?>
                        <tr id="<?php echo $rc['partNumber'] ?>">
                            <td><a><?php echo $rc['partNumber'] ?></a></td>
                            <td><?php echo $rc['partName'] ?></td>
                            <td><?php echo $rc['stockQuantity'] ?></td>
                            <td><?php echo $rc['stockPrice'] ?></td>
                            <td><?php echo $status ?></td>
                            <td><?php echo $rc['email'] ?></td>
                            <td><button class='grayButton edit'>Edit</button>
                                <button class="grayButton remove">Remove</button>
                            </td>
                        </tr>
                    <?php }
                }
                mysqli_free_result($rs);
                mysqli_close($conn); ?>
            </table>
            <br>
        </form>
    </div>
</body>

<script type="text/javascript">
    $(".remove").click(function() {
        var id = $(this).parents("tr").attr("id");
        if (confirm('Are you sure to remove this part?')) {
            $.ajax({
                url: 'remove.php',
                type: 'GET',
                data: {
                    partNumber: id
                },
                error: function() {
                    alert('Something is wrong');
                },
                success: function(data) {
                    alert("Part removed successfully");
                }
            });
        }
    });
</script>
<script>
    $(".edit").click(function() {
        var id = $(this).parents("tr").attr("id");
        if (confirm('Are you sure to edit this part?')) {
            document.location.href = "part_edit.php?partNumber=" + id;
        }
        return false;
    });
</script>

</html>