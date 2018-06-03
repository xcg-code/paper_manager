<?php

	namespace Home\Controller;

	use Think\Controller;

	class LabController extends Controller
	{

		//展示所有实验室成员
		public function member_show(){
			parent::is_login();
			$UserModel=M('User');
			//$Condition['user_status']=1;
			$MemberInfo=$UserModel->where('user_status=1 and position!=0')->select();
			//获取每个成员科研成果数和科研项目数量
			for($i=0;$i<count($MemberInfo);$i++){
				$MemberInfo[$i]['achi_num']=get_single_member_achi_num($MemberInfo[$i]['user_number']);
				$MemberInfo[$i]['project_num']=get_single_member_project_num($MemberInfo[$i]['user_number']);
			}
			$this->assign('MemberInfo',$MemberInfo);
			$this->display();

		}

		public function member_delete($user_id){
			$UserModel=M('User');
			$UserModel->user_status=2;
			$result=$UserModel->where('user_number=%s',$user_id)->save();
			if($result){
				$this->redirect("/Home/Lab/member_show");
			}else{
				$this->error("删除失败");
			}
		}

		//查看个人科研项目
		public function show_project($user_id='',$project_type=''){
			parent::is_login();
			if($user_id==''){
				$user_number=session('userNum');
			}else{
				$user_number=$user_id;
			}
			//获取项目类别信息
			$TypeModel = M('Project_type');
			$TypeInfo = $TypeModel->select();
			//获取各类项目个数
			$TypeInfo = get_project_num($TypeInfo,$user_number);
			//获取项目总个数
			$AllCount = get_all_project_num($TypeInfo);
			//获取检索条件
			$ProjectModel = M('Project');
			$Condition['user_number'] = $user_number;
			$SearchAction = '';
			if ($project_type != '') {
				for ($i = 0; $i < count($TypeInfo); $i++) {
					if ($project_type == $TypeInfo[$i]['id']) {
						$Condition['type'] = $TypeInfo[$i]['type_name'];
						break;
					}
				}
				$SearchAction = 'project_type/' . $project_type;
			}
			//获取搜索栏内容
			$Search = I('post.search');
			$Condition['project_name|think_project.project_num'] = array('like', '%' . $Search . '%');
			$Condition['status'] = 1;
			//获取记录数
			$ProjectCount = $ProjectModel->join('INNER JOIN think_project_member ON think_project.id=think_project_member.project_id')
				->where($Condition)
				->field("think_project.*,think_project_member.user_number")
				->count();
			//分页数据获取
			$Page = get_page($ProjectCount, 10);// 实例化分页类 传入总记录数和每页显示的记录数(25)
			$show = $Page->show();// 分页显示输出
			// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
			//$ProjectInfo = $ProjectModel->where($Condition)->limit($Page->firstRow . ',' . $Page->listRows)->select();
			$ProjectInfo=$ProjectModel->join('INNER JOIN think_project_member ON think_project.id=think_project_member.project_id')
				->where($Condition)
				->field("think_project.*,think_project_member.user_number")
				->limit($Page->firstRow . ',' . $Page->listRows)->select();
			$this->assign('TypeInfo', $TypeInfo);
			$this->assign('AllCount', $AllCount);
			$this->assign('ProjectInfo', $ProjectInfo);
			$this->assign('SearchAction', $SearchAction);
			$this->assign('page', $show);// 赋值分页输出
			$this->assign('user_number',$user_id);

			$UserModel=M('User');
			$user=$UserModel->where('user_number=%s',$user_number)->find();
			$this->assign('user',$user);
			$this->display();

		}

		public function all_project($project_type=''){
			parent::is_login();
			//获取项目类别信息
			$TypeModel = M('Project_type');
			$TypeInfo = $TypeModel->select();
			//获取各类项目个数
			$TypeInfo = get_all_project($TypeInfo);
			//获取项目总个数
			$AllCount = get_all_project_num($TypeInfo);
			//获取检索条件
			$ProjectModel = M('Project');
			$SearchAction = '';
			if ($project_type != '') {
				for ($i = 0; $i < count($TypeInfo); $i++) {
					if ($project_type == $TypeInfo[$i]['id']) {
						$Condition['type'] = $TypeInfo[$i]['type_name'];
						break;
					}
				}
				$SearchAction = 'project_type/' . $project_type;
			}
			//获取搜索栏内容
			$Search = I('post.search');
			$Condition['project_name|think_project.project_num'] = array('like', '%' . $Search . '%');
			$Condition['status'] = 1;
			//分页数据获取
			$Page = get_page($AllCount, 10);// 实例化分页类 传入总记录数和每页显示的记录数(25)
			$show = $Page->show();// 分页显示输出
			// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
			$ProjectInfo=$ProjectModel->where($Condition)->limit($Page->firstRow . ',' . $Page->listRows)->select();
			$this->assign('TypeInfo', $TypeInfo);
			$this->assign('AllCount', $AllCount);
			$this->assign('ProjectInfo', $ProjectInfo);
			$this->assign('SearchAction', $SearchAction);
			$this->assign('page', $show);// 赋值分页输出
			$this->display();
		}

		//显示我的科研成果页面
		public function all_achievement($achi_type = '', $achi_year = '')
		{
			parent::is_login();
			$AchievementModel = M('Achievement');
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
			$AchievementCount = get_achievement_count();
			//获取不同年份科研成果的数量
			$AchievementYear = get_achievement_year();
			//分页数据获取
			$Page = get_page($AchievementYearCount, 10);// 实例化分页类 传入总记录数和每页显示的记录数(25)
			$show = $Page->show();// 分页显示输出
			// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
			$AchievementInfo = $AchievementModel->where($Condition)->order('publish_time desc')->limit($Page->firstRow . ',' . $Page->listRows)->select();
			//获取作者姓名字符串和详情链接
			for ($i = 0; $i < count($AchievementInfo); $i++) {
				$AchievementInfo[$i]['author'] = get_author_list($AchievementInfo[$i]['id']);
				$AchievementInfo[$i]['detail_link'] = get_detail_link($AchievementInfo[$i]);
			}
			$this->assign('AchievementInfo', $AchievementInfo);
			$this->assign('AchievementCount', $AchievementCount);
			$this->assign('AchievementYear', $AchievementYear);
			$this->assign('SearchAction', $SearchAction);
			$this->assign('page', $show);// 赋值分页输出
			$this->display();
		}



	}