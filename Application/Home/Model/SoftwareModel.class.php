<?php

	namespace Home\Model;

	use Think\Model;

	class SoftwareModel extends Model
	{
		protected $_validate = array(
			array('title_zh', 'require', '软件名称不能为空'),
			array('reg_num', 'require', '登记号不能为空'),
			array('get_type', 'require', '权利获得方式不能为空'),
			array('right_type', 'require', '权力范围不能为空'),
			array('over_date', 'require', '开发完成时间不能为空'),
		);
	}