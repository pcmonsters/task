<?php

namespace app\index\Controller;
use think\Db;
use \think\Request;
class Task extends Admin{
	public function __construct(){
 		// var_dump('222');
		parent::__construct();
	}
    public function index(){
    	//$projects  = Db::table('project')->select();
    /*	
    	return $this->fetch('index',[
    		'projects'=>$projects,
    	]);
*/
return $this->fetch('index',[
    		'name'=>'thinkphp'
    	]);
    }
    public function projects(){
/*
    	$params = $this->params;
    	$join = [
		    ['project b','a.project_id=b.id'],		    
		];
		$result = DB::table('category')->alias('a')->join('project b','a.project_id=b.id')->field('a.id as category_id,a.name category_name')->select();
		$categorys = array();
		if(count($result)){
			foreach($result as $k=>$value){
				$value['tasks'] = array();
				$categorys[$value['category_id']] = $value;
			}
		}
		$tasks  = Db::table('task')->alias('a')->join($join)->where('b.id',$params['id'])->order('a.`index`')->field('*,a.id as task_id')->select();
		$data_without_categorys = array();
		if(count($tasks)){
			foreach($tasks as $value){
				if(isset($categorys[$value['category_id']])){
					$categorys[$value['category_id']]['tasks'][] = $value;
				}else{
					$data_without_categorys[] = $value;
				}
			}
		}
*/
		return $this->fetch('projects',[
    	]);
    			
    }
    public function add_task(){
    	$params = $this->params;
    	$data = array(
    		'title'=>$params['title'],
    		'project_id'=>$params['project_id'],
    		'index'=>$params['index'],
    	);
    	if(isset($params['category_id'])){
    		$data['category_id'] = $params['category_id'];
    	}
    	
    	$result = Db::name('task')->insert($data);
		$id = Db::name('task')->getLastInsID();
		$data = Db::table('task')->where('id',$id)->find();
		return json_encode($data);
    }
    public function reorder(){
    	$params = $this->params;
    	$task_ids = array();
    	if(count($params['data'])){
	    	$sql = 'update task set `index` = case id';
    		foreach($params['data'] as $value){
    			$sql .= ' when '.$value['task_id'].' then '.$value['index'];
    			$task_ids[] = $value['task_id'];
    		}
	    	$sql .= ' end where id in ('.implode(',',$task_ids).')';
    	}
    	Db::execute($sql);
    	// var_dump($sql);
    	// exit;
    	if(isset($params['recategory']) && count($params['recategory'])){
    		Db::table('task')->where('id', $params['recategory']['task_id'])->update(['category_id' =>$params['recategory']['category_id']]);
    	}

    	// var_dump($params);
    }
    public function detail(){
    	$params = $this->params;
    	$sql = 'select * from task where id=:id limit 1';
    	$task = Db::query($sql,array('id'=>$params['id']));
    	if(count($task)){
    		$task = $task[0];
    	}
    	$result = Db::query('select a.name as person_name,a.id as person_id,a.group,c.name as member_name from person a left join task_person b on a.id=b.person_id and b.task_id=:task_id left join member c on c.id=b.member_id where a.project_id=:project_id',array('project_id'=>1,'task_id'=>$params['id']));
        // dump($result);exit;
        $task_person = array();
        foreach($result as $value){
            $task_person[$value['group']][$value['person_id']][] = $value;
        }
    	dump($task_person);
		return $this->fetch('detail',[
    		'task'=>$task,	
            'task_person'=>$task_person,  
    	]);
    			
    }
    public function save_task_detail(){
        $params = $this->params;
        $data = array(
            'project_id'=>$params['project_id'],
            'code'=>$params['code'],
        );
        
        $sql = 'update task set code=:code where id=:project_id';
        Db::execute($sql);
        return 1;
    }
}
