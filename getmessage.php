<?php
include 'connect.php';
session_start();
$uid=$_SESSION['user_id'];
$fromuid=$_SESSION['touid'];
$sql="SELECT * FROM message where uid=$fromuid and touid=$uid order by TIMESTAMP";
$result=mysqli_query($link,$sql);
if($result&&mysqli_affected_rows($link)>0)
{
	while($row=mysqli_fetch_assoc($result))
	{
		echo "<div class=sent>Received :".$row['message']."</div>";
	}
	$sqlq="DELETE FROM message where uid=$fromuid and touid=$uid";
	$result2=mysqli_query($link,$sqlq);
	
}

?>