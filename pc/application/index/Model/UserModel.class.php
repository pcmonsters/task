<?php 
/*
author:pc
*/
namespace Admin\Model;
//use Think\Model;
use Think\Model\RelationModel;

class UserModel extends RelationModel{
  //关联模型
  protected $_link = array (
    'Role' => array(
      'mapping_type'    =>  self::MANY_TO_MANY,//多对多模型
      'class_name'			=>	'role',//关联的副表表名
      'foreign_key'     =>  'user_id',//主表在中间表中的字段名称
      'relation_foreign_key'  =>  'role_id',//关联表(副表)在中间表中的字段名称(外键)
      'mapping_name'		=>  'Role',
      'relation_table'  =>  'yy_role_user',//多对多中间表的表名,完整表名
      'mapping_fields' 	=>	'id,name',//要关联操作的字段
    ),

  );
  
  
	//自动完成
	protected $_auto = array ( 
		array('create_time', NOW_TIME, self::MODEL_INSERT),
		array('logintime', NOW_TIME, self::MODEL_BOTH),
		array('loginip', 'get_client_ip', self::MODEL_BOTH,'function'),
    array('password','md5',3,'function'),
	);


	//自动验证
	protected $_validate = array(
	  array('username','require','用户名不能为空',0,'regex',1), 
	  // array('username','/^\w{6,12}$/','用户名必须是6-12位的数字、字母、下划线',0,'regex',1), 
	  array('username','','帐号名称已经存在！',0,'unique',1), 
	  array('email','email','请填写正确的邮箱！',0,'regex',1),
	  array('password','/^\w{6,12}$/','密码必须是6-12位的数字、字母、下划线',0,'regex',1), 
	  array('repassword','password','确认密码不正确',0,'confirm',1), // 验证确认密码是否和密码一致
	);
} 
