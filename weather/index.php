<?php 
$redis = new Redis();
$redis->connect('127.0.0.1',6379);
$search = $_GET['search'];

if($redis->exists($search)){
	$str = $redis->get($search);
	//var_dump($str);
	echo $str;
}else{

	$key="2f369a5a14a940d28a7a5c2e84a63f17";
	$url="https://free-api.heweather.com/s6/weather/forecast?location=$search&key=$key";
	$ch = curl_init();
	//设置选项，包括URL
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
	//执行并获取HTML文档内容
	$output=curl_exec($ch);
	//释放curl句柄
	curl_close($ch);
	
	//打印获得的数据
//print_r($output);
	$data=json_decode($output,true);
	$arr=$data['HeWeather6'][0]['daily_forecast'];
	// echo "<pre/>";
	// var_dump($arr);die;
	
	$dsn = "mysql:host=localhost;dbname=test";
	$db = new PDO($dsn, 'root', 'root');
	$sql="insert into weather(date,tem_max,tem_min,city) values";
	foreach ($arr as $key => $value) {
		$sql.="('{$value['date']}','{$value['tmp_max']}','{$value['tmp_min']}','$search'),";
	}
	$sql=substr($sql,0,-1);
	$db->exec($sql);
	$str=json_encode($arr);
	//print_r($str);
	//$str=json_decode($str);

	$redis->set($search,$str);
	echo $str;
	//echo 'db';
}



