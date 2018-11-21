<?php 


 
$goods_id=$_POST['goods_id'];
$goods_jifen=$_POST['jifen'];
$dsn = "mysql:host=localhost;dbname=test";
 $db = new PDO($dsn, 'root', 'root');
$sql="update goods set stock=stock-1 where id='$goods_id'";
$db->exec($sql);
session_start();
$user_id=$_SESSION['user_id'];
$sql2="update user set jifen=jifen-'$goods_jifen' where id='$user_id'";
$db->exec($sql2);
 $time=date("Y-m-d");
$sql1="insert into jifen(user_id,goods_id,jifen,addtime) values('$user_id','$goods_id','$goods_jifen','$time')";
if($db->exec($sql1)){
 
	
	echo 'ok';
}else{
    echo "no";
}

	

