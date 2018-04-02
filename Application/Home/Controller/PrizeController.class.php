<?php

	namespace Home\Controller;

	use Think\Controller;
	use Org\Net\Http;

	class PrizeController extends Controller
	{
		public function prize_add()
		{
			parent::is_login();

			$this->display();
		}

		//显示我的科研成果页面
		public function my_prize($achi_type = '', $achi_year = '', $user_id = '')
		{
			parent::is_login();
			$AchievementModel = M('Achievement');
			if ($user_id == '') {
				$Condition['user_id'] = session('uid');
			} else {
				$Condition['user_id'] = $user_id;
			}
			$SearchAction = '/';
			if ($achi_type != '') {
				$Condition['achievement_type'] = $achi_type;
				$SearchAction = $SearchAction . 'achi_type/' . $achi_type;
			}
			if ($achi_year != '') {
				$start_date = $achi_year . '-01-01';
				$end_date = $achi_year . '-12-31';
				$Condition['publish_time'] = array(array('egt', $start_date), array('elt', $end_date));
				$SearchAction = $SearchAction . 'achi_year/' . $achi_year;
			}
			//获取搜索栏内容
			$Search = I('post.search');
			$Condition['title'] = array('like', '%' . $Search . '%');
			//获取记录数
			$AchievementYearCount = $AchievementModel->where($Condition)->count();
			//获取各种科研成果的数目
			$AchievementCount = get_achievement_count('', $user_id);
			//获取不同年份科研成果的数量
			$AchievementYear = get_achievement_year('', $user_id);
			//分页数据获取
			$Page = get_page($AchievementYearCount, 10);// 实例化分页类 传入总记录数和每页显示的记录数(25)
			$show = $Page->show();// 分页显示输出
			// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
			$AchievementInfo = $AchievementModel->where($Condition)->order('publish_time desc')->limit($Page->firstRow . ',' . $Page->listRows)->select();
			//获取作者姓名字符串和详情链接
			for ($i = 0; $i < count($AchievementInfo); $i++) {
				$AchievementInfo[$i]['author'] = get_author_list($AchievementInfo[$i]['achievement_id']);
				$AchievementInfo[$i]['detail_link'] = get_detail_link($AchievementInfo[$i]);
			}
			$this->assign('AchievementInfo', $AchievementInfo);
			$this->assign('AchievementCount', $AchievementCount);
			$this->assign('AchievementYear', $AchievementYear);
			$this->assign('SearchAction', $SearchAction);
			$this->assign('user_id', $user_id);
			$this->assign('page', $show);// 赋值分页输出
			$this->display();
		}

		public function downloadFile()
		{
			parent::is_login();
			import('ORG.Net.Http');
			$http=new \Org\Net\Http;
			if (IS_GET) {
				$url = "D:\/222.txt";
				$http->download($url, "2222.txt");
			} else {
				$this->ajaxReturn('非法请求');
			}
		}

	}