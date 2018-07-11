<?php
//---------------
//Author:pc
//---------------
 
namespace Admin\Controller;

use Think\Controller;
use Org\Util\Rbac;
	/* 
	登录
	*/
class PublicController extends Controller{
	public function login(){
		$this->display();
	}
	public function dologin(){
		if(empty($_POST['username'])) {
		 	$this->error('帐号错误！');
		}elseif (empty($_POST['password'])){
		 	$this->error('密码必须！');
		}
		// 检查验证码  
		$verify = I('param.verify','');  
		if(!check_verify($verify)){  
		    $this->error("验证码错！",U('Admin/Public/login'));  
		}  
		//生成认证MAP条件
		//这里使用用户名、密码和状态的方式进行认证
		$map  = array();
		$map['username'] = $_POST['username'];
		$map['password'] = md5($_POST['password']);
		$map['status'] = 1;
		//进行委托认证 使用用户名、密码和状态的方式进行认证
		$authInfo = \Org\Util\Rbac::authenticate($map);
	 	if(false === $authInfo) {
			$this->error('帐号不存在或已禁用！');
		}else {
			if($authInfo['password'] != md5($_POST['password'])) {
	   		$this->error('密码错误！');
	   	}
	   	if($authInfo['username']==C('RBAC_SUPERADMIN') || $authInfo['username']==C('RBAC_SUPERMAN') ) {
		 	//超级管理员不受权限控制影响
	   		session(C('ADMIN_AUTH_KEY'),true);
			}
		 	
		   	// 设置认证识别号  
			$_SESSION[C('USER_AUTH_KEY')] = $authInfo['user_id'];
      $_SESSION['adminname'] = $map['username'];
      //更新登录时间和登录ip
      M('user')->where($map)->save(array("logintime"=> time(), "loginip" => get_client_ip()));
			//获取并保存用户访问权限列表 
			\Org\Util\Rbac::saveAccessList();
			// 登录成功，页面跳转  
			// $this->redirect('Admin/Index/index','',5,'页面跳转中...');
			$this->success('登录成功，页面跳转',U('Admin/Index/index'));
  	}
	}	

	public function logout(){
		//检测是否设置了USER_AUTH_KEY
		if(isset($_SESSION[C('USER_AUTH_KEY')])){
			unset($_SESSION);
			session_destroy();
			$this->success('登出成功',U('Admin/Public/login'));	
		}else{
			$this->error('已经登出！');
		}
	}
	/** 
	 * 验证码生成 
	 */  
	public function verify_c(){  
	    $Verify = new \Think\Verify();  
	    $Verify->fontSize = 28;  
	    $Verify->length   = 4;  
	    $Verify->useNoise = true;  
	    $Verify->codeSet = '0123456789';  
	    $Verify->imageW = 172;  
	    $Verify->imageH = 50;
	    $Verify->useImgBg = false;   
	    //$Verify->expire = 600;  
	    $Verify->entry();  
	}  
	/*
		密码找回
	*/
	public function findPass(){
		//过滤email
		$email = I('param.email','','email');
		$num = M('user')->where(array('email'=>array('eq',$email)))->field('user_id,username,password,getpasstime')->find();
		if($num == 0){
			return $result = 'noreg';
		}else{
			$user_id = $num['user_id'];
			//验证时间
			$getpasstime = time();
			$token = md5($user_id.$num['username'].$num['password']);//组合验证码
			$url = 'http://' . $_SERVER['HTTP_HOST'] . U('Admin/Public/reset?email=' . $email . '&token=' . $token); //构造URL
			$time = date('Y-m-d H:i');
			$subject = C('WHO_SEND').'-密码找回';
			$body = "亲爱的".$email."：<br/>您在".$time."提交了找回密码请求。请点击下面的链接重置密码 
（按钮24小时内有效）。<br/><a href='".$url."'target='_blank'>".$url."</a>"; 
			$username = $num['username'];
			$result = sendMail($email,$subject,$body,$username);
			if($result == 1){
				//邮件发送成功
				$msg = '系统已向您的邮箱发送了一封邮件<br/>请登录到您的邮箱及时重置您的密码！'; 
				$data['getpasstime'] = $getpasstime;
				M('user')->where(array('user_id'=>array('eq',$user_id)))->save($data);
			}else{
					//没有发送成功，提示错误信息
					$msg = $result;
			}
		}		
		$this->ajaxReturn($msg);
	}

	/*
	 通过密码找回重设密码
	*/
	public function reset(){
		$email = I('param.email','','email');
		$token = I('param.token');
		$num = M('user')->where(array('email'=>array('eq',$email)))->field('user_id,username,email,password,getpasstime')->find();
		if($num){
			$mt = md5($num['user_id'].$num['username'].$num['password']);
			if($mt == $token){
				if(time() - $num['getpasstime']>24*60*60){
					$msg = '该链接已过期！';
				}else{
					//重设密码
					$msg = 'right';
				}
			}else{
				$msg = '无效的链接';
			}
		}else{
			$msg = '错误的链接';
		}
		$this->assign('msg',$msg);
		$this->assign('user_id',$num['user_id']);
		$this->assign('username',$num['username']);
		$this->assign('email',$num['email']);
		$this->display();
	}

	/*
		通过密码找回重设密码
	*/
	public function doreset(){
		$map  = array();
		$map['user_id'] = $_POST['user_id'];
		$map['status'] = 1;
		$authInfo = M('user')->where($map)->find();
		if(false === $authInfo){
			$this->error('帐号不存在或已禁用！');
		}else {
			//过滤
			$user = D('user');
	    if(!$user->create($_POST,2)){
	      $this->error($user->getError());
	      exit;
	    }
	    $pk = $user->getPk();
	   	//更新密码
	   	$data = array('password'=>md5($_POST['password']));
	   	$result = M('user')->where(array('user_id'=>array('eq',$_POST['user_id'])))->setField($data);
	   	//判断修改时要这样判断，如果修改一样返回int(0)
	   	if($result!== false){
				$this->success('密码修改成功',U('Admin/Public/login'));
	   	}else{
	   		$this->error('修改失败');
	   	}
  	}
	}


	

}


