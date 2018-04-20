<?php

	namespace Home\Controller;

	use Think\Controller;
	use Org\Net\Http;

	class ContributionsController extends Controller
	{
		//创建投稿
		public function createContributions()
		{
			parent::is_login();

			$this->display();
		}

		//我的投稿
		public function myContributions()
		{
			parent::is_login();

			$this->display();
		}




	}