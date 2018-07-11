<?php
/*
	Author:pc;
*/ 
namespace Admin\Widget;
use Think\Controller;
class CateWidget extends Controller{
	//后台左侧导航，动态显示
	public function nav(){
		//超级管理员
		if(session(C('ADMIN_AUTH_KEY'))){
			$node = D('node')->where('level=2')->order('sort')->relation(true)->select();
			//dump($node);
		 }else{
		 	//取出所有权限节点
			$node = D('node')->where('level=2')->order('sort')->relation(true)->select();
			//dump($node);
			//取出当前登录用户所有模块权限（英文名称）和操作权限
			$module = '';
			$node_id ='';
			//用户允许的权限
			$accessList = $_SESSION['_ACCESS_LIST'];
			foreach($accessList as $key=>$value ){
				foreach($value as $key1=>$value1 ){
					//拿到模块权限
					$module = $module.','.$key1;
					foreach($value1 as $key2=>$value2){
						//拿到操作权限
						$node_id = $node_id.','.$value2;
					}
				}
			}
			//去除没有的权限
			foreach($node as $key=>$value){
				if(!in_array(strtoupper($value['name']), explode(',',$module))){
					//删除没有模块
					unset($node[$key]);
				}else{
					//模块存在，比较里面的操作
					foreach($value['node'] as $key1=>$value1){
						// dump($node[$key]['node'][$key1]);
						if(!in_array($value1['id'], explode(',',$node_id))){
							unset($node[$key]['node'][$key1]);
						}
					}
				}
			}
			
		 }
		$controller = CONTROLLER_NAME;
		// dump($controller);
		// dump($node); 
		
		$this->assign('controller',$controller);
		$this->assign('node',$node);
		$this->display('Cate/nav');
	}
	public function breadcrumb(){
		//获得当前模块，操作名
		$controller = CONTROLLER_NAME;
		$action = ACTION_NAME;
		//从权限表中查出title
		$node['controller'] = D('node')->where(array('name'=>array('eq',$controller),'level'=>array('eq',2)))->field('id,name,title')->find();
		$map['name'] = array(array('eq',$action));
		$map['pid'] = array(array('eq',$node['controller']['id']));
		$node['action'] = D('node')->where($map)->field('name,title')->find();
		// dump($node);
		$this->assign('node',$node);
		$this->display('Cate/breadcrumb');
	}
}