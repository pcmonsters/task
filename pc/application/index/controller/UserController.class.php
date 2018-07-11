<?php
//---------------
//Author:pc
//---------------
 
namespace Admin\Controller;
use Think\Controller;
//use Org\Util;
/*
 * 用户管理模块
 */
class UserController extends AdminController{
  //用户列表
  public function index(){
  	//dump($_SESSION);
  	//用户信息与角色信息关联查询 field 并排除password字段
  	$user = D('User')->field('password',true)->relation(true)->select();
    // dump($user);
  	$this->assign('user',$user);
  	$this->display();
  }
  public function homeindex(){
    //用户信息与角色信息关联查询 field 并排除password字段
    $user = D('Member')->field('password',true)->relation(true)->select();
    // dump($user);
    $this->assign('user',$user);
    $this->display();
  }
  
  //添加页面 
  public function add(){
  	//查出来角色
  	$list = M('role')->select();
  	$this->assign('list',$list);
  	$this->display();
  }
  //执行添加用户
  public function doadd(){
  	$user = D('User');
  	if(!$user->create()){
  		$this->error($user->getError());
  		exit;
  	}
    		$uid = $user->add();

  	if($uid){
  	      //用户添加成功后添加用户角色表
  	      $role['role_id'] = I('role_id','','int');
  	      $role['user_id'] = $uid;
  	      M('role_user')->add($role);
  		$this->success("添加成功！",U('User/index'));
  	}else{
  		$this->error("添加失败！");
  	}
  	//echo $user->getLastSql()."<br>";
  }

//删除操作
  public function del(){
    $id = I('param.id','','int');
    $admin = D('user')->where(array('user_id'=>array('eq',$id)))->find();
    if($admin['username'] == 'admin'){
      $this->error('不能删除超管');
    }
    //开启事务
    //把用户角色表中相关的也删除
    M()->startTrans();
    $result = D('user')->where(array('user_id'=>array('eq',$id)))->delete();
    $result = $result1 = true;
    if(!empty($result)){
      $result1 = D('role_user')->where(array('user_id'=>array('eq',$id)))->delete();
    }
    if(!empty($result) && !empty($result1)){
      //提交
      M()->commit();
      $this->success('删除成功');
    }else{
      M()->rollback();
      $this->error('删除失败');
    }
  }

  //加载修改页面
  public function edit(){
    //接收用户id
    $id = I('param.id','','int');
  	//查出数据
  	// $vo = $user->where(array('id'=>array('eq',I('id'))))->find();
  	//向模板分配数据
  	// $this->assign('vo',$vo);
  	//加载模板
  	$this->display();
  }

  //执行修改操作
  public function save(){
  	
    //过滤
    if(!$user->create()){
      $this->error($user->getError());
      exit;
    }
    //执行修改 
    if($user->save() >= 0){
      $this->success("修改成功！",U('User/index'));
    }else{
      $this->error("修改失败");
    }
  } 
}
