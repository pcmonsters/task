<?php 
/*
author:pc
*/
namespace Admin\Model;
use Think\Model;
use Think\Model\RelationModel;

class NodeModel extends RelationModel{
	protected $_auto = array(
    //不填则省略    
    array('sort','',1,'ignore'),
	);
    //关联模型
    protected $_link = array (
      'Node' => array(
          'mapping_type'      =>  self::HAS_MANY,
          'mapping_name'       =>  'node',
          'mapping_order'  =>  'sort',
          'parent_key'      =>      'pid',
          'condition'          =>  'display=1',
        )
     
    );
	//自动验证
	protected $_validate = array(
	  array('name','require','名称不能为空'), 
	  array('title','require','显示名不能为空'), 

	);
	/**
   * 获得分类树
   * @param int $id
   * @param bool $field 
   * @return array
   */
  public function getTree($id = 0, $field = true){
      /* 获取当前分类信息 */
      if($id){
          $info = $this->info($id);
          $id   = $info['id'];
      }

      /* 获取所有分类 */
      $map  = array('status' => array('gt', 0));
      //fied(true)的用法会显式的获取数据表的所有字段列表，哪怕你的数据表有100个字段。
      $list = $this->field($field)->where($map)->order('sort')->select();
      //list_to_tree将返回的数据集转换成树
      $list = list_to_tree($list, $pk = 'id', $pid = 'pid', $child = '_', $root = $id);


      /* 获取返回数据 */
      if(isset($info)){ //指定分类则返回当前分类极其子分类
          $info['_'] = $list;
      } else { //否则返回所有分类
          $info = $list;
      }

      return $info;
  }
	/**
   * 获得分类树型列表
   * @param int $id
   * @param bool $field
   * @return array
   */
  public function getTreeList($id = 0, $field = true){
      /* 获取当前分类信息 */
      if($id){
          $info = $this->info($id);
          $id   = $info['id'];
      }

      /* 获取所有分类 */
      $map  = array('status' => 1);
      $list = $this->field($field)->where($map)->order('sort')->select();
      $list = list_to_tree($list, $pk = 'id', $pid = 'pid', $child = 'list', $root = $id);


      /* 获取返回数据 */
      if(isset($info)){ //指定分类则返回当前分类极其子分类
          $info['list'] = $list;
      } else { //否则返回所有分类
          $info = $list;
      }

      return $info;
  }

  /**
   * 根据标签id列表获取标签列表树
   * @param string $ids
   * @param bool $field
   * @return array|null
   */
  public function getTreeListByIds($ids='',$field = true)
  {
      if($ids!=''){
          !is_array($ids)&&$ids=explode(',',$ids);
          $list_tags=$this->where(array('id'=>array('in',$ids),'status'=>1,'pid'=>array('neq',0)))->field($field)->order('sort')->select();
          if(count($list_tags)){
              $cate_ids=array_column($list_tags,'pid');
              array_unique($cate_ids);
              $cate_list=$this->where(array('id'=>array('in',$cate_ids),'status'=>1,'pid'=>0))->field($field)->order('sort')->select();
              if(count($cate_list)){
                  $list=array_merge($list_tags,$cate_list);
                  $list=list_to_tree($list,$pk='id',$pid='pid',$child='tag_list');
                  return $list;
              }
          }
      }
      return null;
  }
}
