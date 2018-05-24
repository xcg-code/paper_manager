<?php

	namespace Home\Model;

	use Think\Model;

	class PrizeModel extends Model
	{
		protected $_validate = array(
			array('prize_title', 'require', '奖项名称不能为空'),
			array('prize_institute', 'require', '授奖单位不能为空'),
			array('date', 'require', '日期不能为空'),
		);
	}