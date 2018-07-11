<?php
//---------------
//Author:pc 
//---------------

namespace Admin\Controller;
use Think\Controller;
// use Org\Util;
 
/*
 * 节点管理模块
 */
class NodeController extends AdminController{
  public function index(){
    $node = D('Node');
    //返回分类树
    $list = $node->getTree();
    $this->assign('list',$list);
    $this->display();
  }
  public function add(){
  	$node = D('Node');
  	$nodeList = $node->where('level!=3')->order('sort')->select();
    $nodeList = \Org\Util\Tree::create($nodeList);
    $this->assign('nodeList',$nodeList);
	  $this->display('Node/add');
  }
	//执行添加节点
  public function doadd(){
  	$node = D('Node');
    if(!$node->create()){
    	$this->error($node->getError());
    	exit;
  	} 
  	if($node->add() > 0){
  		$this->success("添加成功！",U('Node/index'));
  	}else{
  		$this->error("添加失败！");
  	}
  }
  //删除权限
  public function deleteNode(){
    $node = D('Node');
    if($node->where('id='.I('id','',int))->delete() > 0){
        $this->success("删除成功！",U('Node/index'));
    }else{
        $this->error("删除失败！");
    }

  }
}
