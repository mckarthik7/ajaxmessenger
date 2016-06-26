<?php
$server = 'localhost';
$username   = 'root';
$password   = 'kthik123';
$database   = 'ajaxdb';
 
if(!($link=mysqli_connect($server, $username,  $password)))
{
    exit('Error: could not establish database connection');
}
if(!mysqli_select_db($link, $database))
{
    exit('Error: could not select the database');
}
global $link;
?>

