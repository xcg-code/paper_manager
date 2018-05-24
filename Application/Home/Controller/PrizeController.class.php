<?php

	namespace Home\Controller;

	use Think\Controller;
	use Think\Upload;

	class PrizeController extends Controller
	{
		public function prize_add()
		{
			parent::is_login();
			$this->display();
		}

		public function prize_add_db()
		{
			$PrizeModel=M('Prize');
			if($PrizeModel->create()){
				$PrizeModel->user_number=session('userNum');
				$PrizeModel->date=date('Y:m:d H:i:s');
				$file_id=$this->uploadFile();
				if ($file_id != 0||$file_id!='') {
					$PrizeModel->file_id = $file_id;
				}
				$result=$PrizeModel->add();
				if($result){
					$this->redirect('/Home/Prize/my_prize');
				}else{
					$this->error($PrizeModel->getError());
				}
			}else{
				$this->error($PrizeModel->getError());
			}
		}

		public function my_prize(){
			parent::is_login();
			$PrizeModel=M('Prize');
			$Condition['user_number']=session('userNum');
			$prizes=$PrizeModel->where($Condition)->select();
			$this->assign('prizes',$prizes);
			$this->display();
		}

		//显示我的科研成果页面
		public function my_prize1($achi_type = '', $achi_year = '', $user_id = '')
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

		//上传文件
		public function uploadFile($id = '')
		{
			$upload = new Upload();// 实例化上传类
			$upload->maxSize = 20971520;// 设置附件上传大小 20MB
			$upload->exts = array('pdf', 'jpg', 'jpeg', 'gif', 'png', 'bmp');// 设置附件上传类型
			$upload->rootPath = './Uploads/'; // 设置附件上传根目录,
			$upload->savePath = 'Prizes/'; // 设置附件上传（子）目录
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
			$PrizeModel = M('Prize');
			$Condition['id'] = $id;
			$file_id = $PrizeModel->where($Condition)->getField('file_id');
			$PrizeModel->where($Condition)->delete();
			if (!empty($file_id)) {
				$this->file_delete($file_id);
			}
			$this->Redirect('Home/Prize/my_prize');

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