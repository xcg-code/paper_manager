<?php

	namespace Home\Model;

	use Think\Model;

	class PatentModel extends Model
	{
		protected $_validate = array(
			array('country', 'require', '专利国家不能为空'),
			array('title_zh', 'require', '专利名称不能为空'),
			array('patent_num', 'require', '专利号不能为空'),
			array('patent_type', 'require', '专利类别不能为空'),
			array('status', 'require', '专利状态不能为空'),

		);
	}