<?php

	namespace Home\Model;

	use Think\Model;

	class ConferenceinvolvedModel extends Model
	{
		protected $_validate = array(
			array('type', 'require', '学术会议类型不能为空'),
			array('title_zh', 'require', '会议名称不能为空'),
			array('start_date', 'require', '会议开始时间不能为空'),
			array('end_date', 'require', '会议结束时间不能为空'),
		);
	}