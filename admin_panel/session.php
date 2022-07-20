<?php
	session_start();
	
	if (!isset($_SESSION['id']) ||(trim ($_SESSION['id']) == '')) {
	header("Location:../index.php");
    exit();
	}
	
	include('config.php');

	$sq=mysqli_query($connect_db,"select * from `account` where id='".$_SESSION['id']."'");
	$srow=mysqli_fetch_array($sq);
	
	$user=$srow['username'];
