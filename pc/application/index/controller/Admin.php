<?php
namespace app\index\controller;
use think\Db;
use \think\Request;
class Admin extends \think\Controller{

	
	protected $params;
	public function __construct(){
 		// var_dump('222');
		parent::__construct();
		Db::listen(function($sql, $time, $explain){
		    // 记录SQL
		    echo $sql. ' ['.$time.'s]';
		    // // 查看性能分析结果
		    // dump($explain);
		});
		$this->params = Request::instance()->param();
	}
  	/*
 	* 验证和授权(Authentication and Authorization)初始化
 	*/
 	public function _initialize(){
    //注释此段，可绕过权限认证
	     /*if(!isset($_SESSION[C('USER_AUTH_KEY')])) {
	     	     $this->redirect('Admin/Public/login');
	     }
 
	     $notAuth = in_array(MODULE_NAME, explode(',', C('NOT_AUTH_MODULE'))) || in_array(ACTION_NAME, explode(',',C('NOT_AUTH_ACTION')));
	      //权限验证
	     if(C('USER_AUTH_ON') && !$notAuth) {
	          //使用了项目分组，则必须引入GROUP_NAME
	     		if(!\Org\Util\Rbac::AccessDecision()){
		      		$this->error("你没有对应的权限");
	     		}
	     }*/
	}
}
