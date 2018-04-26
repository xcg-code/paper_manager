<?php

	namespace Home\Controller;

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
				$filePath = $this->uploadFile();
				if ($filePath != "") {
					$contribution->filePath = $filePath;
				}
				$UserModel=M("User");
				$condition['user_number']=$contribution->user_number;
				$approval_first=$UserModel->where($condition)->getField('teacher_id');
				$contribution->approval_first=$approval_first;
				$condition2['position']=0;
				$approval_second=$UserModel->where($condition2)->getField('user_number');
				$contribution->approval_second=$approval_second;
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

		public function uploadFile()
		{
			$upload = new Upload();// 实例化上传类
			$upload->maxSize = 20971520;// 设置附件上传大小 20MB
			$upload->exts = array('pdf', 'doc', 'docx', 'ppt', 'pptx','rar','zip','7z');// 设置附件上传类型
			$upload->rootPath = './Uploads/'; // 设置附件上传根目录,
			$upload->savePath = 'Contributions/'; // 设置附件上传（子）目录
			$upload->saveName = array('uniqid', '');
			$upload->autoSub = false;
			$info = $upload->uploadOne($_FILES['filePath']);
			$baseURL = "";
			// 上传文件
			if (!$info) {// 上传错误提示错误信息
				$this->error($upload->getError());
			} else {// 上传成功,保存文件信息
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
				$baseURL = 'Uploads/' . $info['savepath'] . $info['savename'];
			}
			return $baseURL;
		}

		//我的投稿
		public function myContributions()
		{
			parent::is_login();
			$contributions = M('Contributions');
			$list = $contributions->where("user_number='%s'", session('userNum'))->order('time desc')->select();
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
			$path = $conModel->where($Condition)->getField('filePath');
			$conModel->where($Condition)->delete();
			$this->file_delete($path);
			$this->Redirect('Home/Contributions/myContributions');
		}

		//删除已上传文件操作
		public function file_delete($path)
		{
			$FileModel = M('File');
			$Condition['path'] = $path;
			//删除数据库信息
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
			$list = $contributions->join('INNER JOIN think_user ON think_contributions.user_number=think_user.user_number')->where("approval_first='%s'", session('userNum'))->order('time desc')->select();
			$this->assign("list", $list);
			$this->display();
		}

		public function approval_process_detail($con_id){
			parent::is_login();
			$ConModel=M('Contributions');
			$Condition['think_contributions.id']=$con_id;
			$con=$ConModel->join('INNER JOIN think_user ON think_contributions.user_number=think_user.user_number')->where($Condition)->find();
			$this->assign("con",$con);
			$this->display();
		}


	}