<?php
$username = $_POST['username'];
$password = md5($_POST['password']);
/*$phone = $_POST['phone'];
$code = $_POST['code'];
*/
   $redis= new Redis();
   $redis->connect('127.0.0.1',6379);
     $dsn = "mysql:host=localhost;dbname=test";
    $db = new PDO($dsn, 'root', 'root');

   
   $data=$db->query("select * from user where username='$username' && password='$password'")->fetchAll();
   if($data){
   	  echo '登陆成功';
   }else{
   	  echo '登录失败';
   }
?>