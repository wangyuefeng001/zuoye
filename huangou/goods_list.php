<?php

$dsn = "mysql:host=localhost;dbname=test";
 $db = new PDO($dsn, 'root', 'root');

 $data=$db->query("select * from goods")->fetchAll();

$arr=$db->query("select jifen from user")->fetch();
$user_jifen=$arr['jifen'];
session_start();
$user_id=$_SESSION['user_id'];
$arr1=$db->query("select * from jifen where user_id='$user_id'")->fetchAll();
$goods_id=array_column($arr1,'goods_id');
$arrUser=array_column($arr1,'user_id');

 ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<title>Document</title>
 </head>
 <body>
 	<h4><a href="jifen.php">积分列表</a></h4>
      <?php foreach($data as $key => $value){?>
      <div style="float:left; margin-left: 100px; ">
      	  <p ><img src="<?php echo $value['pic']; ?>" width="400" height="300"></p>
      	  <p><?php echo $value['name'] ?></p>
      	  <p><?php echo $value['price'] ?><font>积分</font></p>
      	  <?php if(in_array($value['id'],$goods_id) && in_array($user_id,$arrUser)){ ?>
      	  	   <p>已换购</p>
      	  <?php }else{ ?>
                 <p id="huangou<?php echo $value['id'];?>"><a href="javascript:void(0)" onclick="huangou(<?php echo $value['id'];?>,<?php echo  $value['price'];?>)">换购</a></p>
      	  <?php } ?>
      	
      	  </div>
      <?php } ?>
 	
 </body>
 </html>
<script src="jquery.js"></script>
<script>
			function huangou(goods_id,jifen){
                  var user_jifen = <?php echo $user_jifen;?>;
			if(user_jifen < jifen){
				window.confirm('你的积分不够!!! 请换一件商品');
				return;
			}else{
				$.ajax({
					url:'trade_in.php',
					data:{goods_id:goods_id,jifen:jifen},
					type:'post',
					dataType:'text',
					success:function(e){
                         if(e=='ok'){
                         	alert('抢购成功！！');
                             $("#huangou"+goods_id).text('已换购');
                         }else{
                         	alert('抢购失败');
                         	return;
                         }
					}
				})
			}
		}

</script>
