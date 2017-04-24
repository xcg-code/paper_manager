<?php
namespace Home\Model;
use Think\Model;
class RewardModel extends Model{
	protected $_validate=array(
	array('title_zh','require','成果名称不能为空')
	);
}