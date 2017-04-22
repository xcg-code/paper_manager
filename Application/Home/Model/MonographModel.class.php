<?php
namespace Home\Model;
use Think\Model;
class MonograghModel extends Model{
	protected $_validate=array(
	array('title_zh','require','专著题目不能为空')
	);
}