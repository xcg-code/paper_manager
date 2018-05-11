<?php

	namespace Home\Controller;

	use Think\Controller;
	use Think\Model;

	class ProjectController extends Controller
	{
		//科研项目协作页面
		public function project_git()
		{
			$ProjectMemberModel = M('ProjectMember');
			$ProjectInfo = $ProjectMemberModel->join('INNER JOIN think_project ON think_project_member.project_id=think_project.id')
				->where('user_number=%d', session(userNum))
				->order('time desc')
				->select();
			for ($i = 0; $i < count($ProjectInfo); $i++) {
				if ($ProjectInfo[$i]['status'] == 0) {
					$ProjectInfo[$i]['status'] = '进行中';
				} else {
					$ProjectInfo[$i]['status'] = '已完成';
				}
			}
			$this->assign('ProjectInfo', $ProjectInfo);
			$this->display();
		}

		//创建新的协作科研项目页面
		public function project_create()
		{
			//获取项目类别信息
			$TypeModel = M('Project_type');
			$TypeInfo = $TypeModel->select();
			//获取实验室所有人员信息
			$MemberModel = M('User');
			$MemberInfo = $MemberModel->select();
			$this->assign('TypeInfo', $TypeInfo);
			$this->assign('MemberInfo', $MemberInfo);
			$this->display();
		}

		//创建新的协作科研项目数据库操作()
		public function project_create_db()
		{
			$ap = "";
			$members = $_POST['member'];
			$project_num = $_POST['project_num'];
			$owner = false;
			for ($i = 0; $i < count($members); $i++) {
				$ap = $ap . $members[$i] . ",";
				if ($members[$i] == session('userNum')) {
					$owner = true;
				}
			}
			//获取项目成员
			$allMember = substr($ap, 0, -1);//去除末尾单引号职位分类
			if ($owner == false) {
				$allMember = session('userNum') . ',' . $allMember;
				$members[count($members)] = session('userNum');
			}
			$projectModel = D('Project');
			$projectMemberModel = M('ProjectMember');
			$model = new \Think\Model();
			//开启事务
			$model->startTrans();
			$success1 = true;
			$success2 = true;
			if ($projectModel->create()) {
				$projectModel->type = $_POST['type'];
				$projectModel->owner = session('userNum');
				$projectModel->time = date("Y-m-d H:i:s");
				$projectModel->inner_member = $allMember;
				$result = $projectModel->add();
				if ($result) {
					for ($i = 0; $i < count($members); $i++) {
						$projectMemberModel->user_number = $members[$i];
						$projectMemberModel->project_id = $result;
						$projectMemberModel->project_num = $project_num;
						$ok = $projectMemberModel->add();
						if (!$ok) {
							$success2 = false;
							break;
						}
					}
				} else {
					$success1 = false;
					$this->error("提交数据库错误");
				}
			} else {
				$success1 = false;
				$this->error($projectModel->getError());
			}
			if ($success1 && $success2) {
				$model->commit();
				$this->success('创建协作科研项目成功', __ROOT__ . '/index.php/Home/Project/project_git');
			} else {
				$model->rollback();
				$this->error("创建协作科研项目失败");
			}
		}

		//某协作科研项目详情页面
		public function project_git_show($git_id)
		{
			//获取项目信息
			$ProjectModel = M('Project');
			$condition['id'] = $git_id;
			$ProjectInfo = $ProjectModel->where($condition)->find();
			$CountInfo = array();//各种数量数组
			//判断当前用户是否为项目负责人
			if (session('userNum') != $ProjectInfo['owner']) {
				$IsAdmin = 0;//0表示当前用户不是项目负责人
			} else {
				$IsAdmin = 1;//0表示当前用户是项目负责人
				//获取待审核经费申请数量
			}
			//获取项目文档数量
			$DocModel = M('GitDoc');
			$CountInfo['Doc'] = $DocModel->where("git_id='%s'", $git_id)->count();
			//获取未读通知数量
			$NoticeModel = M('GitNotice');
			$CountInfo['Notice'] = $NoticeModel->where("project_id='%s' and user_number=%d", $git_id, session('userNum'))->count();
			//获取项目组活动日志
			$GitModel = M('GitActivity');
			$ActivityCount = $GitModel->where("git_id='%s'", $git_id)->order('time desc')->count();
			//分页数据获取
			$Page = get_page($ActivityCount, 6);// 实例化分页类 传入总记录数和每页显示的记录数(25)
			$show = $Page->show();// 分页显示输出
			// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
			$ActivityInfo = $GitModel->where("git_id='%s'", $git_id)->order('time desc')->limit($Page->firstRow . ',' . $Page->listRows)->select();
			$this->assign('ProjectInfo', $ProjectInfo);
			$this->assign('ActivityInfo', $ActivityInfo);
			$this->assign('IsAdmin', $IsAdmin);
			$this->assign('page', $show);
			$this->assign('CountInfo', $CountInfo);
			$this->display();
		}

		//发布通知数据库操作
		public function git_notice_db($git_id)
		{
			//获取消息成员
			$members = $_POST['member'];
			$NoticeModel = M('GitNotice');
			$model = new \Think\Model();
			$success = true;
			//开启事务
			$model->startTrans();
			if ($NoticeModel->create()) {
				for ($i = 0; $i < count($members); $i++) {
					$NoticeModel->project_id = $git_id;
					$NoticeModel->user_number = $members[$i];
					$NoticeModel->time = date("Y-m-d H:i:s");
					$NoticeModel->state = '未读';
					$NoticeModel->title = I('post.title');
					$NoticeModel->content = I('post.content');
					$result = $NoticeModel->add();
					if (!$result) {
						$success = false;
						break;
					}
				}
				if ($success) {
					$model->commit();
					$this->success('发布项目组通知成功', __ROOT__ . '/index.php/Home/Project/project_git_show/git_id/' . $git_id);
				} else {
					$model->rollback();
					$this->error("服务器错误，发布失败!");
				}
			} else {
				$this->error($NoticeModel->getError());
			}
		}

		//显示发布通知页面
		public function git_notice($git_id)
		{
			//获取实验室ID
			$MemberModel = M('ProjectMember');
			$condition['project_id'] = $git_id;
			$MemberInfo = $MemberModel->join('INNER JOIN think_user ON think_project_member.user_number=think_user.user_number')
				->where($condition)
				->field('think_project_member.*,think_user.user_name')
				->select();
			$this->assign('git_id', $git_id);
			$this->assign('MemberInfo', $MemberInfo);
			$this->display();
		}


		//显示未读通知
		public function notice_unread($git_id)
		{
			$GitModel = M('GitNotice');
			$Condition['project_id'] = $git_id;
			$Condition['user_number'] = session('userNum');
			$Condition['state'] = '未读';
			$NoticeCount = $GitModel->where($Condition)->count();
			//分页数据获取
			$Page = get_page($NoticeCount, 3);// 实例化分页类 传入总记录数和每页显示的记录数(3)
			$show = $Page->show();// 分页显示输出
			// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
			$NoticeInfo = $GitModel->where($Condition)->order('time desc')->limit($Page->firstRow . ',' . $Page->listRows)->select();
			$this->assign('git_id', $git_id);
			$this->assign('NoticeInfo', $NoticeInfo);
			$this->assign('page', $show);// 赋值分页输出
			$this->display();
		}

		//显示已读通知
		public function notice_read($git_id)
		{
			$GitModel = M('GitNotice');
			$Condition['project_id'] = $git_id;
			$Condition['user_number'] = session('userNum');
			$Condition['state'] = '未读';
			$NoticeCount = $GitModel->where($Condition)->count();
			//分页数据获取
			$Page = get_page($NoticeCount, 3);// 实例化分页类 传入总记录数和每页显示的记录数(3)
			$show = $Page->show();// 分页显示输出
			// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
			$NoticeInfo = $GitModel->where($Condition)->order('time desc')->limit($Page->firstRow . ',' . $Page->listRows)->select();
			$this->assign('git_id', $git_id);
			$this->assign('NoticeInfo', $NoticeInfo);
			$this->assign('page', $show);// 赋值分页输出
			$this->display();
		}

		//将某条通知置为已读
		public function git_notice_read($notice_id)
		{
			$GitModel = M('GitNotice');
			$GitModel->state = '已读';
			$Condition['id'] = $notice_id;
			$GitModel->where($Condition)->save();
		}

		//将所有通知置为已读
		public function git_all_notice_read($git_id)
		{
			$GitModel = M('GitNotice');
			$Condition['git_id'] = $git_id;
			$Condition['user_id'] = session('uid');
			$GitModel->state = '已读';
			$GitModel->where($Condition)->save();
			$this->success('置所有通知为已读成功');
		}


		public function my_project($project_type = '')
		{
			parent::is_login();
			//获取项目类别信息
			$TypeModel = M('Project_type');
			$TypeInfo = $TypeModel->select();
			$TypeInfo = get_project_num($TypeInfo);
			//获取项目总个数
			$AllCount = get_all_project_num($TypeInfo);
			//获取检索条件
			$ProjectModel = M('Project');
			$Condition['user_id'] = session('uid');
			$SearchAction = '';
			if ($project_type != '') {
				for ($i = 0; $i < count($TypeInfo); $i++) {
					if ($project_type == $TypeInfo[$i]['id']) {
						$Condition['type_name'] = $TypeInfo[$i]['type_name'];
						break;
					}
				}
				$SearchAction = 'project_type/' . $project_type;
			}
			//获取搜索栏内容
			$Search = I('post.search');
			$Condition['project_name|project_num'] = array('like', '%' . $Search . '%');
			//获取记录数
			$ProjectCount = $ProjectModel->where($Condition)->count();
			//分页数据获取
			$Page = get_page($ProjectCount, 10);// 实例化分页类 传入总记录数和每页显示的记录数(25)
			$show = $Page->show();// 分页显示输出
			// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
			$ProjectInfo = $ProjectModel->where($Condition)->limit($Page->firstRow . ',' . $Page->listRows)->select();

			$this->assign('TypeInfo', $TypeInfo);
			$this->assign('AllCount', $AllCount);
			$this->assign('ProjectInfo', $ProjectInfo);
			$this->assign('SearchAction', $SearchAction);
			$this->assign('page', $show);// 赋值分页输出
			$this->display();
		}

		//显示项目详情页面
		public function project_show($id, $achi_type = '', $achi_year = '')
		{
			parent::is_login();
			//获取项目信息
			$ProjectModel = M('Project');
			$ConditionPro['id'] = $id;
			$ProjectInfo = $ProjectModel->where($ConditionPro)->find();
			//获取项目下的科研成果信息
			$AchievementModel = M('Achievement');
			$Condition['user_id'] = session('uid');
			//获取项目信息
			$Condition['achievement_id'] = $ProjectInfo['achievement_id'];
			$SearchAction = '';
			if ($achi_type != '') {
				$Condition['achievement_type'] = $achi_type;
				$SearchAction = 'achi_type/' . $achi_type;
			}
			if ($achi_year != '') {
				$start_date = $achi_year . '-01-01';
				$end_date = $achi_year . '-12-31';
				$Condition['publish_time'] = array(array('egt', $start_date), array('elt', $end_date));
				$SearchAction = 'achi_year/' . $achi_year;
			}
			//获取搜索栏内容
			$Search = I('post.search');
			$Condition['title'] = array('like', '%' . $Search . '%');
			//获取记录数
			$AchievementYearCount = $AchievementModel->where($Condition)->count();
			//获取各种科研成果的数目
			$AchievementCount = get_achievement_count($ProjectInfo['achievement_id']);
			//获取不同年份科研成果的数量
			$AchievementYear = get_achievement_year($ProjectInfo['achievement_id']);
			//分页数据获取
			$Page = get_page($AchievementYearCount, 5);// 实例化分页类 传入总记录数和每页显示的记录数(25)
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
			$this->assign('page', $show);// 赋值分页输出
			$this->assign('ProjectInfo', $ProjectInfo);
			$this->display();
		}

		//显示科研项目编辑页面
		public function project_edit($id)
		{
			parent::is_login();
			//获取项目类别信息
			$TypeModel = M('Project_type');
			$TypeInfo = $TypeModel->select();
			$this->assign('TypeInfo', $TypeInfo);
			$this->assign('achi_id', $id);
			//获取项目信息
			$ProjectModel = M('Project');
			$Condition['id'] = $id;
			$ProjectInfo = $ProjectModel->where($Condition)->find();
			$this->assign('ProjectInfo', $ProjectInfo);
			$this->display();
		}

		//科研项目编辑数据库操作
		public function project_edit_db($project_id)
		{
			$ProjectModel = D('Project');
			if ($ProjectModel->create()) {
				$Condition['id'] = $project_id;
				$Result = $ProjectModel->where($Condition)->save();
				if ($Result) {
					$this->success('修改所属项目信息成功', __ROOT__ . '/index.php/Home/Project/project_show/id/' . $project_id);
				} else {
					$this->error($ProjectModel->getError());
				}
			} else {
				$this->error($ProjectModel->getError());
			}
		}

		//科研项目删除功能
		public function project_delete($project_id)
		{
			$ProjectModel = M('Project');
			$Condition['id'] = $project_id;
			$Result = $ProjectModel->where($Condition)->delete();
			if ($Result) {
				$this->success('删除所属项目信息成功', __ROOT__ . '/index.php/Home/Project/my_project');
			} else {
				$this->error('删除所属项目信息失败');
			}
		}


		//完成协作科研项目
		public function git_finish($git_id)
		{
			$ProjectModel = M('Project');
			$ProjectModel->state = 1;
			$Result = $ProjectModel->where("id='%s'", $git_id)->save();
			if ($Result) {
				$this->success('该协作项目已完成', __ROOT__ . '/index.php/Home/Project/project_git');
			} else {
				$this->error($ProjectModel->getError());
			}
		}

		//申请项目开支数据库操作
		public function git_apply_cost_db($git_id)
		{
			$GitModel = M('GitCost');
			if ($GitModel->create()) {
				$GitModel->git_id = $git_id;
				$GitModel->user_id = session('uid');
				$GitModel->time = date("Y-m-d");
				$Result = $GitModel->add();
				//保存日志
				$ActivityModel = M('GitActivity');
				$ActivityModel->git_id = $git_id;
				$ActivityModel->person_a_name = session('fullname');
				$ActivityModel->activity = '申请项目经费:' . I('post.title');
				$ActivityModel->type = '申请经费';
				$ActivityModel->time = date("Y-m-d H:i:s");
				$ActivityModel->add();
				if ($Result) {
					$this->success('提交经费申请，等待审核', __ROOT__ . '/index.php/Home/Project/git_apply_cost/git_id/' . $git_id);
				} else {
					$this->error($ActivityModel->getError());
				}
			} else {
				$this->error($GitModel->getError());
			}
		}


		//显示项目文档管理页面
		public function git_doc($git_id)
		{
			//获取当前协作项目文档信息
			$GitModel = M('GitDoc');
			$DocInfo = $GitModel->where("git_id='%s'", $git_id)->order('upload_time desc')->select();
			for ($i = 0; $i < count($DocInfo); $i++) {
				$DocInfo[$i]['path'] = "Uploads/GitFile/" . $DocInfo[$i]['path'];
			}
			$this->assign('DocInfo', $DocInfo);
			$this->assign('git_id', $git_id);
			$this->display();
		}

		//协作项目文件上传
		public function git_file_upload($git_id)
		{
			$upload = new \Think\Upload();// 实例化上传类
			$upload->maxSize = 20971520;// 设置附件上传大小 20MB
			$upload->exts = array('pdf', 'doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx');// 设置附件上传类型
			$upload->rootPath = './Uploads/'; // 设置附件上传根目录
			$upload->savePath = './GitFile/'; // 设置附件上传（子）目录
			$upload->saveName = array('uniqid', '');
			$upload->autoSub = false;
			$info = $upload->uploadOne($_FILES['main']);
			if (!$info) {// 上传错误提示错误信息
				$this->error($upload->getError());
			} else {// 上传成功
				$FileInfo['title'] = $info['name'];
				$FileInfo['path'] = $info['savename'];
				$FileInfo['description'] = I('post.description');
				$FileInfo['upload_time'] = date("Y-m-d H:i:s");
				$FileInfo['user_id'] = session('uid');
				$FileInfo['author'] = session('fullname');
				$FileInfo['git_id'] = $git_id;
				$FileModel = M('GitDoc');
				$Result = $FileModel->add($FileInfo);
				//保存日志
				$ActivityModel = M('GitActivity');
				$ActivityModel->git_id = $git_id;
				$ActivityModel->person_a_name = session('fullname');
				$ActivityModel->activity = '上传了新的文档:' . $info['name'];
				$ActivityModel->type = '上传文档';
				$ActivityModel->time = date("Y-m-d H:i:s");
				$ActivityModel->add();
				if ($Result) {
					$this->success('文档上传成功', __ROOT__ . '/index.php/Home/Project/git_doc/git_id/' . $git_id);
				} else {
					$this->error('文档上传失败');
				}
			}
		}


		//分配问题数据操作
		public function git_arrange_bug_db($git_id)
		{
			$GitModel = M('GitBug');
			$UserModel = M('User');
			if ($GitModel->create()) {
				$GitModel->git_id = $git_id;
				$GitModel->creator = session('fullname');
				$UserInfo = $UserModel->where("fullname='%s'", session('fullname'))->find();
				$GitModel->creator_id = $UserInfo['id'];
				$UserInfo = $UserModel->where("fullname='%s'", I('post.receiver'))->find();
				$GitModel->receiver_id = $UserInfo['id'];
				$GitModel->create_time = date("Y-m-d H:i:s");
				$GitModel->state = '未完成';
				if (I('post.level') == '一般') {
					$GitModel->level_id = 1;
				} else if (I('post.level') == '严重') {
					$GitModel->level_id = 2;
				} else {
					$GitModel->level_id = 3;
				}
				$Result = $GitModel->add();
				//保存日志
				$ActivityModel = M('GitActivity');
				$ActivityModel->git_id = $git_id;
				$ActivityModel->person_a_name = session('fullname');
				$ActivityModel->activity = '分配了新的事务:' . I('post.title') . '。经办人是:' . I('post.receiver');
				$ActivityModel->type = '分配事务';
				$ActivityModel->time = date("Y-m-d H:i:s");
				$ActivityModel->add();
				if ($Result) {
					$this->success('分配事务成功', __ROOT__ . '/index.php/Home/Project/project_git_show/git_id/' . $git_id);
				} else {
					$this->error($GitModel->getError());
				}
			} else {
				$this->error($GitModel->getError());
			}
		}
	}