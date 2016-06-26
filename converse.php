<?php
include 'connect.php';
session_start();
$uid=$_SESSION['user_id'];
$touid=$_REQUEST['touid'];
$_SESSION['touid']=$touid;
//Load previous messages for now
$sql="SELECT * FROM chat where uid= $uid and touid= $touid order by TIMESTAMP";
$result=mysqli_query($link,$sql);
$sqlq="SELECT * FROM chat where uid=$touid and touid=$uid order by TIMESTAMP";
$result2=mysqli_query($link,$sqlq);
$num=mysqli_num_rows($result);
$num2=mysqli_num_rows($result2);
$sentmessages=array_fill(0, $num, "Hi");				//initialise array filled with 'Hi' will contain sent messages
$receivedmessages=array_fill(0, $num2, "Hey");			//initialise array filled with 'Hey' will contain received messages
$i=0;
$j=0;
if($result)
	while($row=mysqli_fetch_assoc($result))
			$sentmessages[$i++]=$row;					////Got all sent messages
$i=0;		
if($result2)
	while($row=mysqli_fetch_assoc($result2))
			$receivedmessages[$i++]=$row;				////Got all received messages

/**
*Echo all messages in order
*/
$i=0;$j=0;
while($i<$num||$j<$num2)
{

	if($i<$num&&$j<$num2)																	//Both messages left
	{
		if($sentmessages[$i]['TIMESTAMP']<$receivedmessages[$j]['TIMESTAMP'])				//sent is older
			{
				echo "<div class=sent>Sent :".$sentmessages[$i]['message']."</div>";
				$i++;
			}		
		else if($sentmessages[$i]['TIMESTAMP']>$receivedmessages[$j]['TIMESTAMP'])			//Received is older
			{
				echo "<div class=received>Received :".$receivedmessages[$j]['message']."</div>";
				$j++;
			}
	
	}
	else if($i<$num)																		//Received messages over
	{
		echo "<div class=sent>Sent :".$sentmessages[$i]['message']."</div>";
		$i++;
	}
	else if($j<$num2)																		//Sent Messages over
	{
		echo "<div class=received>Received :".$receivedmessages[$j]['message']."</div>";
		$j++;
	}
}

/**
*Echo those messages which havent been read by receiver
*/
$sql="SELECT * FROM message where uid=$uid and touid=$touid";
$result=mysqli_query($link,$sql);
if($result)
	while($row=mysqli_fetch_assoc($result))
		echo "<div class='sent' class='unread'>Sent:".$row['message']."</div>";

/**
*Echo the form for calling ajax function
*/

echo "<div id='newmessage'>
		<input type ='text' id='message'>
	  	<input type='Submit' id='submit'>
	  </div>
	";			


?>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		setInterval(update,1000);
	});
	function update()
	{
		$.ajax({
		url:'getmessage.php',
		success:function(data){
			$("#newmessage").before(data);
		}
	});
	}


	$('#submit').click(function(){
		alert('submit clciked');
		var message=$('#message').val();
		var datastr="message="+message;
		$.ajax(
		{
			type:'post',
			url:'sendmessage.php',
			data:datastr,
			success:function(data){
			$('#newmessage').before("<div class=sent>Sent:"+message+"</div>");
			}
		});
	});

</script>