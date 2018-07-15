<?php

namespace app\index\controller;
use think\Db;
use \think\Request;
// use index\controller\Admin;
class Index extends Admin{
    public function index(){
    	// echo '111';exit;
    	return $this->fetch('index',[
    		'name'=>'thinkphp'
    	]);
    }
    public function getSchedule(){
    	$params = $this->params;
    	// var_dump($params);
    	$sql = 'select * from qa_scedule where date >=:start_date and date<=:end_date';
    	$result = Db::query($sql,array('start_date'=>$params['start'],'end_date'=>$params['end']));
    	// $tasks  = Db::table('qa_scedule')->alias('a')->where('b.id',$params['id'])->order('a.`index`')->field('*,a.id as task_id')->select();
    	return $result;
    }
    public function test(){
    	$a = ['陶婉婷','袁沐烨','朱玉柱','刘廷廷','杨娜','严欣悦','王明娅'];
    	$start = '2018-06-24';
    	$sql = 'insert into qa_scedule(title,date) values';	
    	for($count=0;$count<=10;$count++){
    		// var_dump($a);
	    	for($i = 1;$i<=7;$i++){
	    		// var_dump($start);
	    		$date = date('Y-m-d',strtotime("$start +1 day"));
	    		// var_dump($date);
	    		$start = $date;
	    		$title = $a[$i-1];
	    		// var_dump($title);
	    		$sql .= '("'.$title.'","'.$date.'"),';
	    	}
	    	
			array_push($a,array_shift($a));
    	}
    	var_dump($sql);
    	$sql = rtrim($sql,',');
    	Db::query($sql);
    }
    public function bug(){
        return $this->fetch('bug',[
            
        ]);
    }
    public function getBug(){
        // $params = $this->params;
        // var_dump($params);
        $sql = "SELECT    DATE_FORMAT(bug_time, '%Y%m') months,    count(bug_count) count,bug_env FROM    task_bug WHERE  
    bug_time <= '2018-07-01' GROUP BY    bug_env,months";
        $result = Db::query($sql);
        $data['categories'] = ['3月','4月','5月','6月'];
        foreach($result as $value){
            // $data['categories'][] = $value['months'];
            if($value['bug_env'] == 1){
                $data['data_dev'][] = $value['count'];
            }elseif($value['bug_env'] == 2){
                $data['data_all'][] = $value['count'];
            }elseif($value['bug_env'] == 3){
                $data['data_product'][] = $value['count'];
            }
        }
        
        // $tasks  = Db::table('qa_scedule')->alias('a')->where('b.id',$params['id'])->order('a.`index`')->field('*,a.id as task_id')->select();
        return $data;
    }
}
