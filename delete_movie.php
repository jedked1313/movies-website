<?php

require_once("config.php");
$pdo_statement=$pdo->prepare("delete from movies where movie_num=" . $_GET['movie_num']);
$pdo_statement->execute();
header('location:movies_list.php');

?>