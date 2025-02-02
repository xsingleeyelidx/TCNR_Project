<?php
// $server_name = 'sql309.byethost4.com';
// $user_name = 'b4_37846710';
// $password = 'forever0611';
// $db_name = 'b4_37846710_Alice';
$server_name = 'localhost';
$user_name = 'root';
$password = '';
$db_name = 'alice';

$link = mysqli_connect($server_name,$user_name,$password,$db_name)
        or die("Can not open MySQL database!<br/>");
        
mysqli_query($link, "set names 'UTF8' ");
?>