<?php

include 'connect.php';
session_start();
$uid=$_SESSION['user_id'];
$sql="SELECT * FROM history JOIN users WHERE users.uid=history.touid and history.uid= $uid";
$result=mysqli_query($link,$sql);
if($result)
{
	echo 'Recent Conversations <br>';
	while($row=mysqli_fetch_assoc($result))
	echo "<a href=converse.php?touid='".$row['touid']."'>".$row['uname'].'</a><br>';
}
$sql="SELECT * FROM users where uid!=$uid";
$result=mysqli_query($link,$sql);
if($result)
{
	echo 'Create New Conversation <br>';
	while($row=mysqli_fetch_assoc($result))
	echo "<a href=converse.php?touid='".$row['uid']."'>".$row['uname'].'</a><br>';
}

?>