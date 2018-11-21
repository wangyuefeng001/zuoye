<?php


$user=$_POST['user'];
$password=md5($_POST['password']);

 $dsn = "mysql:host=localhost;dbname=test";
 $db = new PDO($dsn, 'root', 'root');

 $data=$db->query("select * from user where username='$user' && password='$password'")->fetch();
 if($data){
        session_start();
        $_SESSION['user_id']=$data['id'];

    echo "<script>alert('登陆成功，');location.href='huangou.html'</script>";
 }else{
 	echo "<script>alert('用户名或密码错误！请输入正确的用户名和密码');</script>";
 }

