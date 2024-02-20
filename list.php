<?php

require_once "config.php";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>User List</title>
        <link rel="stylesheet" href="css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <style>
            body{ font:14px sans-serif;}
            .wrapper {width :360px; padding : 20px;}
        </style>
    </head>
    <body class="container">
        <h1 style="margin:50px 0 20px">Users List</h1>
        <table class="table">
            <tr>
                <th>Update</th>
                <th>Delete</th>
                <th>User Name</th>
                <th>Email</th>
                <!-- <th>User Pic</th> -->
            </tr>
            <?php
                $stmt = $pdo->query("SELECT * FROM users");
                while ($row = $stmt->fetch()){ ?>
                <tr>
                    <td><a href="update.php?id=<?php echo $row['id'] ?>">Update</a></td>
                    <td><a href="delete.php?id=<?php echo $row['id'] ?>">Delete</a></td>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <!-- <td><img src="<?php/* echo $row['user_img'];*/ ?>" width="150" height="150" style="border-radius:50%;" alt=""></td> -->
                </tr>
            <?php
                }
            ?>
        </table>
    </body>
</html>