<?php
include 'connect.php';
session_start();

$uid=$_SESSION['user_id'];
$touid=$_SESSION['touid'];
$message=mysqli_real_escape_string($link,$_POST['message']);

$sql="insert into message values ($uid,$touid,CURRENT_TIMESTAMP,'$message')";
$result=mysqli_query($link,$sql);
if($result)
	{
		echo 'success!';

	}
else
	{
		echo 'failure';
	}



?>