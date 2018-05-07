<?php

	namespace Home\Controller;

	use Org\Util\Date;
	use Think\Controller;
	use Think\Upload;

	class ContributionsController extends Controller
	{
		//创建投稿
		public function createContributions()
		{
			parent::is_login();
			$this->display();
		}

		public function create()
		{
			$contribution = D("Contributions");
			if ($contribution->create()) {
				$contribution->user_number = session("userNum");
				$contribution->time = date("Y-m-d H:i:s");
				$file_id = $this->uploadFile();
				if ($file_id != 0) {
					$contribution->file_id = $file_id;
				}
				$UserModel = M("User");
				$condition['user_number'] = $contribution->user_number;
				$approval_first = $UserModel->where($condition)->getField('teacher_id');
				$contribution->approval_first = $approval_first;
				$condition2['position'] = 0;
				$approval_second = $UserModel->where($condition2)->getField('user_number');
				$contribution->approval_second = $approval_second;
				$result = $contribution->add();
				if ($result) {
					$this->redirect('/Home/Contributions/myContributions');
				} else {
					$this->error('提交数据库错误');
				}
			} else {
				$this->error('创建失败');
			}
		}

		public function uploadFile($id = '')
		{
			$upload = new Upload();// 实例化上传类
			$upload->maxSize = 20971520;// 设置附件上传大小 20MB
			$upload->exts = array('pdf', 'doc', 'docx', 'ppt', 'pptx', 'rar', 'zip', '7z');// 设置附件上传类型
			$upload->rootPath = './Uploads/'; // 设置附件上传根目录,
			$upload->savePath = 'Contributions/'; // 设置附件上传（子）目录
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
					$FileInfo['type'] = 'Contributions';
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

		//我的投稿
		public function myContributions()
		{
			parent::is_login();
			$contributions = M('Contributions');
			$list = $contributions->where("user_number='%s' and status<5", session('userNum'))->order('time desc')->select();
			$userName = session('name');
			$this->assign("list", $list);
			$this->assign('userName', $userName);
			$this->display();
		}

		//撤销投稿
		public function con_delete($id)
		{
			$conModel = M('Contributions');
			$Condition['id'] = $id;
			$file_id = $conModel->where($Condition)->getField('file_id');
			$conModel->where($Condition)->delete();
			$this->file_delete($file_id);
			$this->Redirect('Home/Contributions/myContributions');
		}

		//删除已上传文件操作
		public function file_delete($file_id)
		{
			$FileModel = M('File');
			$Condition['id'] = $file_id;
			//删除数据库信息
			$path = $FileModel->where($Condition)->getField('path');
			$FileModel->where($Condition)->delete();
			//物理地址
			$FilePath = substr(THINK_PATH, 0, -9) . $path;
			//删除物理文件
			unlink($FilePath);
		}

		//投稿审批列表
		public function approval_process()
		{
			parent::is_login();
			$contributions = M('Contributions');
			$condition['approval_first'] = session('userNum');
			$condition['status'] = 0;
			$list = $contributions->join('INNER JOIN think_user ON think_contributions.user_number=think_user.user_number')
				->where($condition)
				->Field('think_contributions.*,think_user.*,think_contributions.id as cid')
				->order('time desc')
				->select();
			$this->assign("list", $list);
			$this->display();
		}

		public function approval_process_second()
		{
			parent::is_login();
			$contributions = M('Contributions');
//			$condition['approval_second'] = session('userNum');
			$condition['status'] = 1;
			$list = $contributions->join('INNER JOIN think_user ON think_contributions.user_number=think_user.user_number')
				->where($condition)
				->Field('think_contributions.*,think_user.*,think_contributions.id as cid')
				->order('time desc')
				->select();
			$this->assign("list", $list);
			$this->display();
		}

		//审批详情
		public function approval_process_detail($con_id)
		{
			parent::is_login();
			$this->getFeedback($con_id);
//			$this->display();
		}

		public function detail($con_id)
		{
			$ConModel = M('Contributions');
			$Condition['think_contributions.id'] = $con_id;
			$con = $ConModel->join('INNER JOIN think_user ON think_contributions.user_number=think_user.user_number')
				->where($Condition)
				->Field('think_contributions.*,think_user.*,think_contributions.id as cid')
				->find();
			$this->assign("con", $con);
		}

		public function downloadFile($con_id)
		{
			parent::is_login();
			if ($con_id == '') {
				$this->ajaxReturn('下载失败');
				return;
			}
			$ConModel = M('Contributions');
			$condition['id'] = $con_id;
			$file_id = $ConModel->where($condition)->getField("file_id");
			$FileModel = M('File');
			$condition2['id'] = $file_id;
			$file = $FileModel->where($condition2)->find();
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

		//审批反馈
		public function approval_process_feedback($con_id)
		{
			parent::is_login();
			$this->getFeedback($con_id);
		}

		public function feedback($id)
		{
			$status = $_POST['result'];
			$feedback_content = $_POST['feedback_content'];
//			echo "id=".$id." status=".$status." content=".$feedback_content;
			$FeedModel = D('Feedback');
			$ConModel = M('Contributions');
			$UserModel = M('User');
			$stuNum = $ConModel->where('id="%d"', $id)->getField('user_number');
			$teacher_id = $UserModel->where('user_number="%d"', $stuNum)->getField("teacher_id");
			$admin_id = $UserModel->where('position=0')->getField('user_number');
			if ($FeedModel->create()) {
				$FeedModel->teacher_number = session('userNum');
				$FeedModel->affair_type = 'Contributions';
				$FeedModel->affair_id = $id;
				$FeedModel->feedback_content = $feedback_content;
				$FeedModel->time = date("Y-m-d H:i:s");
				if ($status == 1 || $status == 2) {
					$FeedModel->level = 1;
				} else {
					$FeedModel->level = 2;
				}
				$result = $FeedModel->add();
				if ($result) {
					$condition['id'] = $id;
					if ($teacher_id == $admin_id && $status == 1) {//如果导师是admin则直接无需二审
						$ConModel->where($condition)->setField('status', 3);
					} else {
						$ConModel->where($condition)->setField('status', $status);
					}
					$this->redirect('/Home/Contributions/approval_process');
				} else {
					$this->error('提交数据库错误');
				}
			} else {
				$this->error('数据库错误!');
			}
		}

		public function getTeacherByConId($con_id)
		{
			$UserModel = M('User');
			$ConModel = M('Contributions');
			$stuNum = $ConModel->where('id="%d"', $con_id)->getField('user_number');
			$teacher_id = $UserModel->where('user_number="%d"', $stuNum)->getField("teacher_id");
			$teacher_name = $UserModel->where('user_number=%d', $teacher_id)->getField('user_name');
			return $teacher_name;
		}

		public function getFeedback($id)
		{
			$this->detail($id);
			$FeedbackModel = M('Feedback');
			$condition['affair_type'] = 'Contributions';
			$condition['affair_id'] = $id;
			$con = $this->getContributionsById($id);
			if ($con['status'] == 1 || $con['status'] == 2) {
				$condition['level'] = 1;
			} else {
				$condition['level'] = 2;
			}
			$feedback = $FeedbackModel->where($condition)->find();
			$this->assign("feedback", $feedback);
			$teacher = $this->getTeacherByConId($id);
			$this->assign("teacher", $teacher);
			$this->display();

		}

		public function getContributionsById($id)
		{
			$ContributionsModel = M("Contributions");
			$condition['id'] = $id;
			$con = $ContributionsModel->where($condition)->find();
			return $con;
		}

		//论文投递记录
		public function deliver_record($id)
		{
			$ConModel = M('Contributions');
			//状态为5表示处于投递状态
			$ConModel->where('id=%d', $id)->setField("status", 5);
			$con = $ConModel->where('id=%d', $id)->find();
			$list = $this->getRecord($id);
			if ($list) {
				$this->assign("RecordInfo", $list);
			}
			$this->assign("con", $con);
			$this->display();
		}

		public function getRecord($id)
		{
			$DeliverModel = D('DeliverRecord');
			$list = $DeliverModel->join('LEFT JOIN think_file ON think_deliver_record.file_id=think_file.id')
				->where("think_deliver_record.con_id=%d", $id)
				->Field('think_deliver_record.*,think_file.name')
				->order('time desc')
				->select();
			return $list;
		}

		//正在投递的稿件
		public function myDeliver()
		{
			parent::is_login();
			$contributions = M('Contributions');
			$list = $contributions->where("user_number='%s' and status=5", session('userNum'))->order('time desc')->select();
			$userName = session('name');
			$this->assign("list", $list);
			$this->assign('userName', $userName);
			$this->display();
		}

		public function upload_record($id)
		{
			$DeliverModel = D('DeliverRecord');
			if ($DeliverModel->create()) {
				$DeliverModel->user_number = session(userNum);
				$DeliverModel->con_id = $id;
				$DeliverModel->time = date("Y-m-d H:i:s");
				$file_id = $this->uploadFile($id);
				if ($file_id != 0) {
					$DeliverModel->file_id = $file_id;
				}
				$result = $DeliverModel->add();
				if ($result) {
					$this->redirect('/Home/Contributions/deliver_record/id/' . $id);
				} else {
					$this->error('提交数据库错误');
				}
			} else {
				$this->error("创建数据错误");
			}

		}

		//删除record
		public function record_delete($id)
		{
			$conModel = M('DeliverRecord');
			$Condition['id'] = $id;
			$file_id = $conModel->where($Condition)->getField('file_id');
			$con_id = $conModel->where($Condition)->getField('con_id');
			$conModel->where($Condition)->delete();
			if(!empty($file_id)){
				$this->file_delete($file_id);
			}
			$this->Redirect('Home/Contributions/deliver_record/id/' . $con_id);
		}

		//下载record上传的文件
		public function download($id)
		{
			$conModel = M('DeliverRecord');
			$Condition['id'] = $id;
			$file_id = $conModel->where($Condition)->getField('file_id');
			$FileModel = M('File');
			$condition2['id'] = $file_id;
			$file = $FileModel->where($condition2)->find();
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

	}