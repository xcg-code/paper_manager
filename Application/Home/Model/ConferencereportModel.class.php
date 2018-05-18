<?php

	namespace Home\Model;

	use Think\Model;

	class ConferencereportModel extends Model
	{
		protected $_validate = array(
			array('report_type', 'require', '报告类型不能为空'),
			array('conference_type', 'require', '会议类型不能为空'),
			array('title_zh', 'require', '报告名称不能为空'),
			array('conference_zh', 'require', '会议名称不能为空'),
			array('start_date', 'require', '会议开始时间不能为空'),
			array('end_date', 'require', '会议结束时间不能为空'),
			array('publish_date', 'require', '发表日期不能为空'),
		);
	}