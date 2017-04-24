<?php
namespace Home\Controller;
use Think\Controller;
class ProjectController extends Controller {
	public function my_project(){
		parent::is_login();
		//获取项目类别信息
		$TypeModel=M('Project_type');
		$TypeInfo=$TypeModel->select();
		$TypeInfo=get_project_num($TypeInfo);
		//获取项目总个数
		$AllCount=get_all_project_num($TypeInfo);
		//获取项目详细信息
		$ProjectModel=M('Project');
		$Condition['user_id']=session('uid');
		$ProjectInfo=$ProjectModel->where($Condition)->select();
		$this->assign('TypeInfo',$TypeInfo);
		$this->assign('AllCount',$AllCount);
		$this->display();
	}
}