<?php
namespace Home\Model;
use Think\Model;
class GitActivityModel extends Model{
	protected $_validate=array(
		array('activity','require','提交内容不能为空'),
	);
}