<?php

	namespace Home\Controller;

	use Think\Controller;
	use Think\Upload;

	class AchievementController extends Controller
	{
		public function achievement_add($project_id = '')
		{
			parent::is_login();
			$UserModel = M('User');
			$uid = session('uid');
			$Condition['id'] = $uid;
			$Profile = $UserModel->where($Condition)->find();
			$this->assign('Profile', $Profile); //基本信息前端赋值
			$PicPath = "Uploads/UserPic/" . $Profile['pic_save_path'];
			$this->assign('PicPath', $PicPath); //用户头像信息前端赋值
			$this->assign("project_id", $project_id);
			$this->display();
		}

		//显示我的科研成果页面
		public function my_achievement($achi_type = '', $achi_year = '', $user_id = '')
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

		//显示成果文档上传页面
		public function file_upload($achi_id)
		{
			parent::is_login();
			$this->assign('achi_id', $achi_id);
			$this->display();
		}

		//上传论文完成科研成果添加
		public function finishAdd($achi_id = ''){
			$file_id=$this->uploadFile($achi_id,$_POST["description"]);
			$AchiModel=M('Achievement');
			$AchiModel->file_id=$file_id;
			$result=$AchiModel->where('id=%d',$achi_id)->save();
			if($result){
				$this->success("论文成果添加成功",__ROOT__ . '/index.php/Home/Achievement/my_achievement');
			}else{
				$this->error("论文文件添加失败");
			}
		}
		//全文电子文档上传
		public function uploadFile($achi_id = '',$description='')
		{
			$upload = new Upload();// 实例化上传类
			$upload->maxSize = 20971520;// 设置附件上传大小 20MB
			$upload->exts = array('pdf');// 设置附件上传类型
			$upload->rootPath = './Uploads/'; // 设置附件上传根目录,
			$upload->savePath = 'Achievements/'; // 设置附件上传（子）目录
			$upload->saveName = array('uniqid', '');
			$upload->autoSub = false;
			$file_id = "";
			if ($_FILES['filePath']['name']) {
				$info = $upload->uploadOne($_FILES['filePath']);
				// 上传文件
				if (!$info) {// 上传错误提示错误信息
					$this->error($upload->getError());
				} else {// 上传成功,保存文件信息
					if ($achi_id != '') {
						$FileInfo['achievement_id'] = $achi_id;
					}
					$FileInfo['name'] = $info['name'];
					$FileInfo['path'] = 'Uploads/' . $info['savepath'] . $info['savename'];
					$FileInfo['upload_time'] = date("Y-m-d H:i:s");
					$FileInfo['user_number'] = session('userNum');
					$FileInfo['type'] = 'Achievement';
					$FileInfo['description']=$description;
					$FileModel = M('File');
					$Result = $FileModel->add($FileInfo);
					if (!$Result) {
						$this->error('文档上传失败');
					}
					$file_id = $Result;
				}
			}
			return $file_id;
		}

		public function file_upload_main_db($achi_id)
		{
			$upload = new \Think\Upload();// 实例化上传类
			$upload->maxSize = 20971520;// 设置附件上传大小 20MB
			$upload->exts = array('pdf');// 设置附件上传类型
			$upload->rootPath = './Uploads/'; // 设置附件上传根目录
			$upload->savePath = './UserMainFile/'; // 设置附件上传（子）目录
			$upload->saveName = array('uniqid', '');
			$upload->autoSub = false;
			$info = $upload->uploadOne($_FILES['main']);
			if (!$info) {// 上传错误提示错误信息
				$this->error($upload->getError());
			} else {// 上传成功
				$FileInfo['name'] = $info['name'];
				$FileInfo['path'] = $info['savename'];
				$FileInfo['description'] = I('post.description');
				$FileInfo['upload_time'] = date("Y-m-d H:i:s");
				$FileInfo['type'] = 'Main';
				$FileInfo['achievement_id'] = $achi_id;
				$FileModel = M('File');
				$Result = $FileModel->add($FileInfo);
				if ($Result) {
					$this->success('全文电子文档上传成功', __ROOT__ . '/index.php/Home/Achievement/file_upload/achi_id/' . $achi_id);
				} else {
					$this->error('全文电子文档上传失败');
				}
			}
		}

		//科研成果其他相关文档上传
		public function file_upload_other_db($achi_id)
		{
			$upload = new \Think\Upload();// 实例化上传类
			$upload->maxSize = 20971520;// 设置附件上传大小 20MB
			$upload->exts = array('pdf');// 设置附件上传类型
			$upload->rootPath = './Uploads/'; // 设置附件上传根目录
			$upload->savePath = './UserOtherFile/'; // 设置附件上传（子）目录
			$upload->saveName = array('uniqid', '');
			$upload->autoSub = false;
			$info = $upload->uploadOne($_FILES['other']);
			if (!$info) {// 上传错误提示错误信息
				$this->error($upload->getError());
			} else {// 上传成功
				$FileInfo['name'] = $info['name'];
				$FileInfo['path'] = $info['savename'];
				$FileInfo['description'] = I('post.description');
				$FileInfo['upload_time'] = date("Y-m-d H:i:s");
				$FileInfo['type'] = 'Other';
				$FileInfo['achievement_id'] = $achi_id;
				$FileModel = M('File');
				$Result = $FileModel->add($FileInfo);
				if ($Result) {
					$this->success('文档上传成功', __ROOT__ . '/index.php/Home/Achievement/file_upload/achi_id/' . $achi_id);
				} else {
					$this->error('文档上传失败');
				}
			}
		}

		//删除已上传文件操作
		public function file_delete($id, $file_type)
		{
			$FileModel = M('File');
			$Condition['id'] = $id;
			$FileInfo = $FileModel->where($Condition)->find();
			$FilePath = $FileInfo['path'];
			//拼接物理地址
			if ($file_type == 'Main') {
				$FilePath = substr(THINK_PATH, 0, -9) . 'Uploads/UserMainFile/' . $FilePath;
			} else {
				$FilePath = substr(THINK_PATH, 0, -9) . 'Uploads/UserOtherFile/' . $FilePath;
			}

			//删除物理文件
			$ResultDel = unlink($FilePath);
			//删除数据库信息
			$ResultDb = $FileModel->where($Condition)->delete();
			if ($ResultDel && $ResultDb) {
				$this->success('删除文件成功');
			} else {
				$this->error('删除文件失败');
			}
		}

		//无文件错误页面显示
		public function no_file()
		{
			$this->error('未上传全文电子文档');
		}

		//显示添加作者信息页面
		public function author_add($achi_id)
		{
			parent::is_login();
			$this->assign('achi_id', $achi_id);
			$this->display();
		}

		//添加作者信息数据库操作
		public function author_add_db($achi_id)
		{
			$AuthorModel = D('Author');
			$Count = I('post.author_num');
			$Result = false;
			if ($Count == 0) {
				$this->error('您没有填写任何作者信息');
			}
			for ($i = 0; $i < $Count; $i++) {
				$Data['author_name'] = I('post.author_name_' . $i);
				if ($Data['author_name'] == '') {
					$this->error('作者姓名为必填项');
				}
				$Data['author_workplace'] = I('post.author_workplace_' . $i);
				$Data['author_email'] = I('post.author_email_' . $i);
				$Data['is_contact'] = I('post.is_contact_' . $i);
				$Data['is_first'] = I('post.is_first_' . $i);
				$Data['is_main'] = I('post.is_main_' . $i);
				$Data['is_company'] = I('post.is_company_' . $i);
				$Data['achievement_id'] = $achi_id;
				if ($AuthorModel->add($Data)) {
					$Result = true;
				}
			}
			if ($Result) {
				$this->success('添加作者信息成功', __ROOT__ . '/index.php/Home/Achievement/file_upload/achi_id/' . $achi_id);
			} else {
				$this->success('添加作者信息失败');
			}

		}

		//显示查看作者页面
		public function author_show($achi_id, $page_type)
		{
			parent::is_login();
			$AuthorModel = M('Author');
			$Condition['achievement_id'] = $achi_id;
			$AuthorInfo = $AuthorModel->where($Condition)->select();
			for ($i = 0; $i < count($AuthorInfo); $i++) {
				if ($AuthorInfo[$i]['is_contact'] != '是') {
					$AuthorInfo[$i]['is_contact'] = '否';
				}
				if ($AuthorInfo[$i]['is_main'] != '是') {
					$AuthorInfo[$i]['is_main'] = '否';
				}
				if ($AuthorInfo[$i]['is_first'] != '是') {
					$AuthorInfo[$i]['is_first'] = '否';
				}
				if ($AuthorInfo[$i]['is_company'] != '是') {
					$AuthorInfo[$i]['is_company'] = '否';
				}
			}
			$this->assign('AuthorInfo', $AuthorInfo);
			$this->assign('achi_id', $achi_id);
			$this->assign('page_type', $page_type);
			$this->display();
		}

		//显示修改作者页面
		public function author_edit($author_id, $page_type)
		{
			parent::is_login();
			$AuthorModel = M('Author');
			$Condition['id'] = $author_id;
			$AuthorInfo = $AuthorModel->where($Condition)->find();
			$this->assign('AuthorInfo', $AuthorInfo);
			$this->assign('page_type', $page_type);
			$this->display();
		}

		//修改作者信息数据库操作
		public function author_edit_db($author_id, $achi_id, $page_type)
		{
			$AuthorModel = D('Author');
			if ($AuthorModel->create()) {
				$Condition['id'] = $author_id;
				$Result = $AuthorModel->where($Condition)->save();
				if ($Result == 0) {
					$this->error('您没有修改任何信息');
				} elseif ($Result > 0) {
					$this->success('修改作者信息成功', __ROOT__ . '/index.php/Home/Achievement/author_show/achi_id/' . $achi_id . '/page_type/' . $page_type);
				} else {
					$this->error($AuthorModel->getError());
				}
			} else {
				$this->error($AuthorModel->getError());
			}
		}

		//删除作者信息数据库操作
		public function author_delete($author_id, $achi_id)
		{
			$AuthorModel = D('Author');
			$Condition['id'] = $author_id;
			$Result = $AuthorModel->where($Condition)->delete();
			if ($Result) {
				$this->success('删除作者信息成功');
			} else {
				$this->error($AuthorModel->getError());
			}
		}

		//显示添加项目类别页面
		public function project_type()
		{
			parent::is_login();
			$TypeModel = M('Project_type');
			$TypeInfo = $TypeModel->select();
			$this->assign('TypeInfo', $TypeInfo);
			$this->display();
		}

		//添加项目类别数据库操作
		public function project_type_add()
		{
			$TypeModel = D('Project_type');
			if ($TypeModel->create()) {
				$Result = $TypeModel->add();
				if ($Result) {
					$this->success('新增项目类别信息成功');
				}
			} else {
				$this->error($TypeModel->getError());
			}
		}

		//删除项目类别信息数据库操作
		public function project_type_delete($type_id)
		{
			$TypeModel = M('Project_type');
			$Condition['id'] = $type_id;
			$Result = $TypeModel->where($Condition)->delete();
			if ($Result) {
				$this->success('删除项目类别信息成功');
			} else {
				$this->error('删除项目类别信息失败');
			}
		}

		//显示添加项目信息页面
		public function project_add($achi_id)
		{
			parent::is_login();
			$TypeModel = M('Project_type');
			$TypeInfo = $TypeModel->select();
			$this->assign('TypeInfo', $TypeInfo);
			$this->assign('achi_id', $achi_id);
			$this->display();
		}

		//添加项目类别信息数据库操作
		public function project_add_db($achi_id, $type)
		{
			$ProjectModel = D('Project');
			$user_id = session('uid');
			$Count = I('post.num');
			if ($type == 2) {
				if ($Count == 0) {
					$this->error('您未添加任何信息');
				}
			}

			for ($i = 0; $i < $Count; $i++) {
				$Data['type_name'] = I('post.type_name_' . $i);
				$Data['project_num'] = I('post.project_num_' . $i);
				$Data['project_name'] = I('post.project_name_' . $i);
				$Data['content'] = I('post.content_' . $i);
				$Data['institute'] = I('post.institute_' . $i);
				$Data['owner'] = I('post.owner_' . $i);
				$Data['money'] = I('post.money_' . $i);
				$Data['user_id'] = $user_id;
				$Data['achievement_id'] = $achi_id;
				$ProjectModel->add($Data);
			}
			if ($type == 1) {
				$this->success('您可以在我的科研成果列表查看该成果了', __ROOT__ . '/index.php/Home/Achievement/my_achievement');
			} else {
				$this->success('新增科研成果所属项目信息成功');
			}
		}

		//显示查看修改成果所属项目信息页面
		public function project_show($achi_id, $page_type)
		{
			parent::is_login();
			//获取项目类别信息
			$TypeModel = M('Project_type');
			$TypeInfo = $TypeModel->select();
			$this->assign('TypeInfo', $TypeInfo);
			$this->assign('achi_id', $achi_id);
			//获取所属项目信息
			$ProjectModel = M('Project');
			$Condition['achievement_id'] = $achi_id;
			$ProjectInfo = $ProjectModel->where($Condition)->select();
			$this->assign('ProjectInfo', $ProjectInfo);
			$this->assign('page_type', $page_type);
			$this->display();
		}

		//显示编辑成果所属项目信息页面
		public function project_edit($project_id, $page_type)
		{
			parent::is_login();
			//获取项目类别信息
			$TypeModel = M('Project_type');
			$TypeInfo = $TypeModel->select();
			$this->assign('TypeInfo', $TypeInfo);
			$this->assign('achi_id', $project_id);
			//获取所属项目信息
			$ProjectModel = M('Project');
			$Condition['id'] = $project_id;
			$ProjectInfo = $ProjectModel->where($Condition)->find();
			$this->assign('ProjectInfo', $ProjectInfo);
			$this->assign('page_type', $page_type);
			$this->display();
		}

		//编辑成果所属信息数据库操作
		public function project_edit_db($project_id, $achi_id, $page_type)
		{
			$ProjectModel = D('Project');
			if ($ProjectModel->create()) {
				$Condition['id'] = $project_id;
				$Result = $ProjectModel->where($Condition)->save();
				if ($Result) {
					$this->success('修改所属项目信息成功', __ROOT__ . '/index.php/Home/Achievement/project_show/achi_id/' . $achi_id . '/page_type/' . $page_type);
				} else {
					$this->error($ProjectModel->getError());
				}
			} else {
				$this->error($ProjectModel->getError());
			}
		}

		//删除成果所属信息数据库操作
		public function project_delete($project_id)
		{
			$ProjectModel = M('Project');
			$Condition['id'] = $project_id;
			$Result = $ProjectModel->where($Condition)->delete();
			if ($Result) {
				$this->success('删除所属项目信息成功');
			} else {
				$this->error('删除所属项目信息失败');
			}
		}

		//添加科研成果收藏
		public function add_favorite($achi_id)
		{
			$FavModel = D('Favorite');
			$FavModel->user_id = session('uid');
			$FavModel->achievement_id = $achi_id;
			$FavModel->type = 'Achievement';
			$Result = $FavModel->add();
			if ($Result) {
				$this->success('加入我的收藏成功');
			}
		}

		//显示添加期刊论文信息页面
		public function journal_paper_add($project_id = '')
		{
			parent::is_login();
			$this->assign("project_id", $project_id);
			$this->display();
		}

		//添加期刊论文数据库操作
		public function journal_paper_add_db($project_id = '')
		{
			$JournalModel = D('Journalpaper');
			$AchievementModel = D('Achievement');
			$userNum = session("userNum");
			if ($JournalModel->create()) {
				$JournalModel->user_number = $userNum;
				$Inclu = '';//收录情况
				foreach ($JournalModel->inbox_status as $value) {
					$Inclu = $Inclu . $value . ';';
				}
				$JournalModel->inbox_status = $Inclu;
				//sql事务
				$JournalModel->startTrans();
				$ResultJournal = $JournalModel->add();//添加信息到期刊论文数据表
				//赋值成果汇总模型类
				$AchievementModel->achievement_id = $ResultJournal;
				$AchievementModel->user_number = $userNum;
				$AchievementModel->achievement_type = 1;
				$AchievementModel->title = $_POST['title_zh'];
				$AchievementModel->institute_name = $_POST['journal_name'];
				$AchievementModel->publish_time = $_POST['publish_date'];
				if (!empty($project_id)) {
					$AchievementModel->project_id = $project_id;
				}
				$ResultAchi = $AchievementModel->add();
				if ($ResultJournal && $ResultAchi) {
					$JournalModel->commit();
					$this->success('添加期刊论文成功，请添加作者信息', __ROOT__ . '/index.php/Home/Achievement/author_add/achi_id/' . $ResultAchi);
				} else {
					$JournalModel->rollback();
					$this->error('添加期刊论文失败,请检查信息后重新保存');
				}
			} else {
				$this->error($JournalModel->getError());
			}
		}

		//查看期刊论文详细信息
		public function journal_paper_show($achi_id)
		{
			parent::is_login();
			$JournalModel = M('Journalpaper');
			$Condition['id'] = $achi_id;
			$JournalInfo = $JournalModel->where($Condition)->find();
			//添加其他详细信息
			$JournalInfo['achievement_type'] = '期刊论文';
			$this->assign('JournalInfo', $JournalInfo);
			//添加相关操作信息
			$this->assign('id', $JournalInfo['id']);
			$this->assign('edit', 'journal_paper_edit');
			$this->assign('delete', 'journal_paper_delete');
			$this->assign('show', 'journal_paper_show');

			//获取全文电子文档路径信息
			$FilePath = get_main_file_path($achi_id);
			$this->assign('FilePath', $FilePath);
			$this->display();
		}

		//显示期刊论文基本信息修改页面
		public function journal_paper_edit($achi_id)
		{
			parent::is_login();
			$JournalModel = D('Journalpaper');
			$Condition['id'] = $achi_id;
			$JournalInfo = $JournalModel->where($Condition)->find();
			$Content = get_sub_content($JournalInfo['inbox_status']);//获取拆分后内容
			$Content = get_inbox_status($Content);//获取收录情况数组
			$this->assign('Content', $Content);
			$this->assign('JournalInfo', $JournalInfo);
			$this->display();
		}

		//期刊论文基本信息修改数据库操作
		public function journal_paper_edit_db($achi_id)
		{
			$JournalModel = D('Journalpaper');
			$AchievementModel = D('Achievement');
			if ($JournalModel->create()) {
				$JournalModel->user_id = session('uid');
				$Inclu = '';//收录情况
				foreach ($JournalModel->inbox_status as $value) {
					$Inclu = $Inclu . $value . ';';
				}
				$JournalModel->inbox_status = $Inclu;
				//赋值成果汇总表模型类
				$AchievementModel->achievement_id = $achi_id;
				$AchievementModel->user_id = session('uid');
				$AchievementModel->achievement_type = 'JournalPaper';
				$AchievementModel->title = $JournalModel->title_zh;
				$AchievementModel->institute_name = $JournalModel->journal_name;
				$AchievementModel->publish_time = $JournalModel->publish_date;
				$ConditionJ['id'] = $achi_id;
				$ConditionA['achievement_id'] = $achi_id;
				//SQL操作
				$ResultJournal = $JournalModel->where($ConditionJ)->save();
				$ResultAchi = $AchievementModel->where($ConditionA)->save();
				if ($ResultJournal > 0) {
					$this->success('论文信息修改成功', __ROOT__ . '/index.php/Home/Achievement/journal_paper_show/achi_id/' . $achi_id);
				} else if ($ResultJournal == 0) {
					$this->error('您没有修改任何信息');
				} else {
					$this->error('论文信息修改失败');
				}
			} else {
				$this->error($JournalModel->getError());
			}
		}

		//删除期刊论文成果信息
		public function journal_paper_delete($achi_id)
		{
			$JournalModel = M('Journalpaper');
			$Condition['id'] = $achi_id;
			$JournalModel->where($Condition)->delete();
			//删除相关作者，文件，所属项目，成果汇总信息
			delete_all_info($achi_id);
			$this->success('删除该科研成果成功', __ROOT__ . '/index.php/Home/Achievement/my_achievement');
		}

		//显示会议论文添加页面
		public function conference_paper_add($project_id = '')
		{
			parent::is_login();
			$this->assign("project_id", $project_id);
			$this->display();
		}

		//添加会议论文基本信息数据库操作
		public function conference_paper_add_db($project_id = '')
		{
			$ConferenceModel = D('Conferencepaper');
			$AchievementModel = D('Achievement');
			$userNum = session("userNum");
			if ($ConferenceModel->create()) {
				$ConferenceModel->user_number= $userNum;
				$Inclu = '';//收录情况
				foreach ($ConferenceModel->inbox_status as $value) {
					$Inclu = $Inclu . $value . ';';
				}
				$ConferenceModel->inbox_status = $Inclu;
				//sql事务
				$ConferenceModel->startTrans();
				$ResultConference = $ConferenceModel->add();//添加信息到期刊论文数据表
				//赋值成果汇总模型类
				$AchievementModel->achievement_id = $ResultConference;
				$AchievementModel->user_number= $userNum;
				$AchievementModel->achievement_type = 2;
				$AchievementModel->title = $_POST['title_zh'];
				$AchievementModel->institute_name = $_POST['conference_name'];
				$AchievementModel->publish_time = $_POST['publish_date'];
				if (!empty($project_id)) {
					$AchievementModel->project_id = $project_id;
				}
				$ResultAchi = $AchievementModel->add();
				if ($ResultConference && $ResultAchi) {
					$ConferenceModel->commit();
					$this->success('添加会议论文成功，请添加作者信息', __ROOT__ . '/index.php/Home/Achievement/author_add/achi_id/' . $ResultAchi);
				} else {
					$ConferenceModel->rollback();
					$this->error('添加会议论文失败,请检查信息后重新保存');
				}
			} else {
				$this->error($ConferenceModel->getError());
			}
		}

		//显示会议论文详情页
		public function conference_paper_show($achi_id)
		{
			parent::is_login();
			$ConferenceModel = M('Conferencepaper');
			$Condition['id'] = $achi_id;
			$ConferenceInfo = $ConferenceModel->where($Condition)->find();
			//添加其他详细信息
			$ConferenceInfo['achievement_type'] = '会议论文';
			$this->assign('ConferenceInfo', $ConferenceInfo);
			//添加相关操作信息
			$this->assign('id', $ConferenceInfo['id']);
			$this->assign('edit', 'conference_paper_edit');
			$this->assign('delete', 'conference_paper_delete');
			$this->assign('show', 'conference_paper_show');

			//获取全文电子文档路径信息
			$FilePath = get_main_file_path($achi_id);
			$this->assign('FilePath', $FilePath);
			$this->display();
		}

		//显示会议论文编辑页面
		public function conference_paper_edit($achi_id)
		{
			parent::is_login();
			$ConferenceModel = D('Conferencepaper');
			$Condition['id'] = $achi_id;
			$ConferenceInfo = $ConferenceModel->where($Condition)->find();
			$Content = get_sub_content($ConferenceInfo['inbox_status']);//获取拆分后内容
			$Content = get_inbox_status($Content);//获取收录情况数组
			$this->assign('Content', $Content);
			$this->assign('ConferenceInfo', $ConferenceInfo);
			$this->display();
		}

		//会议论文修改功能
		public function conference_paper_edit_db($achi_id)
		{
			$ConferenceModel = D('Conferencepaper');
			$AchievementModel = D('Achievement');
			if ($ConferenceModel->create()) {
				$ConferenceModel->user_id = session('uid');
				$Inclu = '';//收录情况
				foreach ($ConferenceModel->inbox_status as $value) {
					$Inclu = $Inclu . $value . ';';
				}
				$ConferenceModel->inbox_status = $Inclu;
				//赋值成果汇总表模型类
				$AchievementModel->achievement_id = $achi_id;
				$AchievementModel->title = $ConferenceModel->title_zh;
				$AchievementModel->institute_name = $ConferenceModel->conference_name;
				$AchievementModel->publish_time = $ConferenceModel->publish_date;
				$ConditionJ['id'] = $achi_id;
				$ConditionA['achievement_id'] = $achi_id;
				//SQL操作
				$Result = $ConferenceModel->where($ConditionJ)->save();
				$AchievementModel->where($ConditionA)->save();
				if ($Result > 0) {
					$this->success('信息修改成功', __ROOT__ . '/index.php/Home/Achievement/conference_paper_show/achi_id/' . $achi_id);
				} else if ($Result == 0) {
					$this->error('您没有修改任何信息');
				} else {
					$this->error('论文信息修改失败');
				}
			} else {
				$this->error($ConferenceModel->getError());
			}
		}

		//删除会议论文信息
		public function conference_paper_delete($achi_id)
		{
			$ConferenceModel = M('Conferencepaper');
			$Condition['id'] = $achi_id;
			$ConferenceModel->where($Condition)->delete();
			//删除相关作者，文件，所属项目，成果汇总信息
			delete_all_info($achi_id);
			$this->success('删除该科研成果成功', __ROOT__ . '/index.php/Home/Achievement/my_achievement');
		}

		//显示学术专著录入界面
		public function monograph_add($project_id = '')
		{
			parent::is_login();
			$this->assign("project_id", $project_id);
			$this->display();
		}

		//添加学术专著信息数据库操作
		public function monograph_add_db($project_id = '')
		{
			$MonographModel = D('Monograph');
			$AchievementModel = D('Achievement');
			$user_number=session("userNum");
			if ($MonographModel->create()) {
				$MonographModel->user_number = $user_number;
				//sql事务
				$MonographModel->startTrans();
				$ResultMonograph = $MonographModel->add();//添加信息到期刊论文数据表
				//赋值成果汇总模型类
				$AchievementModel->achievement_id = $ResultMonograph;
				$AchievementModel->user_id = $user_number;
				$AchievementModel->achievement_type = 3;
				$AchievementModel->title = $_POST['title_zh'];
				$AchievementModel->institute_name = $_POST['publisher'];
				$AchievementModel->publish_time = $_POST['publish_date'];
				if (!empty($project_id)) {
					$AchievementModel->project_id = $project_id;
				}
				$ResultAchi = $AchievementModel->add();
				if ($ResultMonograph && $ResultAchi) {
					$MonographModel->commit();
					$this->success('添加学术专著成功，请添加作者信息', __ROOT__ . '/index.php/Home/Achievement/author_add/achi_id/' . $ResultAchi);
				} else {
					$MonographModel->rollback();
					$this->error('添加学术专著失败');
				}
			} else {
				$this->error($MonographModel->getError());
			}
		}

		//显示学术专著详情页面
		public function monograph_show($achi_id)
		{
			parent::is_login();
			$MonographModel = M('Monograph');
			$Condition['id'] = $achi_id;
			$MonographInfo = $MonographModel->where($Condition)->find();
			//添加其他详细信息
			$MonographInfo['achievement_type'] = '学术专著';
			$this->assign('MonographInfo', $MonographInfo);
			//添加相关操作信息参数
			$this->assign('id', $MonographInfo['id']);
			$this->assign('edit', 'monograph_edit');
			$this->assign('delete', 'monograph_delete');
			$this->assign('show', 'monograph_show');

			//获取全文电子文档路径信息
			$FilePath = get_main_file_path($achi_id);
			$this->assign('FilePath', $FilePath);
			$this->display();
		}

		//显示学术专著编辑页面
		public function monograph_edit($achi_id)
		{
			parent::is_login();
			$MonographModel = D('Monograph');
			$Condition['id'] = $achi_id;
			$MonographInfo = $MonographModel->where($Condition)->find();
			$this->assign('MonographInfo', $MonographInfo);
			$this->display();
		}

		//学术专著编辑数据库操作
		public function monograph_edit_db($achi_id)
		{
			$MonographModel = D('Monograph');
			$AchievementModel = D('Achievement');
			if ($MonographModel->create()) {
				//赋值成果汇总表模型类
				$AchievementModel->achievement_id = $achi_id;
				$AchievementModel->title = $MonographModel->title_zh;
				$AchievementModel->institute_name = $MonographModel->publisher;
				$AchievementModel->publish_time = $MonographModel->publish_date;
				$ConditionJ['id'] = $achi_id;
				$ConditionA['achievement_id'] = $achi_id;
				//SQL操作
				$Result = $MonographModel->where($ConditionJ)->save();
				$AchievementModel->where($ConditionA)->save();
				if ($Result > 0) {
					$this->success('信息修改成功', __ROOT__ . '/index.php/Home/Achievement/monograph_show/achi_id/' . $achi_id);
				} else if ($Result == 0) {
					$this->error('您没有修改任何信息');
				} else {
					$this->error('信息修改失败');
				}
			} else {
				$this->error($MonographModel->getError());
			}
		}

		//学术专著删除
		public function monograph_delete($achi_id)
		{
			$MonographModel = M('Monograph');
			$Condition['id'] = $achi_id;
			$MonographModel->where($Condition)->delete();
			//删除相关作者，文件，所属项目，成果汇总信息
			delete_all_info($achi_id);
			$this->success('删除该科研成果成功', __ROOT__ . '/index.php/Home/Achievement/my_achievement');
		}

		//显示专利添加页面
		public function patent_add($project_id = '')
		{
			parent::is_login();
			$this->assign("project_id", $project_id);
			$this->display();
		}

		//添加专利信息数据库操作
		public function patent_add_db($project_id = '')
		{
			$PatentModel = D('Patent');
			$AchievementModel = D('Achievement');
			$userNum = session("userNum");
			if ($PatentModel->create()) {
				$PatentModel->user_number = $userNum;
				//sql事务
				$PatentModel->startTrans();
				$ResultPatent = $PatentModel->add();//添加信息到期刊论文数据表
				//赋值成果汇总模型类
				$AchievementModel->achievement_id = $ResultPatent;
				$AchievementModel->user_number = $userNum;
				$AchievementModel->achievement_type = 4;
				$AchievementModel->title = $_POST['title_zh'];
				$AchievementModel->institute_name = $_POST['publisher'];
				$AchievementModel->publish_time = $_POST['apply_date'];
				if (!empty($project_id)) {
					$AchievementModel->project_id = $project_id;
				}
				$ResultAchi = $AchievementModel->add();
				if ($ResultPatent && $ResultAchi) {
					$PatentModel->commit();
					$this->success('添加专利成功，请添加作者信息', __ROOT__ . '/index.php/Home/Achievement/author_add/achi_id/' . $ResultAchi);
				} else {
					$PatentModel->rollback();
					$this->error('添加专利失败');
				}
			} else {
				$this->error($PatentModel->getError());
			}
		}

		//显示专利详情页面
		public function patent_show($achi_id)
		{
			parent::is_login();
			$PatentModel = M('Patent');
			$Condition['id'] = $achi_id;
			$PatentInfo = $PatentModel->where($Condition)->find();
			//添加其他详细信息
			$PatentInfo['achievement_type'] = '专利';
			$this->assign('PatentInfo', $PatentInfo);
			//添加相关操作信息参数
			$this->assign('id', $PatentInfo['id']);
			$this->assign('edit', 'patent_edit');
			$this->assign('delete', 'patent_delete');
			$this->assign('show', 'patent_show');

			//获取全文电子文档路径信息
			$FilePath = get_main_file_path($achi_id);
			$this->assign('FilePath', $FilePath);
			$this->display();
		}

		//显示专利修改页面
		public function patent_edit($achi_id)
		{
			parent::is_login();
			$PatentModel = D('Patent');
			$Condition['id'] = $achi_id;
			$PatentInfo = $PatentModel->where($Condition)->find();
			$this->assign('PatentInfo', $PatentInfo);
			$this->display();
		}

		//专利信息修改数据库操作
		public function patent_edit_db($achi_id)
		{
			$PatentModel = D('Patent');
			$AchievementModel = D('Achievement');
			if ($PatentModel->create()) {
				//检测成果转化状态是否变化
				if ($PatentModel->status == '申请') {
					$PatentModel->tran_status = '';
					$PatentModel->price = null;
				}
				//赋值成果汇总表模型类
				$AchievementModel->achievement_id = $achi_id;
				$AchievementModel->title = $PatentModel->title_zh;
				$AchievementModel->institute_name = $PatentModel->publisher;
				$AchievementModel->publish_time = $PatentModel->apply_date;
				$ConditionJ['id'] = $achi_id;
				$ConditionA['achievement_id'] = $achi_id;
				//SQL操作
				$Result = $PatentModel->where($ConditionJ)->save();
				$AchievementModel->where($ConditionA)->save();
				if ($Result > 0) {
					$this->success('信息修改成功', __ROOT__ . '/index.php/Home/Achievement/patent_show/achi_id/' . $achi_id);
				} else if ($Result == 0) {
					$this->error('您没有修改任何信息');
				} else {
					$this->error('信息修改失败');
				}
			} else {
				$this->error($PatentModel->getError());
			}
		}

		//专利信息删除功能
		public function patent_delete($achi_id)
		{
			$PatentModel = M('Patent');
			$Condition['id'] = $achi_id;
			$PatentModel->where($Condition)->delete();
			//删除相关作者，文件，所属项目，成果汇总信息
			delete_all_info($achi_id);
			$this->success('删除该科研成果成功', __ROOT__ . '/index.php/Home/Achievement/my_achievement');
		}

		//显示会议报告添加功能
		public function confernece_report_add($project_id = '')
		{
			parent::is_login();
			$this->assign("project_id", $project_id);
			$this->display();
		}

		public function conference_report_add_db($project_id = '')
		{
			$ConferencereportModel = D('Conferencereport');
			$AchievementModel = D('Achievement');
			$user_number=session('userNum');
			if ($ConferencereportModel->create()) {
				$ConferencereportModel->user_id = $user_number;
				//sql事务
				$ConferencereportModel->startTrans();
				$ResultConferencereport = $ConferencereportModel->add();//添加信息到期刊论文数据表
				//赋值成果汇总模型类
				$AchievementModel->achievement_id = $ResultConferencereport;
				$AchievementModel->user_number= $user_number;
				$AchievementModel->achievement_type =5;
				$AchievementModel->title = $_POST['title_zh'];
				$AchievementModel->institute_name = $_POST['conference_zh'];
				$AchievementModel->publish_time = $_POST['start_date'];
				if (!empty($project_id)) {
					$AchievementModel->project_id = $project_id;
				}
				$ResultAchi = $AchievementModel->add();
				if ($ResultConferencereport && $ResultAchi) {
					$ConferencereportModel->commit();
					$this->success('添加会议报告成功，请添加作者信息', __ROOT__ . '/index.php/Home/Achievement/author_add/achi_id/' . $ResultAchi);
				} else {
					$ConferencereportModel->rollback();
					$this->error('添加会议报告失败');
				}
			} else {
				$this->error($ConferencereportModel->getError());
			}
		}

		//显示会议报告详情页面
		public function conference_report_show($achi_id)
		{
			parent::is_login();
			$ConferencereportModel = M('Conferencereport');
			$Condition['id'] = $achi_id;
			$ReportInfo = $ConferencereportModel->where($Condition)->find();
			//添加其他详细信息
			$ReportInfo['achievement_type'] = '专利';
			$this->assign('ReportInfo', $ReportInfo);
			//添加相关操作信息参数
			$this->assign('id', $ReportInfo['id']);
			$this->assign('edit', 'conference_report_edit');
			$this->assign('delete', 'conference_report_delete');
			$this->assign('show', 'conference_report_show');
			//获取全文电子文档路径信息
			$FilePath = get_main_file_path($achi_id);
			$this->assign('FilePath', $FilePath);
			$this->display();
		}

		//显示会议报告修改页面
		public function conference_report_edit($achi_id)
		{
			parent::is_login();
			$ConferencereportModel = D('Conferencereport');
			$Condition['id'] = $achi_id;
			$ReportInfo = $ConferencereportModel->where($Condition)->find();
			$this->assign('ReportInfo', $ReportInfo);
			$this->display();
		}

		//会议报告修改数据库操作
		public function conference_report_edit_db($achi_id)
		{
			$ConferencereportModel = D('Conferencereport');
			$AchievementModel = D('Achievement');
			if ($ConferencereportModel->create()) {

				//赋值成果汇总表模型类
				$AchievementModel->achievement_id = $achi_id;
				$AchievementModel->title = $ConferencereportModel->title_zh;
				$AchievementModel->institute_name = $ConferencereportModel->conference_zh;
				$AchievementModel->publish_time = $ConferencereportModel->start_date;
				$ConditionJ['id'] = $achi_id;
				$ConditionA['achievement_id'] = $achi_id;
				//SQL操作
				$Result = $ConferencereportModel->where($ConditionJ)->save();
				$AchievementModel->where($ConditionA)->save();
				if ($Result > 0) {
					$this->success('信息修改成功', __ROOT__ . '/index.php/Home/Achievement/conference_report_show/achi_id/' . $achi_id);
				} else if ($Result == 0) {
					$this->error('您没有修改任何信息');
				} else {
					$this->error('信息修改失败');
				}
			} else {
				$this->error($ConferencereportModel->getError());
			}
		}

		//会议报告删除
		public function conference_report_delete($achi_id)
		{
			$ConferencereportModel = M('Conferencereport');
			$Condition['id'] = $achi_id;
			$ConferencereportModel->where($Condition)->delete();
			//删除相关作者，文件，所属项目，成果汇总信息
			delete_all_info($achi_id);
			$this->success('删除该科研成果成功', __ROOT__ . '/index.php/Home/Achievement/my_achievement');
		}

		//显示标准添加页面
		public function standard_add()
		{
			parent::is_login();
			$this->display();
		}

		//标准添加数据库操作
		public function standard_add_db()
		{
			$StandardModel = D('Standard');
			$AchievementModel = D('Achievement');
			$user_number=session('userNum');
			if ($StandardModel->create()) {
				$StandardModel->user_number= $user_number;
				//sql事务
				$StandardModel->startTrans();
				$ResultStandard = $StandardModel->add();//添加信息到数据表
				//赋值成果汇总模型类
				$AchievementModel->achievement_id = $ResultStandard;
				$AchievementModel->user_number= $user_number;
				$AchievementModel->achievement_type =6;
				$AchievementModel->title = $_POST['title_zh'];
				$AchievementModel->institute_name = $_POST['institute'];
				$AchievementModel->publish_time = $_POST['publish_date'];

				$ResultAchi = $AchievementModel->add();
				if ($ResultStandard && $ResultAchi) {
					$StandardModel->commit();
					$this->success('添加标准成功，请添加作者信息', __ROOT__ . '/index.php/Home/Achievement/author_add/achi_id/' . $ResultAchi);
				} else {
					$StandardModel->rollback();
					$this->error('添加标准失败');
				}
			} else {
				$this->error($StandardModel->getError());
			}
		}

		//显示标准详情
		public function standard_show($achi_id)
		{
			parent::is_login();
			$StandardModel = M('Standard');
			$Condition['id'] = $achi_id;
			$StandardInfo = $StandardModel->where($Condition)->find();
			//添加其他详细信息
			$StandardInfo['achievement_type'] = '标准';
			$this->assign('StandardInfo', $StandardInfo);
			//添加相关操作信息参数
			$this->assign('id', $StandardInfo['id']);
			$this->assign('edit', 'standard_edit');
			$this->assign('delete', 'standard_delete');
			$this->assign('show', 'standard_show');
			//获取全文电子文档路径信息
			$FilePath = get_main_file_path($achi_id);
			$this->assign('FilePath', $FilePath);
			$this->display();
		}

		//显示标准修改页面
		public function standard_edit($achi_id)
		{
			parent::is_login();
			$StandardModel = D('Standard');
			$Condition['id'] = $achi_id;
			$StandardInfo = $StandardModel->where($Condition)->find();
			$this->assign('StandardInfo', $StandardInfo);
			$this->display();
		}

		//标准修改数据库操作
		public function standard_edit_db($achi_id)
		{
			$StandardModel = D('Standard');
			$AchievementModel = D('Achievement');
			if ($StandardModel->create()) {
				//如果为国际标准，清空标准类型
				if ($StandardModel->country == '国际标准') {
					$StandardModel->standard_type = null;
				}
				//赋值成果汇总表模型类
				$AchievementModel->achievement_id = $achi_id;
				$AchievementModel->title = $StandardModel->title_zh;
				$AchievementModel->institute_name = $StandardModel->institute;
				$AchievementModel->publish_time = $StandardModel->publish_date;
				$ConditionJ['id'] = $achi_id;
				$ConditionA['achievement_id'] = $achi_id;
				//SQL操作
				$Result = $StandardModel->where($ConditionJ)->save();
				$AchievementModel->where($ConditionA)->save();
				if ($Result > 0) {
					$this->success('信息修改成功', __ROOT__ . '/index.php/Home/Achievement/standard_show/achi_id/' . $achi_id);
				} else if ($Result == 0) {
					$this->error('您没有修改任何信息');
				} else {
					$this->error('信息修改失败');
				}
			} else {
				$this->error($StandardModel->getError());
			}
		}

		//删除标准信息
		public function standard_delete($achi_id)
		{
			$StandardModel = M('Standard');
			$Condition['id'] = $achi_id;
			$StandardModel->where($Condition)->delete();
			//删除相关作者，文件，所属项目，成果汇总信息
			delete_all_info($achi_id);
			$this->success('删除该科研成果成功', __ROOT__ . '/index.php/Home/Achievement/my_achievement');
		}

		//显示软件著作权新增页面
		public function software_add()
		{
			parent::is_login();
			$this->display();
		}

		//新增软件著作权数据库操作
		public function software_add_db()
		{
			$SoftwareModel = D('Software');
			$AchievementModel = D('Achievement');
			$user_number=session('userNum');
			if ($SoftwareModel->create()) {
				$SoftwareModel->user_number =$user_number;//sql事务
				$SoftwareModel->startTrans();
				$ResultSoftware = $SoftwareModel->add();//添加信息到期刊论文数据表
				//赋值成果汇总模型类
				$AchievementModel->achievement_id = $ResultSoftware;
				$AchievementModel->user_number =$user_number;
				$AchievementModel->achievement_type =7;
				$AchievementModel->title = $_POST['title_zh'];
				$AchievementModel->institute_name = $_POST['reg_num'];
				$AchievementModel->publish_time = $_POST['over_date'];

				$ResultAchi = $AchievementModel->add();
				if ($ResultSoftware && $ResultAchi) {
					$SoftwareModel->commit();
					$this->success('添加软件著作权成功，请添加作者信息', __ROOT__ . '/index.php/Home/Achievement/author_add/achi_id/' . $ResultAchi);
				} else {
					$SoftwareModel->rollback();
					$this->error('添加软件著作权失败');
				}
			} else {
				$this->error($SoftwareModel->getError());
			}
		}

		//软件著作权详情显示
		public function software_show($achi_id)
		{
			parent::is_login();
			$SoftwareModel = M('Software');
			$Condition['id'] = $achi_id;
			$SoftwareInfo = $SoftwareModel->where($Condition)->find();
			//添加其他详细信息
			$SoftwareInfo['achievement_type'] = '软件著作权';
			$this->assign('SoftwareInfo', $SoftwareInfo);
			//添加相关操作信息参数
			$this->assign('id', $SoftwareInfo['id']);
			$this->assign('edit', 'software_edit');
			$this->assign('delete', 'software_delete');
			$this->assign('show', 'software_show');
			//获取全文电子文档路径信息
			$FilePath = get_main_file_path($achi_id);
			$this->assign('FilePath', $FilePath);
			$this->display();
		}

		//软件著作权编辑页面
		public function software_edit($achi_id)
		{
			parent::is_login();
			$SoftwareModel = D('Software');
			$Condition['id'] = $achi_id;
			$SoftwareInfo = $SoftwareModel->where($Condition)->find();
			$this->assign('SoftwareInfo', $SoftwareInfo);
			$this->display();
		}

		//软件著作权修改页面
		public function software_edit_db($achi_id)
		{
			$SoftwareModel = D('Software');
			$AchievementModel = D('Achievement');
			if ($SoftwareModel->create()) {
				//赋值成果汇总表模型类
				$AchievementModel->achievement_id = $achi_id;
				$AchievementModel->title = $SoftwareModel->title_zh;
				$AchievementModel->institute_name = $SoftwareModel->reg_num;
				$AchievementModel->publish_time = $SoftwareModel->over_date;
				$ConditionJ['id'] = $achi_id;
				$ConditionA['achievement_id'] = $achi_id;
				//SQL操作
				$Result = $SoftwareModel->where($ConditionJ)->save();
				$AchievementModel->where($ConditionA)->save();
				if ($Result > 0) {
					$this->success('信息修改成功', __ROOT__ . '/index.php/Home/Achievement/software_show/achi_id/' . $achi_id);
				} else if ($Result == 0) {
					$this->error('您没有修改任何信息');
				} else {
					$this->error('信息修改失败');
				}
			} else {
				$this->error($SoftwareModel->getError());
			}
		}

		//软件著作权删除
		public function software_delete($achi_id)
		{
			$SoftwareModel = M('Software');
			$Condition['id'] = $achi_id;
			$SoftwareModel->where($Condition)->delete();
			//删除相关作者，文件，所属项目，成果汇总信息
			delete_all_info($achi_id);
			$this->success('删除该科研成果成功', __ROOT__ . '/index.php/Home/Achievement/my_achievement');
		}

		//显示新增科研奖励页面
		public function reward_add()
		{
			parent::is_login();
			$this->display();
		}

		//新增科研奖励数据库操作
		public function reward_add_db()
		{
			$RewardModel = D('Reward');
			$AchievementModel = D('Achievement');
			$user_number=session('userNum');
			if ($RewardModel->create()) {
				$RewardModel->user_number= $user_number;
				//sql事务
				$RewardModel->startTrans();
				$ResultReward = $RewardModel->add();//添加信息到数据表
				//赋值成果汇总模型类
				$AchievementModel->achievement_id = $ResultReward;
				$AchievementModel->user_number =$user_number;
				$AchievementModel->achievement_type = 8;
				$AchievementModel->title = $_POST['title_zh'];
				$AchievementModel->institute_name = $_POST['institute'];
				$AchievementModel->publish_time = $_POST['publish_date'];

				$ResultAchi = $AchievementModel->add();
				if ($ResultReward && $ResultAchi) {
					$RewardModel->commit();
					$this->success('添加科研奖励成功，请添加作者信息', __ROOT__ . '/index.php/Home/Achievement/author_add/achi_id/' . $ResultAchi);
				} else {
					$RewardModel->rollback();
					$this->error('添加科研奖励失败');
				}
			} else {
				$this->error($RewardModel->getError());
			}
		}

		//显示科研奖励详情
		public function reward_show($achi_id)
		{
			parent::is_login();
			$RewardModel = M('Reward');
			$Condition['id'] = $achi_id;
			$RewardInfo = $RewardModel->where($Condition)->find();
			//添加其他详细信息
			$RewardInfo['achievement_type'] = '科研奖励';
			$this->assign('RewardInfo', $RewardInfo);
			//添加相关操作信息参数
			$this->assign('id', $RewardInfo['id']);
			$this->assign('edit', 'reward_edit');
			$this->assign('delete', 'reward_delete');
			$this->assign('show', 'reward_show');
			//获取全文电子文档路径信息
			$FilePath = get_main_file_path($achi_id);
			$this->assign('FilePath', $FilePath);
			$this->display();
		}

		//显示科研奖励编辑页面
		public function reward_edit($achi_id)
		{
			parent::is_login();
			$RewardModel = D('Reward');
			$Condition['id'] = $achi_id;
			$RewardInfo = $RewardModel->where($Condition)->find();
			$this->assign('RewardInfo', $RewardInfo);
			$this->display();
		}

		//科研奖励编辑数据库操作
		public function reward_edit_db($achi_id)
		{
			$RewardModel = D('Reward');
			$AchievementModel = D('Achievement');
			if ($RewardModel->create()) {
				//如果类型从其他改为别的，清空注明信息
				if ($RewardModel->reward_type != '其他') {
					$RewardModel->specific = null;
				}
				//赋值成果汇总表模型类
				$AchievementModel->achievement_id = $achi_id;
				$AchievementModel->title = $RewardModel->title_zh;
				$AchievementModel->institute_name = $RewardModel->institute;
				$AchievementModel->publish_time = $RewardModel->publish_date;
				$ConditionJ['id'] = $achi_id;
				$ConditionA['achievement_id'] = $achi_id;
				//SQL操作
				$Result = $RewardModel->where($ConditionJ)->save();
				$AchievementModel->where($ConditionA)->save();
				if ($Result > 0) {
					$this->success('信息修改成功', __ROOT__ . '/index.php/Home/Achievement/reward_show/achi_id/' . $achi_id);
				} else if ($Result == 0) {
					$this->error('您没有修改任何信息');
				} else {
					$this->error('信息修改失败');
				}
			} else {
				$this->error($RewardModel->getError());
			}
		}

		//科研奖励删除
		public function reward_delete($achi_id)
		{
			$RewardModel = M('Reward');
			$Condition['id'] = $achi_id;
			$RewardModel->where($Condition)->delete();
			//删除相关作者，文件，所属项目，成果汇总信息
			delete_all_info($achi_id);
			$this->success('删除该科研成果成功', __ROOT__ . '/index.php/Home/Achievement/my_achievement');
		}

		//显示举办或参加学术会议添加页面
		public function conference_involved_add()
		{
			parent::is_login();
			$this->display();
		}

		//举办或参加学术会议添加数据库操作
		public function conference_involved_add_db()
		{
			$ConModel = D('Conferenceinvolved');
			$AchievementModel = D('Achievement');
			$user_number=session('userNum');
			if ($ConModel->create()) {
				$ConModel->user_number=$user_number;
				//sql事务
				$ConModel->startTrans();
				$ResultCon = $ConModel->add();//添加信息到期刊论文数据表
				//赋值成果汇总模型类
				$AchievementModel->achievement_id = $ResultCon;
				$AchievementModel->user_number = $user_number;
				$AchievementModel->achievement_type = 9;
				$AchievementModel->title = $_POST['title_zh'];
				$AchievementModel->institute_name = $_POST['institute'];
				$AchievementModel->publish_time = $_POST['start_date'];

				$ResultAchi = $AchievementModel->add();
				if ($ResultCon && $ResultAchi) {
					$ConModel->commit();
					$this->success('添加举办或参加学术会议成功，请添加作者信息', __ROOT__ . '/index.php/Home/Achievement/author_add/achi_id/' . $ResultAchi);
				} else {
					$ConModel->rollback();
					$this->error('添加举办或参加学术会议失败');
				}
			} else {
				$this->error($ConModel->getError());
			}
		}

		//显示举办或参加学术会议详情页面
		public function conference_involved_show($achi_id)
		{
			parent::is_login();
			$ConModel = M('Conferenceinvolved');
			$Condition['id'] = $achi_id;
			$ConInfo = $ConModel->where($Condition)->find();
			//添加其他详细信息
			$ConInfo['achievement_type'] = '举办或参加学术会议';
			$this->assign('ConInfo', $ConInfo);
			//添加相关操作信息参数
			$this->assign('id', $ConInfo['id']);
			$this->assign('edit', 'conference_involved_edit');
			$this->assign('delete', 'conference_involved_delete');
			$this->assign('show', 'conference_involved_show');
			//获取全文电子文档路径信息
			$FilePath = get_main_file_path($achi_id);
			$this->assign('FilePath', $FilePath);
			$this->display();
		}

		//显示举办或参加学术会议修改页面
		public function conference_involved_edit($achi_id)
		{
			parent::is_login();
			$ConModel = D('Conferenceinvolved');
			$Condition['id'] = $achi_id;
			$ConInfo = $ConModel->where($Condition)->find();
			$this->assign('ConInfo', $ConInfo);
			$this->display();
		}

		//举办或参加学术会议修改数据库操作
		public function conference_involved_edit_db($achi_id)
		{
			$ConModel = D('Conferenceinvolved');
			$AchievementModel = D('Achievement');
			if ($ConModel->create()) {
				//赋值成果汇总表模型类
				$AchievementModel->achievement_id = $achi_id;
				$AchievementModel->title = $ConModel->title_zh;
				$AchievementModel->institute_name = $ConModel->institute;
				$AchievementModel->publish_time = $ConModel->start_date;
				$ConditionJ['id'] = $achi_id;
				$ConditionA['achievement_id'] = $achi_id;
				//SQL操作
				$Result = $ConModel->where($ConditionJ)->save();
				$AchievementModel->where($ConditionA)->save();
				if ($Result > 0) {
					$this->success('信息修改成功', __ROOT__ . '/index.php/Home/Achievement/conference_involved_show/achi_id/' . $achi_id);
				} else if ($Result == 0) {
					$this->error('您没有修改任何信息');
				} else {
					$this->error('信息修改失败');
				}
			} else {
				$this->error($ConModel->getError());
			}
		}

		//删除举办或参加学术会议信息
		public function conference_involved_delete($achi_id)
		{
			$ConModel = M('Conferenceinvolved');
			$Condition['id'] = $achi_id;
			$ConModel->where($Condition)->delete();
			//删除相关作者，文件，所属项目，成果汇总信息
			delete_all_info($achi_id);
			$this->success('删除该科研成果成功', __ROOT__ . '/index.php/Home/Achievement/my_achievement');
		}
	}