<?php
namespace Home\Model;
use Think\Model;
class StandardModel extends Model{
	protected $_validate=array(
	array('country','require','标准类型不能为空'),
		array('title_zh','require','标准名称不能为空'),
		array('standard_num','require','标准号不能为空'),
		array('institute','require','发布机构不能为空'),
		array('publish_date','require','发布时间不能为空'),
	);
}