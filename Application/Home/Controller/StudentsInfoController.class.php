<?php

	namespace Home\Controller;

	use Think\Controller;
	use Think\Upload;

	class StudentsInfoController extends Controller
	{
		//显示我的科研成果页面
		public function showStudents()
		{
			parent::is_login();
			$userModel = M('User');
			$students = $userModel->where('position=%d', 2)->select();
			$this->assign("students", $students);
			$this->display();
		}

		public function studentInfo($id)
		{
			parent::is_login();
			$UserModel=M('User');
			$student=$UserModel->where('user_number=%s',$id)->find();
			$this->assign("StudentInfo",$student);
			$AchiNum=get_achievement_count('',$id);
			$PrizeModel=M('Prize');
			$prizes=$PrizeModel->where('user_number=%s',$id)->select();
			$this->assign('prizeCount',count($prizes));
			$this->assign('prizes',$prizes);
			$this->assign('AchiAll', $AchiNum['All']);
			$this->display();
		}

		public function addStu()
		{
			parent::is_login();
			$this->display();
		}

		public function addStu_db()
		{
			$trainModel = D('TrainStudent');
			if ($trainModel->create()) {
				$trainModel->teacherNum = session('userNum');
				$result = $trainModel->add();
				if ($result) {
					$this->redirect("/Home/StudentsInfo/trainInfo");
				} else {
					$this->error("数据库错误");
				}
			} else {
				$this->error($trainModel->getError());
			}
		}

		public function trainInfo()
		{
			parent::is_login();
			$trainModel = M('TrainStudent');
			$Condition['teacherNum'] = session('userNum');
			$trainList = $trainModel->where($Condition)->order('id desc')->select();
			$this->assign("trainList", $trainList);
			$this->display();
		}

		public function student_delete($id)
		{
			$TrainStudentModel = M('TrainStudent');
			$Condition['id'] = $id;
			$result = $TrainStudentModel->where($Condition)->delete();
			if ($result) {
				$this->redirect("/Home/StudentsInfo/trainInfo");
			} else {
				$this->error($TrainStudentModel->getError());
			}

		}

		public function msg_record($id)
		{
			parent::is_login();
			$trainModel = M('TrainStudent');
			$Condition['id'] = $id;
			$TrainInfo = $trainModel->where($Condition)->find();
			$this->assign("TrainInfo", $TrainInfo);

			$MsgRecordModel = M('MsgRecord');
			$RecordInfo = $MsgRecordModel->join('LEFT JOIN think_file ON think_msg_record.file_id=think_file.id')
				->where('train_id=%d', $id)
				->field('think_msg_record.*,think_file.name')
				->order('date desc')
				->select();
			$this->assign("RecordInfo", $RecordInfo);
			$this->display();
		}

		//上传记录
		public function upload_record($id)
		{
			$MsgRecordModel = M('MsgRecord');
			if ($MsgRecordModel->create()) {
				$MsgRecordModel->train_id = $id;
				$MsgRecordModel->date = date('Y:m:d H:i:s');
				$file_id = $this->uploadFile();
				if ($file_id != 0) {
					$MsgRecordModel->file_id = $file_id;
				}
				$result = $MsgRecordModel->add();
				if ($result) {
					$this->redirect('/Home/StudentsInfo/msg_record/id/' . $id);
				} else {
					$this->error('提交数据库错误');
				}
			} else {
				$this->error($MsgRecordModel->getError());
			}

		}

		//上传文件
		public function uploadFile($id = '')
		{
			$upload = new Upload();// 实例化上传类
			$upload->maxSize = 20971520;// 设置附件上传大小 20MB
			$upload->exts = array('pdf', 'doc', 'docx', 'ppt', 'pptx', 'rar', 'zip', '7z', 'txt');// 设置附件上传类型
			$upload->rootPath = './Uploads/'; // 设置附件上传根目录,
			$upload->savePath = 'TrainStudent/'; // 设置附件上传（子）目录
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

		//删除记录
		public function record_delete($id)
		{
			$MsgRecordModel = M('MsgRecord');
			$Condition['id'] = $id;
			$file_id = $MsgRecordModel->where($Condition)->getField('file_id');
			$train_id = $MsgRecordModel->where($Condition)->getField('train_id');
			$MsgRecordModel->where($Condition)->delete();
			if (!empty($file_id)) {
				$this->file_delete($file_id);
			}
			$this->Redirect('Home/StudentsInfo/msg_record/id/' . $train_id);

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


	}