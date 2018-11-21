<?php 
$dsn = "mysql:host=localhost;dbname=test";
$db = new PDO($dsn, 'root', 'root');
session_start();
$user_id=$_SESSION['user_id'];
$data=$db->query("select jifen from user where id='$user_id'")->fetch();
$jifen=$data['jifen'];

$arr=$db->query("select * from jifen where user_id='$user_id'")->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<h2>您的总积分：<a href="#"><?php echo $jifen; ?></a>	积分</h2>
	<a href="goods_list.php">去换购页面</a>
	<table border="1">
		<tr>
			<td>id</td>
			<td>用户id</td>
			<td>商品id</td>
			<td>消费积分</td>
			<td>添加时间</td>
		</tr>
		<?php foreach ($arr as $key => $value){ ?>
			<tr>
				<td><?php echo $value['id'];?></td>
				<td><?php echo $value['user_id'];?></td>
				<td><?php echo $value['goods_id'];?></td>
				<td><?php echo $value['jifen'];?></td>
				<td><?php echo $value['addtime'];?></td>
			</tr>
		<?php } ?>
		
	</table>
</body>
</html>

