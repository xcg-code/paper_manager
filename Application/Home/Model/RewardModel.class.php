<?php
namespace Home\Model;
use Think\Model;
class RewardModel extends Model{
	protected $_validate=array(
	array('title_zh','require','成果名称不能为空'),
		array('reward_type','require','奖励类别不能为空'),
		array('specific','require','注明信息不能为空'),
		array('reward_level','require','奖励等级不能为空'),
		array('institute','require','授奖机构不能为空'),
		array('publish_date','require','授奖日期不能为空'),
	);
}