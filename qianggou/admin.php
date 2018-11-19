<?php  

 $dsn = "mysql:host=localhost;dbname=test";
 $db = new PDO($dsn, 'root', 'root');
 $data=$db->query("select * from goods")->fetchAll(PDO::FETCH_ASSOC);

 foreach ($data as $key => $value) {

 	$startTtime =time();
   // echo $startTtime;
 	$endTime = $value['endtime'];

    $shengTime = $endTime-$startTtime;
     //echo $shengTime;
    $hour=floor($shengTime/3600);

    $minute=floor(($shengTime-$hour*3600)/60);

    $fius=$shengTime-$hour*3600-$minute*60;

    $data[$key]['hour'] = $hour;
    $data[$key]['minute'] = $minute;
    $data[$key]['fius'] = $fius;
 }
echo json_encode($data);