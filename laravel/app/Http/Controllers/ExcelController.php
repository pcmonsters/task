<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\DB;
class ExcelController extends Controller
{
	private static $bug_level = [
        '1' => '',        
    ];
    //Excel文件导出功能 By Laravel学院
    public function export(){
        $cellData = [
            ['学号','姓名','成绩'],
            ['10001','AAAAA','99'],
            ['10002','BBBBB','92'],
            ['10003','CCCCC','95'],
            ['10004','DDDDD','89'],
            ['10005','EEEEE','96'],
        ];
        Excel::create('学生成绩',function($excel) use ($cellData){
            $excel->sheet('score', function($sheet) use ($cellData){
                $sheet->rows($cellData);
            });
        })->export('xls');
    }
    public function import(){
      
    	

		// $a = DB::insert('insert into admin_account ( name) values (:name)', ['name'=>'12321312']);
		// $a = DB::select('select * from admin_account where id = :id', ['id' => 1]);
		// dd($a);
		ini_set('max_execution_time',0);
		ini_set('memory_limit','2048M');
		$base_dir = 'D:\xampp\htdocs\bugs\\';
		$files = $this->my_dir($base_dir);
		// 
		foreach($files as $key=>$value){
			$time = substr($key,0,strpos($key,'-'));
			$times = explode('.', $time);
			// var_dump($times);
			if(count($times)== 2){
				// var_dump($times);
				$time = date("w", mktime(0,0,0,$times[0],$times[1],'2018'));
				if($time != 5){
					unset($files[$key]);
				}
			}else{
				unset($files[$key]);
			}
			
		}
		// var_dump($files);
		foreach($files as $key=>$value){
			$time = substr($key,0,strpos($key,'-'));
			$times = explode('.', $time);
			$date = date("Y-m-d", mktime(0,0,0,$times[0],$times[1],'2018'));
			// var_dump(strtotime($date) >= strtotime('2018-3-1'));
			if(strtotime($date) >= strtotime('2018-3-1')){
				foreach($value as $val){
					// var_dump(strpos($val,'朱成莲'));
					if(strpos($val,iconv('UTF-8', 'GBK','朱成莲'))>0){
						continue;
					}
					$this->insert_bugs($base_dir.$key.'\\'.$val,$date);
					// exit;
				}
			}
			
		}
    }
    private function my_dir($dir) {
	    $files = array();
	    if(@$handle = opendir($dir)) { //注意这里要加一个@，不然会有warning错误提示：）
	        while(($file = readdir($handle)) !== false) {
	            if($file != ".." && $file != ".") { //排除根目录；
	                if(is_dir($dir."/".$file)) { //如果是子文件夹，就进行递归
	                    $files[$file] = $this->my_dir($dir."/".$file);
	                } else { //不然就将文件的名字存入数组；
	                    $files[] = $file;
	                }
	 
	            }
	        }
	        closedir($handle);
	        return $files;
	    }
	}
	private function insert_bugs($inputFileName,$date){
		$inputFileType = 'Xlsx';
    	$reader = IOFactory::createReader($inputFileType);		
		// $inputFileName = 'D:\xampp\htdocs\bugs\6.29-7.5/'.iconv('UTF-8', 'GBK', 'QA数据收集-研发中心-陶婉婷').'.xlsx';
        // $inputFileName = iconv('UTF-8', 'GBK', 'D:\xampp\htdocs\banma_doc\测试用例\进度报告\6.29-7.5\QA数据收集-研发中心-陶婉婷.xlsx');
        // $inputFileName = 'D:\xampp\htdocs\pc_1\laravel\storage\'.iconv()QA数据收集-研发中心-陶婉婷.xlsx';
        var_dump($inputFileName);
		$sheetnames = ['QA任务细节表'];
		$reader->setLoadSheetsOnly($sheetnames);
		$spreadsheet = $reader->load($inputFileName);
		$sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
		// dd($sheetData);
		unset($sheetData[1]);
		unset($sheetData[2]);
		foreach($sheetData as $key_bug=>$bug){	
  			if(empty($bug['C'])){
  				if(empty($sheetData[$key_bug-1]['C'])){
  					continue;
  				}
  				$sheetData[$key_bug]['C'] = $sheetData[$key_bug-1]['C'];
  				$bug['C'] = $sheetData[$key_bug-1]['C'];
  			}
  			if(empty($bug['A'])){
  				$sheetData[$key_bug]['A'] = $sheetData[$key_bug-1]['A'];
  				$bug['A'] = $sheetData[$key_bug-1]['A'];
  			}
  			$username = [];
  			$username[] = rtrim($bug['C']);
  			$bug['D'] = rtrim($bug['D']);
  			if(strlen(rtrim($bug['D'])) == 0){
  				continue;
  			}
  			$devs = [];
  			if( strpos($bug['D'],'/') ){
  				$devs = explode('/',rtrim($bug['D']));	
  			}elseif( strpos($bug['D'],'、') ){
  				$devs = explode('、',rtrim($bug['D']));	
  			}elseif( strpos($bug['D'],'，') ){
  				$devs = explode('，',rtrim($bug['D']));	
  			}elseif( strpos($bug['D'],' ') ){
  				$devs = explode(' ',rtrim($bug['D']));	
  			}elseif ($bug['D'] == '孙小灵李永丽') {
  				$devs[] = '孙小灵';
  				$devs[] = '李永丽';
  			}elseif ($bug['D'] == '孙小灵甘良栋') {
  				$devs[] = '孙小灵';
  				$devs[] = '甘良栋';
  			}elseif ($bug['D'] == '孙小灵马梦月') {
  				$devs[] = '孙小灵';
  				$devs[] = '马梦月';
  			}elseif ($bug['D'] == '孙文芳张建华刘洋洋') {
  				$devs[] = '孙文芳';
  				$devs[] = '张建华';
  				$devs[] = '刘洋洋';
  			}elseif ($bug['D'] == '孙晨邓华') {
  				$devs[] = '孙晨';
  				$devs[] = '邓华';
  			}elseif ($bug['D'] == '甘良栋孙小灵马梦月') {
  				$devs[] = '甘良栋';
  				$devs[] = '孙小灵';
  				$devs[] = '马梦月';
  			}elseif ($bug['D'] == '邓华孙晨') {
  				$devs[] = '邓华';
  				$devs[] = '孙晨';
  			}elseif ($bug['D'] == '马梦月孙小灵') {
  				$devs[] = '马梦月';
  				$devs[] = '孙小灵';
  			}elseif($bug['D'] == 4 | $bug['D'] == 40 | $bug['D'] == 8 ){
  				continue;
  			}else{
  				$devs[] = $bug['D'];
  			}
  			foreach($devs as $value){
  				$username[] = strval($value);
  			}
  			// var_dump($devs);
  			if(count($devs) == 0){
  				continue;
  			}
  			$find_username = $username;
  			$qa_ids = DB::table('admin_account')
                ->whereIn('username', $username)
                ->get();
  			// $add_data['name'] = $value['A'];
  			foreach($qa_ids as $value){
  				// var_dump(array_search($value->username,$username));
  				unset($username[array_search($value->username,$username)]);
  			}
  			$add = [];
  			foreach($username as $key=>$value){
  				if(empty($value)){
  					unset($username[$key]);
  					continue;
  				}
  				$add[] = ['username'=>$value];
  			}
  			DB::table('admin_account')->insert($add);
  			if(count($username)>0){
	  			$qa_ids = DB::table('admin_account')
	                ->whereIn('username', $find_username)
	                ->get();
  			}
  			$ids  = [];	
  			foreach($qa_ids as $value){
  				// var_dump($value->id);
  				$ids[$value->username] = $value->id;
  			}
  			$add_data = [];
  			// var_dump($bug);

  			if($bug['M']>0){
  				foreach($devs as $value){
  					$add_data_tmp = [];
	  				$add_data_tmp['name'] = strval($bug['A']);
	  				$add_data_tmp['qa_id'] = $ids[$bug['C']];
	  				$add_data_tmp['devs_id'] = $ids[$value];
	  				$add_data_tmp['bug_level'] = 2;
	  				$add_data_tmp['bug_count'] = $bug['M']/count($devs);
	  				$add_data_tmp['bug_env'] = 1;
	  				$add_data_tmp['bug_time'] = $date;
	  				$add_data[] = $add_data_tmp;
	  			}
  			}
  			if($bug['N']>0){
  				foreach($devs as $value){
  					$add_data_tmp = [];
	  				$add_data_tmp['name'] = strval($bug['A']);
	  				$add_data_tmp['qa_id'] = $ids[$bug['C']];
	  				$add_data_tmp['devs_id'] = $ids[$value];
	  				$add_data_tmp['bug_level'] = 3;
	  				$add_data_tmp['bug_count'] = $bug['N']/count($devs);
	  				$add_data_tmp['bug_env'] = 1;
	  				$add_data_tmp['bug_time'] = $date;
	  				$add_data[] = $add_data_tmp;
	  			}
  			}
  			if($bug['O']>0){
  				foreach($devs as $value){
  					$add_data_tmp = [];
	  				$add_data_tmp['name'] = strval($bug['A']);
	  				$add_data_tmp['qa_id'] = $ids[$bug['C']];
	  				$add_data_tmp['devs_id'] = $ids[$value];
	  				$add_data_tmp['bug_level'] = 2;
	  				$add_data_tmp['bug_count'] = $bug['O']/count($devs);
	  				$add_data_tmp['bug_env'] = 2;
	  				$add_data_tmp['bug_time'] = $date;
	  				$add_data[] = $add_data_tmp;
	  			}
  			}
  			if($bug['P']>0){
  				foreach($devs as $value){
  					$add_data_tmp = [];
	  				$add_data_tmp['name'] = strval($bug['A']);
	  				$add_data_tmp['qa_id'] = $ids[$bug['C']];
	  				$add_data_tmp['devs_id'] = $ids[$value];
	  				$add_data_tmp['bug_level'] = 3;
	  				$add_data_tmp['bug_count'] = $bug['P']/count($devs);
	  				$add_data_tmp['bug_env'] = 2;
	  				$add_data_tmp['bug_time'] = $date;
	  				$add_data[] = $add_data_tmp;
	  			}
  			}
  			if($bug['Q']>0){
  				foreach($devs as $value){
  					$add_data_tmp = [];
	  				$add_data_tmp['name'] = strval($bug['A']);
	  				$add_data_tmp['qa_id'] = $ids[$bug['C']];
	  				$add_data_tmp['devs_id'] = $ids[$value];
	  				$add_data_tmp['bug_level'] = 1;
	  				$add_data_tmp['bug_count'] = $bug['Q']/count($devs);
	  				$add_data_tmp['bug_env'] = 3;
	  				$add_data_tmp['bug_time'] = $date;
	  				$add_data[] = $add_data_tmp;
	  			}
  			}
  			if($bug['R']>0){
  				foreach($devs as $value){
  					$add_data_tmp = [];
	  				$add_data_tmp['name'] = strval($bug['A']);
	  				$add_data_tmp['qa_id'] = $ids[$bug['C']];
	  				$add_data_tmp['devs_id'] = $ids[$value];
	  				$add_data_tmp['bug_level'] = 2;
	  				$add_data_tmp['bug_count'] = $bug['R']/count($devs);
	  				$add_data_tmp['bug_env'] = 3;
	  				$add_data_tmp['bug_time'] = $date;
	  				$add_data[] = $add_data_tmp;
	  			}
  			}
  			if($bug['S']>0){
  				foreach($devs as $value){
  					$add_data_tmp = [];
	  				$add_data_tmp['name'] = strval($bug['A']);
	  				// var_dump($bug);
	  				$add_data_tmp['qa_id'] = $ids[$bug['C']];
	  				$add_data_tmp['devs_id'] = $ids[$value];
	  				$add_data_tmp['bug_level'] = 3;
	  				$add_data_tmp['bug_count'] = $bug['S']/count($devs);
	  				$add_data_tmp['bug_env'] = 3;
	  				$add_data_tmp['bug_time'] = $date;
	  				$add_data[] = $add_data_tmp;
	  			}
  			}
  			// var_dump($add_data);
  			DB::table('task_bug')->insert($add_data);
  			// var_dump($bug);

  			// var_dump($username);
			// DB::table('users')->insert(
			    // $add_data
			// );
		}
	}

}
