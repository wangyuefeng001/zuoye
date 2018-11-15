<?php  

$username = $_POST['username'];
$password = md5($_POST['password']);
$phone = $_POST['phone'];
$code = $_POST['code'];
//$username = $_POST['username'];
   $redis= new Redis();
   $redis->connect('127.0.0.1',6379);
     $dsn = "mysql:host=localhost;dbname=test";
    $db = new PDO($dsn, 'root', 'root');

if($code == $redis->get('rand')){
	$sql="insert into user(username,password,phone) values('$username','$password','$phone')";
  if($db->exec($sql)) {
  	echo "<script>alert('注册成功');location.href='login.html'</script>";
  }
}else{
	echo "<script>alert('验证码错误！！！');hostry.go(-1);</script>";
}
?>