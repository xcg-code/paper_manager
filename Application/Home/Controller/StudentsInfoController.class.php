<?php

	namespace Home\Controller;

	use Think\Controller;
	use Org\Net\Http;

	class StudentsInfoController extends Controller
	{
		//显示我的科研成果页面
		public function showStudents()
		{
			parent::is_login();

			$this->display();
		}

		public function studentInfo()
		{
			parent::is_login();

			$this->display();
		}


	}