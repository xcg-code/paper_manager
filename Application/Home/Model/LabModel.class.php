<?php
namespace Home\Model;
use Think\Model;
class LabModel extends Model{
	protected $_validate=array(
	array('name','require','实验室名称不能为空'),
	array('institute','require','所属科研单位不能为空')
	);
}