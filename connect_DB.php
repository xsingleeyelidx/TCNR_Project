<?php
// $server_name = 'sql309.byethost4.com';
// $user_name = 'b4_37846710';
// $password = 'forever0611';
// $db_name = 'b4_37846710_Alice';
$server_name = 'localhost';
$user_name = 'root';
$password = '';
$db_name = 'alice';

// 建立連線
$link = mysqli_connect($server_name,$user_name,$password,$db_name);

// 確認連線
if(!$link){
    die('連線失敗：' . mysqli_connect_error());
}
mysqli_query($link, "set names 'UTF8' "); // 設定編碼
?>