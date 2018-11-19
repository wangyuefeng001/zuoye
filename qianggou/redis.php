<?php 


$redis=new Redis();
$redis->connect('127.0.0.1',6379);
 $dsn = "mysql:host=localhost;dbname=test";
$db = new PDO($dsn, 'root', 'root');
 $data=$db->query("select * from goods")->fetchAll(PDO::FETCH_ASSOC);


 foreach ($data as $key => $value) {
 	for($i=1;$i<=$value['stock'];$i++){
 		$redis->lpush('goods'.$value['id'],$i);
 	}
 }