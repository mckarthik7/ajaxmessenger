<?php
include 'connect.php';
session_start();
if(isset($_SESSION['signed_in'])&&$_SESSION['signed_in']==true)
            {
                echo 'You are already signed in! <br><a href="Signout.php"> Sign out!</a>';
            }
        else
        {
            if($_SERVER['REQUEST_METHOD'] != 'POST')
           {    echo '<div class="login">
  <div class="heading">    <h2>Sign in</h2><br>';
                echo '<form action="#" method="post">

                <div id="allTheThings2">
      <div class="input-group input-group-lg ">
        <span class="input-group-addon"><i class="fa fa-user"></i></span>
        <input type="text" class="form-control" placeholder="Username" name="user_name">
          </div><br><br>

        <div class="input-group input-group-lg">
          <span class="input-group-addon"><i class="fa fa-lock"></i></span>
          <input type="password" class="form-control" placeholder="Password" name="user_pass">
        </div><br><br>

        <button type="submit" class="float">Login</button>
       </form>
        </div>
        </div>
 </div>'
 ;
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
