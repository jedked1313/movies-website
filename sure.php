<?php
require_once("config.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Confirm Delete</title>
	<meta charset="utf-8">
    <meta name = "viewport" content = "width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div style="text-align:center;margin:100px 0;">
            <h3 style="padding: 0 0 30px 0;">Are You Sure You Want to Delete Your Account !!</h3>
            <a class="btn btn-primary" href="index.php">Cancel</a>
            <?php 
            $sql = 'SELECT id FROM users WHERE id = '.$_GET['id'];
            $q = $pdo->query($sql);
            $q->setFetchMode(PDO::FETCH_ASSOC);
            $row = $q->fetch();
            ?>
            <a class="btn btn-danger" href="delete_user.php?id=<?php echo $row['id'] ?>">Delete</a>
        </div>
    </div>
</body>
</html>