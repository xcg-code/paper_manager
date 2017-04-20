<?php
namespace Home\Model;
use Think\Model;
class Project_typeModel extends Model{
	protected $_validate=array(
	array('type_name','require','项目类别名不能为空'),
	);
}