<?php
namespace Home\Model;
use Think\Model;
class ProjectModel extends Model{
	protected $_validate=array(
	array('type_name','require','项目类别不能为空'),
	array('project_num','require','项目号不能为空')
	);
}