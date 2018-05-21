<?php

	namespace Home\Model;

	use Think\Model;

	class TrainStudentModel extends Model
	{
		protected $_validate = array(
			array('stuNum', 'require', '学号不能为空不能为空'),
			array('stuName', 'require', '姓名不能为空'),
			array('major', 'require', '专业不能为空'),
			array('title', 'require', '毕设标题不能为空'),
		);
	}