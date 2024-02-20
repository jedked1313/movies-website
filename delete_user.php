<?php
require_once("config.php");
$pdo_statement=$pdo->prepare("delete from users where id=" . $_GET['id']);
$pdo_statement->execute();
header('location:logout.php');
?>
