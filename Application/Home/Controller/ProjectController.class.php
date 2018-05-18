<?php

	namespace Home\Controller;

	use Think\Controller;
	use Think\Model;
	use Think\Upload;

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
			//获取未读通知数量
			$NoticeModel = M('GitNotice');
			$CountInfo['Notice'] = $NoticeModel->where("project_id='%s' and user_number=%d and state='%s'", $git_id, session('userNum'), "未读")->count();
			//获取项目组活动日志
			$ActivityModel = M('GitActivity');
			$ActivityCount = $ActivityModel->where("project_id='%s'", $git_id)->count();
			//分页数据获取
			$Page = get_page($ActivityCount, 6);// 实例化分页类 传入总记录数和每页显示的记录数(25)
			$show = $Page->show();// 分页显示输出
			// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
			$ActivityInfo = $ActivityModel->join('INNER JOIN think_user ON think_git_activity.person_number=think_user.user_number')
				->where("project_id='%s'", $git_id)
				->field('think_git_activity.*,think_user.user_name')
				->order('time desc')
				->limit($Page->firstRow . ',' . $Page->listRows)
				->select();
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
			//获取项目成员
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
			$this->assign("NoticeCount", $NoticeCount);
			$this->assign('git_id', $git_id);
			$this->assign('NoticeInfo', $NoticeInfo);
			$this->assign('page', $show);// 赋值分页输出
			$this->display();
		}

		//显示已读通知
		public function notice_read($git_id)
		{
			$GitModel = M('GitNotice');
			$Condition1['project_id'] = $git_id;
			$Condition1['user_number'] = session('userNum');
			$Condition1['state'] = '已读';
			$NoticeRead = $GitModel->where($Condition1)->count();
			$Condition2['project_id'] = $git_id;
			$Condition2['user_number'] = session('userNum');
			$Condition2['state'] = '未读';
			$NoticeUnRead = $GitModel->where($Condition2)->count();
			//分页数据获取
			$Page = get_page($NoticeRead, 3);// 实例化分页类 传入总记录数和每页显示的记录数(3)
			$show = $Page->show();// 分页显示输出
			// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
			$NoticeInfo = $GitModel->where($Condition1)->order('time desc')->limit($Page->firstRow . ',' . $Page->listRows)->select();
			$this->assign("NoticeUnRead", $NoticeUnRead);
			$this->assign('git_id', $git_id);
			$this->assign('NoticeInfo', $NoticeInfo);
			$this->assign('page', $show);// 赋值分页输出
			$this->display();
		}

		//将某条通知置为已读
		public function git_notice_read($notice_id, $git_id)
		{
			$GitModel = M('GitNotice');
			$GitModel->state = '已读';
			$Condition['id'] = $notice_id;
			$result = $GitModel->where($Condition)->save();
			if ($result) {
				$this->redirect("/Home/Project/notice_unread/git_id/" . $git_id);
			}
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

		//更新项目状态
		public function git_update($git_id)
		{
			$this->assign("git_id", $git_id);
			$this->display();
		}

		//更新项目状态
		public function project_update($git_id)
		{
			if (empty($_POST['activity'])) {
				$this->error("提交内容不能为空");
				return;
			}
			$ActivityModel = D('GitActivity');
			if ($ActivityModel->create()) {
				$ActivityModel->project_id = $git_id;
				$ActivityModel->person_number = session('userNum');
				$ActivityModel->type = "更新了项目状态";
				$ActivityModel->time = date("Y-m-d H:i:s");
				$result = $ActivityModel->add();
				if ($result) {
					$this->redirect("/Home/Project/project_git_show/git_id/" . $git_id);
				} else {
					$this->error("上传消息状态出错");
				}
			} else {
				$this->error("数据库出错");
			}
		}

		//显示项目文档管理页面
		public function git_doc($git_id)
		{
			//获取当前协作项目文档信息
			$GitUploadModel = M('GitUpload');
			$DocInfo = $GitUploadModel->join('INNER JOIN think_user ON think_git_upload.user_number=think_user.user_number')
				->join('INNER JOIN think_file ON think_git_upload.file_id=think_file.id')
				->where("project_id='%s'", $git_id)
				->field('think_git_upload.*,think_user.user_name,think_file.name as file_name')
				->order('time desc')
				->select();
			$this->assign('DocInfo', $DocInfo);
			$this->assign('git_id', $git_id);
			$this->assign("user_number", session('userNum'));
			$this->display();
		}

		//协作项目文件上传
		public function git_file_upload($git_id)
		{
			$GitUploadModel = D('GitUpload');
			if ($GitUploadModel->create()) {
				$GitUploadModel->user_number = session(userNum);
				$GitUploadModel->project_id = $git_id;
				$GitUploadModel->time = date("Y-m-d H:i:s");
				$file_id = $this->uploadFile($git_id);
				if ($file_id != 0) {
					$GitUploadModel->file_id = $file_id;
				}
				$result = $GitUploadModel->add();
				if ($result) {
					$this->redirect('/Home/Project/git_doc/git_id/' . $git_id);
				} else {
					$this->error('提交数据库错误');
				}
			} else {
				$this->error("创建数据错误");
			}

		}

		public function uploadFile($id = '')
		{
			$upload = new Upload();// 实例化上传类
			$upload->maxSize = 20971520;// 设置附件上传大小 20MB
			$upload->exts = array('pdf', 'doc', 'docx', 'ppt', 'pptx', 'rar', 'zip', '7z', 'txt');// 设置附件上传类型
			$upload->rootPath = './Uploads/'; // 设置附件上传根目录,
			$upload->savePath = 'Projects/'; // 设置附件上传（子）目录
			$upload->saveName = array('uniqid', '');
			$upload->autoSub = false;
			$file_id = "";
			if ($_FILES['filePath']['name']) {
				$info = $upload->uploadOne($_FILES['filePath']);
				// 上传文件
				if (!$info) {// 上传错误提示错误信息
					$this->error($upload->getError());
				} else {// 上传成功,保存文件信息
					if ($id != '') {
						$FileInfo['achievement_id'] = $id;
					}
					$FileInfo['name'] = $info['name'];
					$FileInfo['path'] = 'Uploads/' . $info['savepath'] . $info['savename'];
					$FileInfo['upload_time'] = date("Y-m-d H:i:s");
					$FileInfo['user_number'] = session('userNum');
					$FileInfo['type'] = 'Project';
					$FileModel = M('File');
					$Result = $FileModel->add($FileInfo);
					//保存日志
					$ActivityModel = M('GitActivity');
					$ActivityModel->project_id = $id;
					$ActivityModel->person_number = session('userNum');
					$ActivityModel->activity = $FileInfo['name'];
					$ActivityModel->type = '上传了新文档';
					$ActivityModel->time = date("Y-m-d H:i:s");
					$ActivityModel->add();
					if (!$Result) {
						$this->error('文档上传失败');
					}
					$file_id = $Result;
				}
			}
			return $file_id;
		}

		//下载文件
		public function downloadFile($id)
		{
			parent::is_login();
			if ($id == '') {
				$this->ajaxReturn('下载失败');
				return;
			}
			$FileModel = M('File');
			$condition['id'] = $id;
			$file = $FileModel->where($condition)->find();
			if ($file == false) {
				$this->ajaxReturn('文件未找到!');
			} else {
				$name = $file['name'];
				$fileName = urlencode($name);
				$filePath = './' . $file['path'];
				import('ORG.Net.Http');
				$http = new \Org\Net\Http;
				$http->download($filePath, $fileName);
			}
		}

		//我的科研项目
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
			$Condition['user_number'] = session('userNum');
			$SearchAction = '';
			if ($project_type != '') {
				for ($i = 0; $i < count($TypeInfo); $i++) {
					if ($project_type == $TypeInfo[$i]['id']) {
						$Condition['type'] = $TypeInfo[$i]['type'];
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
			//获取项目信息
			$Condition2['project_id'] = $id;
			$SearchAction = '';
			if ($achi_type != '') {
				$Condition2['achievement_type'] = $achi_type;
				$SearchAction = 'achi_type/' . $achi_type;
			}
			if ($achi_year != '') {
				$start_date = $achi_year . '-01-01';
				$end_date = $achi_year . '-12-31';
				$Condition2['publish_time'] = array(array('egt', $start_date), array('elt', $end_date));
				$SearchAction = 'achi_year/' . $achi_year;
			}
			//获取搜索栏内容
			$Search = I('post.search');
			$Condition2['title'] = array('like', '%' . $Search . '%');
			//获取记录数
			$AchievementYearCount = $AchievementModel->where($Condition2)->count();
			//获取各种科研成果的数目
			$AchievementCount = get_achievement_count($id);
			//获取不同年份科研成果的数量
			$AchievementYear = get_achievement_year($id);
			//分页数据获取
			$Page = get_page($AchievementYearCount, 5);// 实例化分页类 传入总记录数和每页显示的记录数(25)
			$show = $Page->show();// 分页显示输出
			// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
			$AchievementInfo = $AchievementModel->where($Condition2)->order('publish_time desc')->limit($Page->firstRow . ',' . $Page->listRows)->select();
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
			$this->assign('ProjectInfo', $ProjectInfo);
			//判断当前用户是否为项目负责人
			if (session('userNum') != $ProjectInfo['owner']) {
				$IsAdmin = 0;//0表示当前用户不是项目负责人
			} else {
				$IsAdmin = 1;//0表示当前用户是项目负责人
				//获取待审核经费申请数量
			}
			$this->assign('IsAdmin', $IsAdmin);

			//获取项目负责人信息
			$userModel=M('User');
			$ownerName = $userModel->where('think_user.user_number="%d"',$ProjectInfo['owner'])
				->getField('user_name');
			$this->assign('ownerName', $ownerName);
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
			$ProjectModel->status = 1;
			$Result = $ProjectModel->where("id='%s'", $git_id)->save();
			if ($Result) {
				$this->success('该协作项目已完成', __ROOT__ . '/index.php/Home/Project/project_git');
			} else {
				$this->error($ProjectModel->getError());
			}
		}

		//添加项目相关论文成果
		public function add_achievement($project_id)
		{
			$this->assign("project_id", $project_id);
			$this->display();
		}

	}