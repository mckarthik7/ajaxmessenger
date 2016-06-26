<html>
	<head>
		<link rel="stylesheet" type="text/css" href="resources/styles/loginStyle.css">
	</head>
	<body>
		<?php
		session_start();
		if(isset($_SESSION['signed_in'])&&$_SESSION['signed_in']==true)
					{
						echo 'You are already signed in! <br><a href="Signout.php"> Sign out!</a>';
					}
				else
				{
					if($_SERVER['REQUEST_METHOD'] != 'POST')
				   {
					   echo
					   '
							<div id="allTheThings">
								<form action="#" method="post">
									<table width="95%" cellspacing="10px">
										<tr>
											<td width="15%" align="right"><img src="resources/images/user_name.png" /></td>
											<td width="100%">
												<input type="text" placeholder="Username" name="user_name" id="user_name" />
											</td>
										</tr>
										<tr>
											<td align="right"><img src="resources/images/user_pass.png" /></td>
											<td>
												<input type="password" placeholder="Password" name="user_pass" id="user_pass" />
											</td>
										</tr>
										<tr>
										<td></td>
											<td align="right">
												<input type="submit" value="LOGIN" id="btn_login"/>
											</td>
										</tr>
									</table>
								</form>
							</div>
						';
				   }
					else
				   {   
						$errors = array();
						if(($_POST['user_name'])=='')
						{
							$errors[] = 'The username field must not be empty.';
						}
						if(($_POST['user_pass'])=='')
						{
							$errors[] = 'The password field must not be empty.';
						}
				 
						if(!empty($errors)) 
						{
							echo 'Uh-oh.. a couple of fields are not filled in correctly..';
							echo '<ul>';
							foreach($errors as $key => $value) 
							{
								echo '<li>' . $value . '</li>';
							}
							echo '</ul>';
						}
						else
						{
							$sql = "SELECT * from users where uname = '" . mysqli_real_escape_string($link,$_POST['user_name']) . "'
							AND
								pass = '" . $_POST['user_pass'] . "'";
							$result = mysqli_query($link,$sql);
							if(!$result)
							{
							   
								echo 'Something went wrong while signing in. Please try again later.';
								//echo mysql_error(); //debugging purposes, uncomment when needed
							}
							else
							{
								if(mysqli_affected_rows($link) == 0)
								{
									echo 'You have supplied a wrong user/password combination. Please try again.';
								}
								else
								{
								   
									 $_SESSION['signed_in'] = true;
									while($row = mysqli_fetch_assoc($result))
									{
										$_SESSION['user_id']    = $row['uid'];
										$_SESSION['user_name']  = $row['uname'];
									}
									echo 'Welcome, ' . $_SESSION['user_name'];
								 }
							}
						}       
					}
				}
				
		?>
	</body>
</html>