<?php 

$id=$_GET['id'];
/*var_dump($id);die;*/
$redis=new Redis();
$redis->connect('127.0.0.1',6379);
$dsn = "mysql:host=localhost;dbname=test";
$db = new PDO($dsn, 'root', 'root'); 
$key= 'goods'.$id;
if($redis->llen($key)>0){
	$redis->lpop($key);
	$sql="update goods set stock=stock-1 where id=$id";
	$order_id=date('Y-m-d',time()).md5(rand(100,999));
	$addtime=time();
	$sql1="insert into ding(order_id,addtime) values('$order_id','$addtime')";
	echo $sql1;
	if($db->exec($sql)){
		$db->exec($sql1);
		echo json_encode(['code'=>1,'id'=>$id,'mes'=>'秒杀成功！！！']);
	}
}else{
	echo json_encode(['code'=>0,'id'=>$id,'mes'=>'秒杀结束！！！']);
}

?>