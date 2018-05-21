<?php

	namespace Home\Controller;

	use Think\Controller;

	class StudentsInfoController extends Controller
	{
		//显示我的科研成果页面
		public function showStudents()
		{
			parent::is_login();

			$this->display();
		}

		public function studentInfo()
		{
			parent::is_login();

			$this->display();
		}

		public function addStu(){
			parent::is_login();
			$this->display();
		}
		public function addStu_db(){
			$trainModel=D('TrainStudent');
			if($trainModel->create()){
				$trainModel->teacherNum=session('userNum');
				$result=$trainModel->add();
				if($result){
					$this->redirect("/Home/StudentsInfo/trainInfo");
				}else{
					$this->error("数据库错误");
				}
			}else{
				$this->error('服务器错误，创建失败');
			}
		}

		public function trainInfo(){
			parent::is_login();
			$trainModel=M('TrainStudent');
			$Condition['teacherNum']=session('userNum');
			$trainList=$trainModel->where($Condition)->select();
			$this->assign("trainList",$trainList);
			$this->display();

		}


	}