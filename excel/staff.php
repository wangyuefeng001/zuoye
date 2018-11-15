<?php



  use PhpOffice\PhpSpreadsheet\Spreadsheet;
  use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
  

class staff extends IController
{

    public function reg(){
    $this->redirect('reg');
    }
    public function login(){
    	$this->redirect('login');
    }
    public function login_ok(){
    	   	$username = IReq::get('username');
    	   $password = IReq::get('password');

        $staff = new IModel('admin111');
        $data=$staff->getObj("username='$username' and password=md5('$password')");
        if($data){
        	
        	$ssesion=new ISession;
        	$ssesion->set('username',$username);
            $this->redirect('staff_show',true);
        }else{
        	echo "登录失败";
        }
    }
    public  function reg_ok(){

    	$username = IReq::get('username');
    	$password = IReq::get('password');
    	$relname = IReq::get('relname');
    	$salay = IReq::get('salay');

        $staff = new IModel('staff');
    	$data=[
            'username'=>$username,
            'password'=>md5($password),
            'relname' =>$relname,
            'salay'=>$salay,
            'addtime'=>time(),
    	];
     		
            $staff->setData($data);
           $staff->add();
    } 
    public function staff_show(){  
    	    $redis= new redis();
    	    $redis->connect('127.0.0.1',6379);
    	   $staff = new IModel('staff');
           if(isset($_POST['keyword']) && !empty($_POST['keyword'])){
          // 	echo 111;
                  $keyword=IReq::get('keyword');
                //  echo $keyword;
                  if($redis->exists($keyword)){
                  	  $str=$redis->get($keyword);
                
                  	  $data=json_decode($str,true); 
                  	 // print_r($arr);
                  	  echo 'redis';
                  }else{
                   $data=$staff->query("username like '%$keyword%'");
                   $str=json_encode($data);
                   $redis->set($keyword,$str);
                   echo 'query';
                  }
           }else{
           	//echo 222;
           	  $data=$staff->query();
           }
          // print_r($data);
           $this->setRenderData(['data'=>$data]);
           $this->redirect('staff_show');
    }
    public function empload(){
         require 'plugins/vendor/autoload.php';
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', '员工薪资登记表');
		   $staff = new IModel('staff');
           $data=$staff->query();
            $spreadsheet->getActiveSheet()
            ->fromArray(
	        $data,  // The data to set
	        NULL,        // Array values with this value will not be set
	        'A3'         // Top left coordinate of the worksheet range where
	                     //    we want to set these values (default is A1)
    );
        $sheet->setTitle('员工工薪详情');
		$writer = new Xlsx($spreadsheet);
		$writer->save('public/员工薪资表.xlsx');
		$data=[
		   'username'=>ISession::get('username'),
		   'ip'=>$_SERVER['REMOTE_ADDR'],
		   'addtime'=>time(),
		];
		 $log = new IModel('log');
		   $log->setData($data);
                $log->add();
		
    }
    public function impload(){
    	    require 'plugins/vendor/autoload.php';
    	    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
			$reader->setReadDataOnly(TRUE);
			$spreadsheet = $reader->load("public\员工薪资表.xlsx");

			$worksheet = $spreadsheet->getActiveSheet();
			// Get the highest row number and column letter referenced in the worksheet
			$highestRow = $worksheet->getHighestRow(); // e.g. 10
			$highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
			// Increment the highest column letter
			$highestColumn++;
              $staff = new IModel('staff');
			for ($row = 3; $row <= $highestRow; ++$row) {
			    for ($col = 'A'; $col != $highestColumn; ++$col) {
			            $data[$row+3][]=$worksheet->getCell($col . $row)
			                 ->getValue();
			    }
			}
			foreach ($data as $key => $value) { 
				$arr=[
                   'username'=>$value[1],
                   'password'=>$value[2],
                   'relname'=>$value[3],
                   'salay'=>$value[4],
                   'addtime'=>$value[5],
				];
                $staff->setData($arr);
                $staff->add();
			}


    }
}