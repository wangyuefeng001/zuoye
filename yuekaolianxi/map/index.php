<?php 

$lng=$_POST['lng'];
$lat=$_POST['lat'];
  $url="http://api.map.baidu.com/panorama/v2?ak=oQTMTPdR300DFZtyeUiP8A0HQK8TQx66&width=512&height=256&location=$lng,$lat";
  $str=file_get_contents($url);
 $arr=json_decode($str,true);
 print_r($arr);