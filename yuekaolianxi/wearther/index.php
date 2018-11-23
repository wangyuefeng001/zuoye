<?php 
$search=$_POST['search'];
$key="2f369a5a14a940d28a7a5c2e84a63f17";
$url="https://free-api.heweather.com/s6/weather/forecast?location=$search&key=$key";
$ch = curl_init();
//设置选项，包括URL
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
//ssl_verifyoeer

$output = curl_exec($ch);
//释放curl句柄
curl_close($ch);
//打印获得的数据
$arr = json_decode($output,true);
$data=$arr['HeWeather6'][0]['daily_forecast'];


echo json_encode($data);