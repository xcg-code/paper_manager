<?php
namespace Home\Model;
use Think\Model;
class SoftwareModel extends Model{
	protected $_validate=array(
	array('title_zh','require','软件名称不能为空')
	);
}