<?php

// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
include "config.php";

$sql = 'select * from movies' ;

$q = $pdo->query($sql);
$q->setFetchMode(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>EgyBest</title>
	<meta charset="utf-8">
    <meta name = "viewport" content = "width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
	<link rel="stylesheet" type="text/css" href="css/bootstrap-grid.min.css">
	<link rel="stylesheet" type="text/css" href="css/main_Style.css">
	<link rel="stylesheet" type="text/css" href="css/Normalize.css">
</head>
<body>

<!--Start Header-->
<div class="navbar">
	<div class="container">
		<h2><span>Egy</span>Best</h2>
		<ul>
			<li><a href="#" class="Home">Home</a></li>
			<li><a href="#">Movies</a></li>
			<li><a href="#">Anime</a></li>
			<li><a href="#">Series</a></li>
			<li><input type="text" placeholder="Search..." alt="Search" herf=""><a href=""><img src="icons/search_icon.png"></a></li>
			<li><a href="logout.php" class="Home">Log Out</a></li>
		</ul>
	</div>
</div>
<!--end Header-->

<!--Start of Content-->
<div class="container">
	<div class="row">
		<ul class="options">
			<a href="#" class="options_a"><li>Action</li></a>
			<a href="#" class="options_a"><li>Comedy</li></a>
			<a href="#" class="options_a"><li>Horror</li></a>
			<a href="#" class="options_a"><li>Mystery</li></a>
			<a href="#" class="options_a"><li>Cartoon</li></a>
			<a href="#" class="options_a"><li>Drama</li></a>
		</ul>
	</div>
	<div class="row table">
		<?php while ($row = $q->fetch()):?>
		<div class="col-3 data">
			<a href="movie.php?movie_num=<?php echo $row['movie_num'] ?>"><img src="<?php echo ($row["movie_img"]); ?>" width="220" height="250"><?php echo ($row["movie_name"]); ?></a>
		</div>
		<?php endwhile;?>
	</div>
</div>
<!--end of Content-->

<!--Start of Footer-->
<footer>
	<div class="container">
		<div class="container_small">
			<div class="footer">
				<ul>
					<li><h3>USER ACCOUNT</h3></li>
					<li><b><a href="reset-password.php">Reset Password</a></b></li>
					<?php
					$stmt = $pdo->query("SELECT * FROM users");
					$row = $stmt->fetch(); ?>
					<tr>
					<li><b><a href="update.php?id=<?php echo $row['id'] ?>">Update User Info</a></b></li>
					<li><b><a href="sure.php?id=<?php echo $row['id'] ?>">Delete Account</a></b></li>
					<li><b><a href="list.php">Users List</a></b></li>
					<li><a href="#">Mobile</a></li>
					<li><a href="#">App Showcase</a></li>
					<li><a href="#">Download</a></li>
				</ul>
				<ul>
					<li><h3>Movies</h3></li>
					<li><b><a href="movies_list.php">Movies List</a></b></li>
					<li><b><a href="add_movie.php">Add a movie</a></b></li>
					<li><a href="#">Nows</a></li>
					<li><a href="#">Press Releases</a></li>
					<li><a href="#">Jops</a></li>
					<li><a href="#">Contact Us</a></li>
				</ul>
				<ul>
					<li><h3>LEARN MORE</h3></li>
					<li><a href="#">Suppert</a></li>
					<li><a href="#">Developers</a></li>
					<li><a href="#">Referral Program</a></li>
					<li><a href="#">Affilate Program</a></li>
					<li><a href="#">Reseller Program</a></li>
					<li><a href="#">Folder Sharing FAQ</a></li>
				</ul>
				<ul>
					<li><h3>CONNECT WITH US</h3></li>
					<li><a href="#"><img src="icons/facebook.jpg">Facebook</a></li>
					<li><a href="#"><img src="icons/Google-plus-circle-icon-png.png">Google+</a></li>
					<li><a href="#"><img src="icons/social-linkedin-circle-512.png">Linkedin</a></li>
				</ul>
				<ul>
					<li><h3 style="visibility: hidden;">`</h3></li>
					<li><a href="#"><img src="icons/twitter-1865886-1581902.png">Twitter</a></li>
					<li><a href="#"><img src="icons/youtube.jpg">Youtube</a></li>
					<li><a href="#"><img src="icons/blog.png">Blog</a></li>
				</ul>
			</div>
		</div>
	</div>
</footer>
<!--End of Footer-->
</body>
</html>
