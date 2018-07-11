<?php
//---------------
//Author:pc
//---------------
 
namespace Admin\Controller;
use Think\Controller;

/*
 * 角色模块
 */
class RoleController extends AdminController{
  public function index(){
    //查询数据
    $list = M('role')->where('type=0')->select();
    $homeList = M('role')->where('type=1')->select();
    //分配变量
    $this->assign("list",$list);
    $this->assign('homeList',$homeList);
    $this->display('Role/index');
  }
  /*//ajax返回前台角色列表
  public function findHomeRole(){
    $map['type'] = I('param.type');
    $data['homeList'] = M('role')->where($map)->select();
    $this->ajaxReturn($data);
  }*/
  public function add(){
    $this->display('Role/add');
  }
  //执行添加操作
  public function doadd(){
  	$role = D('role'); 
  	if(!$role->create()){
  		$this->error($role->getError());
  		exit;
  	}

  	if($role->add() > 0){
  		$this->success("添加成功！",U('Role/index'));
  	}else{
  		$this->error("添加失败！");
  	}
  }
	//分配权限
  public function access(){
  	if(empty($_GET['rid'])){
  		$this->redirect('Role/index');
  	}
      //接受角色ID
      $role_id = I('rid','',int);
      $role = M('Role');
      //查出角色信息
      $users = M('Role')->where(array('id'=>array('eq',$role_id),'status'=>array('eq',1)))->find();
      //查出节点信息
      $node = M('node')->order('sort')->select();
      import('Org.Util.Tree');
      $tree = new \Org\Util\Tree();
      $node = $tree::create($node);
      //存放最新数组，里面包含当前用户组是否有每一个权限
      $data = array();
      $access = M('access');
      //遍历权限信息
      foreach($node as $value){
      	$count = $access->where(array('role_id'=>array('eq',$role_id),'node_id'=>array('eq',$value['id'])))->count();
      	if($count){
      		$value['access'] = 1; //表示有权限
      	}else{
      		$value['access'] = 0;
      	}
      	$data[] = $value;
      }

      $this->assign('users',$users);
      $this->assign('nodelist',$data);
      $this->display();
  }
  //添加角色-权限表(节点表)
  public function setAccess(){
  	$role_id = I('role_id','',int);
  	//清除当前角色所有的信息，避免重复添加
  	$access = M('access');
  	$access->where(array('role_id'=>array('eq',$role_id)))->delete();
  	if(isset($_POST['access'])){
  		//access 权限id+ level值
  		$data = array();
  		foreach($_POST['access'] as $value){
  			//查分成数组
  			$tmp = explode('_',$value);
  			$data[]=array(
  				'role_id'=>$role_id,
  				'node_id'=>$tmp[0],
  				'level'=>$tmp[1],
  			);
  		}
  		if($access->addAll($data)){
  			$this->success('添加成功',U('User/index'));
  		}else{
  			$this->error('修改失败');
  		}
  	}else{
  		$this->error('修改失败');
  	}
  }
  //后台用户选择角色页
  public function role(){
    //接收用户id
    $id = I('param.id','','int');
    if(empty($id)){
      $this->redirect('Role/index');
    }
    //查出用户信息
    $user = M('user')->where(array('user_id'=>array('eq',$id)))->field('user_id,username')->find();
    //根据前台后台角色显示
    $roleList = M('role')->field('id,name,status,type,remark,pid')->order('type')->select();
    //若有，查出现在的角色
    $role = M('role_user')->where(array('user_id'=>array('eq',$id)))->join('yy_role on yy_role.id=yy_role_user.role_id')->select();
    // dump($role);
    $this->assign('role',$role);
    $this->assign('user',$user);
    $this->assign('roleList',$roleList);
    $this->display();
  }
  //前台用户选择角色也
  public function homerole(){
    //接收用户id
    $id = I('param.id','','int');
    if(empty($id)){
      $this->redirect('Role/index');
    }
    //查出用户信息
    $user = M('member')->where(array('user_id'=>array('eq',$id)))->field('user_id,username')->find();
    //根据前台后台角色显示
    $roleList = M('role')->field('id,name,status,type,remark,pid')->order('type')->select();
    //若有，查出现在的角色
    $role = M('home_role_user')->where(array('user_id'=>array('eq',$id)))->join('yy_role on yy_role.id=yy_home_role_user.role_id')->select();
    // dump($role);
    $this->assign('role',$role);
    $this->assign('user',$user);
    $this->assign('roleList',$roleList);
    $this->display();
  }
  //执行分组添加
  public function setRole(){
    //接收用户id
    $user_id = I('param.user_id','','int');
    $role_id = I('param.role_id','','int');
    if(empty($user_id) || empty($role_id)){
      $this->redirect('User/index');
    }
    
    //因为用户和角色多对多，新增
    $data['user_id'] = $user_id;
    $data['role_id'] = $role_id;
    $result1 = M('role_user')->add($data);
    if($result1){
      $this->success('设置成功',U('User/index'));
    }else{
      $this->error('设置失败');
    }
  }
  //执行分组添加
  public function setHomeRole(){
    //接收用户id
    $user_id = I('param.user_id','','int');
    $role_id = I('param.role_id','','int');
    if(empty($user_id) || empty($role_id)){
      $this->redirect('User/index');
    }
    
    //因为用户和角色多对多，新增
    $data['user_id'] = $user_id;
    $data['role_id'] = $role_id;
    $result1 = M('home_role_user')->add($data);
    if($result1){
      $this->success('设置成功',U('User/homeindex'));
    }else{
      $this->error('设置失败');
    }
  }
  //删除用户的分组
  public function deleteRole(){
    //接收用户id
    $user_id = I('param.user_id','','int');
    $role_id = I('param.role_id','','int');
    //分组删除
    $result = M('role_user')->where(array('user_id'=>array('eq',$user_id),'role_id'=>array('eq',$role_id)))->delete();
    if($result){
      $this->success('删除角色成功');
    }else{
      $this->error('删除角色失败');
    }
  } 
  //ajax 删除用户分组
  public function ajaxDelRole(){
    //接收用户id
    $user_id = I('param.user_id','','int');
    $role_id = I('param.role_id','','int');
    //分组删除
    $result = M('role_user')->where(array('user_id'=>array('eq',$user_id),'role_id'=>array('eq',$role_id)))->delete();
    $this->ajaxReturn($result);
  }
  //ajax更改组名
  public function saveRoleName(){
    $id = I('param.id');
    //要更改的值
    $newName = I('param.newName');
    $data['name'] = $newName;
    $result = M('role')->where(array('id'=>array('eq',$id)))->save($data);
    if($result > 0){
      $newId = M('role')->where(array('id'=>array('eq',$id)))->field('id')->find();
      $newId = $newId['id'];
    }else{
      $newId = ''; 
    }
    // echo $a = M()->getLastSql();
    $this->ajaxReturn($newId);
  }
  //ajax 更改状态
  public function saveRoleStatus(){
    //接收组id
    $id = I('param.id');
    $status = I('param.status');
    $newStatus = I('param.newStatus')=='true'?'1':'0';
    $data['status'] = $newStatus;
    $result = M('role')->where(array('id'=>array('eq',$id)))->save($data);
    if($result > 0){
      $new_status = M('role')->where(array('id'=>array('eq',$id)))->field('status')->find();
      $new_status = $new_status['status'];
    }else{
      $new_status = ''; 
    }
    // echo $a = M()->getLastSql();
    $this->ajaxReturn($new_status);
  } 

}
