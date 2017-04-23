<?php
namespace Home\Model;
use Think\Model;
class PatentModel extends Model{
	protected $_validate=array(
	array('title_zh','require','专利名称不能为空')
	);
}